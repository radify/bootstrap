<?php

namespace uor\bootstrap;

use RuntimeException;

class GitIgnore {

	protected $_path;

	protected $_lines = array();

	public function __construct($path) {
		if (!is_writable($path)) {
			throw new RuntimeException("Path `{$path}` not writeable.");
		}
		$this->_path = "{$path}/.gitignore";
		$this->_lines = array_filter(array_map('trim', file($this->_path)));
	}

	public function add($entries) {
		$entries = (array) $entries;

		foreach ($entries as $entry) {
			if ((in_array($entry = trim($entry), $this->_lines)) || !$entry) {
				continue;
			}
			$this->_lines[] = $entry;
		}
		return $this->_lines;
	}

	public function items() {
		return $this->_lines;
	}

	public function write() {
		return file_put_contents($this->_path, implode("\n", $this->_lines)) > 0;
	}
}

?>