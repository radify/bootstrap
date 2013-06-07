<?php
require "classes/uor/bootstrap/Dependencies.php";

$pwd = $argv[1];

$composerCurrentConf = array();

if (file_exists("{$pwd}/composer.json")) {
	$composerCurrentConf = json_decode(file_get_contents("{$pwd}/composer.json"), true);
}

$composerConf = $composerCurrentConf  + array(
	'require' => array(),
	'autoload' => array()
);

echo "Add dependencies:\n";

$stdIn = fopen("/dev/tty", "r");
foreach (uor\bootstrap\Dependencies::all() as $title => $value) {
	echo "{$title} [y/N]: ";
	if (trim(strtolower(fgets($stdIn))) === 'y') {
		$composerConf['require'] += $value;
	}
}
fclose($stdIn);

if (!empty($composerConf['require'])) {
	$composerConf = array_filter($composerConf);
	$newConf = json_encode($composerConf);
	$formatted = array();

	exec("echo '{$newConf}' | python -c 'import fileinput, json; print(json.dumps(json.loads(\"\".join(fileinput.input())), sort_keys=True, indent=4))'", $formatted);
	file_put_contents("{$pwd}/composer.json", implode("\n", $formatted));
}

echo "\n\e[0;32mLoading dependencies...\e[0;m\n";
if (file_exists("{$argv[1]}/composer.json")) {
	echo "Initializing Composer...\n";
	`cp {$bootstrap}/scripts/composer.phar {$pwd}/composer.phar 2> /dev/null`;
	system('/usr/bin/env php composer.phar self-update');
	echo "Installing Composer dependencies...\n";
	`rm -rf composer.lock`;
	system('/usr/bin/env php composer.phar install');
}
?>