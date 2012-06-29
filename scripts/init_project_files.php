<?php

require "classes/uor/bootstrap/Dependencies.php";
require "classes/uor/bootstrap/GitIgnore.php";

use uor\bootstrap\Dependencies;

$gitIgnore = new uor\bootstrap\GitIgnore($argv[1]);

$gitIgnore->add(array(
	"resources/tmp/cache/templates/*",
	"resources/tmp/cache/*",
	"resources/tmp/logs/*",
	"composer.lock",
	".DS_Store",
	"*.log",
	".vagrant"
));
$gitIgnore->write();

$composerConf = json_decode(file_get_contents("{$argv[1]}/composer.json"), true) + array(
	'require' => array(),
	'autoload' => array()
);

fwrite(STDOUT, "Add dependencies:");

foreach (uor\bootstrap\Dependencies::all() as $title => $value) {
	fwrite(STDOUT, "{$title} [y/n]: ");

	if (trim(strtolower(fread(STDIN, 1))) === 'y') {
		$composerConf['require'] += $value;
	}
}
$newConf = json_encode($composerConf);
$formatted = array();

exec("echo '{$newConf}' | python -c 'import fileinput, json; print(json.dumps(json.loads(\"\".join(fileinput.input())), sort_keys=True, indent=4))'", $formatted);
file_put_contents("{$argv[1]}/composer.json", implode("\n", $formatted));

?>