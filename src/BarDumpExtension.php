<?php
namespace Yep\TracyTwigExtensions;

use Tracy\Debugger;
use Tracy\Dumper;

class BarDumpExtension extends \Twig_Extension {
	protected $options;

	public function __construct(array $options = []) {
		$this->options = $options;
	}

	public function getFunctions() {
		return [
			new \Twig_SimpleFunction('barDump', [$this, 'barDump'], ['is_safe' => ['html'], 'needs_context' => true, 'needs_environment' => true]),
		];
	}

	public function getName() {
		return 'barDump';
	}

	public function barDump(\Twig_Environment $environment, $context) {
		if (!$environment->isDebug() || !class_exists('\Tracy\Dumper')) {
			return;
		}

		$arguments = func_get_args();
		array_shift($arguments);
		array_shift($arguments);
		$count = count($arguments);

		if ($count === 0) {
			$arguments = $context;
		}

		if ($count === 1) {
			$arguments = array_shift($arguments);
		}

		Debugger::barDump($arguments, null, $this->options);
	}
}
