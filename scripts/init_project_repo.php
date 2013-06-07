<?php
$stdIn = fopen("/dev/tty", "r");
$bare = !`git branch`;

$changed = $bare || `git status --porcelain`;
echo `git diff-index --name-only HEAD --`;
if (!$changed) {
	fclose($stdIn);
	return;
}
echo "\e[0;33mThe following changes has been made in your repository:\e[0;m\n";
echo `git status`;

echo "\e[0;33mHit enter for default commit message, or [n] to skip the `git add -A` commit:\e[0;m ";
$commit = trim(fgets($stdIn));

if (strtolower($commit) === 'n') {
	fclose($stdIn);
	return;
}

$commit = $commit ?: ($bare ? "Initializing project." : "Updating the repository.");
`/usr/bin/env git add -A`;
`/usr/bin/env git commit -am "{$commit}"`;

echo "\e[0;33mDo you wan't to push changes on origin master ? [Y/n]:\e[0;m ";
$answer = trim(strtolower(fgets($stdIn)));
if ($answer && $answer !== 'y') {
	fclose($stdIn);
	return;
}

$origin = trim(`git remote | grep "origin"`);
if ($origin !== "origin") {
	echo "Enter the origin remote GitHub repository, i.e. <account>/<repo>: ";
	$repo = trim(fgets($stdIn));
	if ($repo && strpos($repo, '/')) {
		`/usr/bin/env git remote add origin git@github.com:{$repo}.git`;
	}
}

echo "Check if the origin remote exists...\n";
$origin = `git ls-remote origin`;
if ($origin) {
	echo "\e[0;33mPush to origin master\e[0;m\n";
	`/usr/bin/env git push -u origin master`;
} else {
	echo "\e[0;31mError: Your origin repository is invalid.\e[0;m\n";
}

fclose($stdIn);
?>