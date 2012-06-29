<?php

namespace uor\bootstrap;

class Dependencies {

	protected static $_testSuite = array(
		"behat/behat" => "2.4@stable",
		"behat/mink"  => "1.4@stable",
		"behat/mink-extension" => "*",
		"behat/mink-selenium2-driver" => "*"
	);

	public static function all() {
		return array(
			'Test suite' => static::$_testSuite
		);
	}
}

?>