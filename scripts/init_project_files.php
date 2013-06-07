<?php
require "classes/uor/bootstrap/GitIgnore.php";

$pwd = $argv[1];
$bootstrap = $argv[2];

if (!file_exists("{$pwd}/.gitignore")) {
	`touch {$pwd}/.gitignore 2> /dev/null`;
}

$gitIgnore = new uor\bootstrap\GitIgnore($pwd);

$gitIgnore->add(array(
	"resources/tmp/*",
	"_bootstrap",
	"composer.lock",
	".DS_Store",
	"*.log",
	".vagrant"
));
$gitIgnore->write();

if (!file_exists("{$pwd}/composer.json")) {
	$stdIn = fopen("/dev/tty", "r");
	echo "\e[0;33mDo you wan't to manage your dependencies with Composer [Y/n]:\e[0;m ";
	$answer = trim(strtolower(fgets($stdIn)));
	if (!$answer || $answer === 'y') {
		`cp {$bootstrap}/resources/composer.json {$pwd}/composer.json`;
	}
	fclose($stdIn);
}

if (!file_exists("{$pwd}/Vagrantfile")) {
	`cp {$bootstrap}/resources/Vagrantfile {$pwd}/Vagrantfile`;
}

if (!file_exists("{$pwd}/_build")) {
	`mkdir {$pwd}/_build 2> /dev/null`;
	`mkdir {$pwd}/_build/bin 2> /dev/null`;
	`touch {$pwd}/_build/bin/empty 2> /dev/null`;
	`mkdir {$pwd}/_build/manifests 2> /dev/null`;
	`cp {$bootstrap}/resources/manifests/default.conf {$pwd}/_build/manifests/default.conf 2> /dev/null`;
	`cp {$bootstrap}/resources/manifests/default.pp {$pwd}/_build/manifests/default.pp 2> /dev/null`;
	`cp {$bootstrap}/resources/manifests/php.ini {$pwd}/_build/manifests/php.ini 2> /dev/null`;
	`cp {$bootstrap}/resources/test {$pwd}/_build/test 2> /dev/null`;
}

`cp {$bootstrap}/init {$pwd}/init 2> /dev/null`;

if (!file_exists("{$pwd}/libraries")) {
	`mkdir {$pwd}/libraries 2> /dev/null`;
}
?>