<?php

`/usr/bin/env git init`;

$stdIn = fopen("/dev/tty", "r");
fwrite(STDOUT, "Hit enter for default commit message, or [n] to skip commit: ");
$commit = trim(fgets($stdIn));

if (strtolower($commit) == 'n') {
	return;
}
$commit = $commit ?: "Initializing project.";
`/usr/bin/env git add *`;
`/usr/bin/env git commit -am "{$commit}"`;

fwrite(STDOUT, "Enter GitHub repository, i.e. <account>/<repo>: ");
$repo = trim(fgets($stdIn));

if ($repo && strpos($repo, '/')) {
	`/usr/bin/env git remote add origin git@github.com:{$repo}.git`;
	`/usr/bin/env git push -u origin master`;
}
fclose($stdIn);

?>