<?php
namespace Yep\TracyTwigExtensions;

use Tracy\Dumper;

class DumpExtension extends \Twig_Extension {
	protected $name = 'dump';
	protected $options;

	public function __construct(array $options = []) {
		$this->options = $options;
	}

	public function getFunctions() {
		return [
			new \Twig_SimpleFunction($this->name, [$this, 'dump'], ['is_safe' => ['html'], 'needs_context' => true, 'needs_environment' => true]),
		];
	}

	public function getName() {
		return $this->name;
	}

	public function dump(\Twig_Environment $environment, $context) {
		if (!$environment->isDebug()) {
			return '';
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

		return $this->doDump($arguments);
	}

	protected function doDump($data) {
		if (!class_exists('\Tracy\Dumper')) {
			return '';
		}

		ob_start();
		Dumper::dump($data, $this->options);

		return ob_get_clean();
	}
}
