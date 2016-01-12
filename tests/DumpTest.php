<?php
namespace {

	use Yep\Reflection\ReflectionClass;
	use Yep\TracyTwigExtensions\DumpExtension;

	class DumpTest extends PHPUnit_Framework_TestCase {
		public function testDump() {
			$loader = new Twig_Loader_Filesystem(__DIR__);
			$twig = new Twig_Environment($loader, ['debug' => true]);
			$twig->addExtension(new DumpExtension());

			$this->assertSame(
				'[1,[]][2,[]][3,[]][["foo","bar"],[]][{"bar":"baz"},[]]',
				preg_replace('~\s+~', '$1', $twig->render('Dump.twig', ['bar' => 'baz']))
			);
		}

		public function testDumpWithoutDebug() {
			$loader = new Twig_Loader_Filesystem(__DIR__);
			$twig = new Twig_Environment($loader);
			$twig->addExtension(new DumpExtension());

			$this->assertSame('', trim($twig->render('Dump.twig', ['bar' => 'baz'])));
		}

		public function testOptions() {
			$extension = new DumpExtension(['foo']);

			$this->assertSame(['foo'], ReflectionClass::from($extension)->getPropertyValue('options'));
		}
	}
}

namespace Tracy {

	class Dumper {
		public static function dump() {
			echo json_encode(func_get_args());
		}
	}
}
