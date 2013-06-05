<?php
echo "Creating build files and directories...\n";

$pwd = $argv[1];

if (!`/usr/bin/env git status 2> /dev/null`) {
	echo "Initializing the repository.\n";
	`/usr/bin/env git init`;
}

require "{$argv[2]}/scripts/init_project_files.php";

echo "Loading submodules...\n";
`/usr/bin/env git submodule update --init --recursive`;

if (file_exists("{$pwd}/composer.json")) {
	require "{$argv[2]}/scripts/init_project_deps.php";
} else {
	$lithium = "/usr/bin/env git submodule add git@github.com:UnionOfRAD/lithium.git {$pwd}/libraries/lithium";
	if (!file_exists("{$pwd}/.gitmodules")) {
		echo "Installing lithium as a submodule.\n";
		`$lithium`;
	} else {
		echo "Adding lithium as a submodule.\n";
		`cat .gitmodules | grep 'UnionOfRAD/lithium.git' > /dev/null || $lithium`;
	}
}

echo "Setting permissions...\n";
`sudo chmod -R 777 ./resources`;

require "{$argv[2]}/scripts/init_project_repo.php";

echo "Complete...\n";
?>