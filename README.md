# Semver
Simple PHP Semantic Versioning Parser and Comparator

## Installation :

Using Composer: 
```bash
composer require melbahja/semver 1.0.1
```

## Usage :

Simple Example:
```php

require 'vendor/autoload.php';

use Melbahja\Semver\Semver;

$version = Semver::parse('1.3.0-beta+exp.sha.5114f85');

var_dump(
	$version->getMajor(), 	// int 1
	$version->getMinor(), 	// int 3
	$version->getPatch(), 	// int 0
	$version->getRelease(), // string beta
	$version->getMeta(),	// string exp.sha.5114f85
	$version->is('beta'), 	// true
	$version->is('stable') 	// false
);

// compare versions
var_dump(
	$version->compare('1.3.0-beta'), // true
	$version->compare('1.3.0', '<'), // true 1.3.0-beta is smaller than 1.3.0
	$version->compare('1.3.0-alpha') // false
);


``` 

Compare Examples:

```php

var_dump(Semver::compare('1.2.3-alpha', '1.2.3-alpha.1', '<')); // true 1.2.3-alpha is smaller than 1.2.3-alpha.1

$version1 = Semver::parse('1.0.0-alpha.beta');

// $version1->getRelease(); // is alpha.beta

$version2 = Semver::parse('1.0.0-beta.2');

// $version2->getRelease(); // is beta.2

var_dump(Semver::compare($version1, $version2)); // false

var_dump(Semver::compare($version1, $version2, '<')); // true $version1 is smller than $version2

var_dump(Semver::compare($version1, $version2, '<=')); // true


$version3 = Semver::parse('2.2.0-alpha+exp.sha.5114f85');

$version4 = Semver::parse('2.2.0-alpha');

var_dump(Semver::compare($version3, $version4, '=')); // true

```


## License :

[MIT](https://github.com/melbahja/semver/blob/master/LICENSE) Copyright (c) 2018 Mohamed Elbahja