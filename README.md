[![Build Status](https://travis-ci.org/YepFoundation/tracy-twig-extensions.svg?branch=master)](https://travis-ci.org/YepFoundation/tracy-twig-extensions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/YepFoundation/tracy-twig-extensions/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/YepFoundation/tracy-twig-extensions/?branch=master)
[![Scrutinizer Code Coverage](https://scrutinizer-ci.com/g/YepFoundation/tracy-twig-extensions/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/YepFoundation/tracy-twig-extensions/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/yep/tracy-twig-extensions/v/stable)](https://packagist.org/packages/yep/tracy-twig-extensions)
[![Total Downloads](https://poser.pugx.org/yep/tracy-twig-extensions/downloads)](https://packagist.org/packages/yep/tracy-twig-extensions)
[![License](https://poser.pugx.org/yep/tracy-twig-extensions/license)](https://github.com/YepFoundation/tracy-twig-extensions/blob/master/LICENSE.md)

# Tracy Twig extensions ([docs](http://yepfoundation.github.io/tracy-twig-extensions))

## [Tracy](https://tracy.nette.org) [Twig](http://twig.sensiolabs.org/) extensions
Tracy Twig extensions are available on [Packagist.org](https://packagist.org/packages/yep/tracy-twig-extensions),
just add the dependency to your composer.json.

```json
{
  "require" : {
    "yep/tracy-twig-extensions": "dev-master"
  }
}
```

or run Composer command:

```php
php composer.phar require yep/tracy-twig-extensions
```

## Usage
### First, you must enable debug in Twig Environment.

```php
<?php
$loader = new Twig_Loader_Filesystem(__DIR__);
$twig = new Twig_Environment($loader, ['debug' => true]);
```

### Second, you must add extensions into Twig Environment.

For \Tracy\Dumper::dump
```php
<?php
use Yep\TracyTwigExtensions\DumpExtension;
$twig->addExtension(new DumpExtension());

// You can specify dump options
$options = [
	Tracy\Dumper::DEPTH => 5,
	Tracy\Dumper::TRUNCATE => 500
];
$twig->addExtension(new DumpExtension($options));
```

For \Tracy\Debugger::barDump
```php
<?php
use Yep\TracyTwigExtensions\BarDumpExtension;
$twig->addExtension(new BarDumpExtension());

// You can specify dump options
$options = [
	Tracy\Dumper::DEPTH => 5,
	Tracy\Dumper::TRUNCATE => 500
];
$twig->addExtension(new BarDumpExtension($options));
```

### Third, use in templates
```twig
{% for i in 1..3 %}
	{{ dump(i) }} // dump single variable
{% endfor %}

{{ dump(variable,'bar') }}  // dump multiple variables

{{ dump() }} // dump all variables from the current context
```
or
```twig
{% for i in 1..3 %}
	{{ barDump(i) }} // dump single variable
{% endfor %}

{{ barDump(variable,'bar') }}  // dump multiple variables

{{ barDump() }} // dump all variables from the current context
```
