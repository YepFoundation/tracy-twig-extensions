<?php
namespace Yep\TracyTwigExtensions;

use Tracy\Debugger;

class BarDumpExtension extends DumpExtension {
	protected $name = 'barDump';

	protected function doDump($data) {
		if (!class_exists('\Tracy\Debugger')) {
			return;
		}

		Debugger::barDump($data, null, $this->options);
	}
}
