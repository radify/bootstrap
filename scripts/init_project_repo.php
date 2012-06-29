<?php

`/usr/bin/env git init`;

fwrite(STDOUT, "Hit enter for default commit message, or [n] to skip commit: ");
$commit = trim(fread(STDIN, 1024));

if (strtolower($commit) !== 'n') {
	$commit = $commit ?: "Initializing project.";
	`/usr/bin/env git add *`;
	`/usr/bin/env git commit -am "{$commit}"`;

	fwrite(STDOUT, "Enter GitHub repository, i.e. <account>/<repo>: ");
	$repo = trim(fread(STDIN, 1024));

	if ($repo && strpos($repo, '/')) {
		`/usr/bin/env git remote add origin git@github.com:{$repo}.git`;
		`/usr/bin/env git push -u origin master`;
	}
}

?>