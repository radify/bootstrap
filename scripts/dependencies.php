#!/usr/bin/env php
<?php

namespace uor\bootstrap;

class Dependencies {

	public static $testSuite = array(
		"behat/behat" => "2.4@stable",
		"behat/mink"  => "1.4@stable",
		"behat/mink-extension" => "*",
		"behat/mink-selenium2-driver" => "*"
	);
}

print_r(Dependencies::$testSuite);

?>