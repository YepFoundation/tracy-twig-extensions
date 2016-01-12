<?php
namespace {

	use Tracy\Debugger;
	use Yep\Reflection\ReflectionClass;
	use Yep\TracyTwigExtensions\BarDumpExtension;

	class BarDumpTest extends PHPUnit_Framework_TestCase {
		public function testBarDump() {
			$loader = new Twig_Loader_Filesystem(__DIR__);
			$twig = new Twig_Environment($loader, ['debug' => true]);
			$twig->addExtension(new BarDumpExtension());

			Debugger::$data = [];

			$this->assertSame('', trim($twig->render('BarDump.twig', ['bar' => 'baz'])));
			$this->assertSame('[1,null,[]][2,null,[]][3,null,[]][["foo","bar"],null,[]][{"bar":"baz"},null,[]]', implode('', Debugger::$data));
		}

		public function testBarDumpWithoutDebug() {
			$loader = new Twig_Loader_Filesystem(__DIR__);
			$twig = new Twig_Environment($loader);
			$twig->addExtension(new BarDumpExtension());

			Debugger::$data = [];

			$this->assertSame('', trim($twig->render('BarDump.twig', ['bar' => 'baz'])));
			$this->assertSame('', implode('', Debugger::$data));
		}

		public function testOptions() {
			$extension = new BarDumpExtension(['foo']);

			$this->assertSame(['foo'], ReflectionClass::from($extension)->getPropertyValue('options'));
		}
	}
}

namespace Tracy {

	class Debugger {
		public static $data = [];

		public static function barDump() {
			self::$data[] = json_encode(func_get_args());
		}
	}
}
