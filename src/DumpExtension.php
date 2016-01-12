<?php
namespace Yep\TracyTwigExtensions;

use Tracy\Dumper;

class DumpExtension extends \Twig_Extension {
	protected $options;

	public function __construct(array $options = []) {
		$this->options = $options;
	}

	public function getFunctions() {
		return [
			new \Twig_SimpleFunction('dump', [$this, 'dump'], ['is_safe' => ['html'], 'needs_context' => true, 'needs_environment' => true]),
		];
	}

	public function getName() {
		return 'dump';
	}

	public function dump(\Twig_Environment $environment, $context) {
		if (!$environment->isDebug() || !class_exists('\Tracy\Dumper')) {
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

		ob_start();
		Dumper::dump($arguments, $this->options);

		return ob_get_clean();
	}
}
