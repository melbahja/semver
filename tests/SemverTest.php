<?php

namespace Melbahja\Semver\Tests;

use PHPUnit\Framework\TestCase;
use Melbahja\Semver\{
	Semver,
	Version,
	Interfaces\VersionInterface,
	Exceptions\SemverException
};

class SemverTest extends TestCase
{
	

	public function testParseMethod()
	{
		$this->expectException(SemverException::class);

		$invalid = Semver::parse('1.0');
	}


	public function testSimpleParse()
	{
		$version = Semver::parse('1.0.0');
		
		$this->assertInstanceOf(VersionInterface::class, $version);

		$this->assertSame($version->getMajor(), 1);

		$this->assertSame($version->getMinor(), 0);

		$this->assertSame($version->getPatch(), 0);

		$this->assertNull($version->getRelease());

		$this->assertNull($version->getMeta());
	}


	public function testVersion()
	{
		$versionString = '1.0.1-beta+exp.sha.5114f85';

		$version = Semver::parse($versionString);

		$this->assertSame($version->getMajor(), 1);

		$this->assertSame($version->getMinor(), 0);

		$this->assertSame($version->getPatch(), 1);

		$this->assertSame($version->getRelease(), 'beta');

		$this->assertSame($version->getMeta(), 'exp.sha.5114f85');

		$this->assertTrue($version->is('beta'));

		$this->assertSame((string) $version, explode('+', $versionString)[0]); 


		$version1 = Semver::parse('1.1.0+20130313144700');

		$this->assertSame($version1->getMajor(), 1);
		$this->assertSame($version1->getMinor(), 1);
		$this->assertSame($version1->getPatch(), 0);
		$this->assertNull($version1->getRelease());
		$this->assertSame($version1->getMeta(), '20130313144700');
		$this->assertTrue($version1->is('stable'));

	}


	public function testSimpleCompare()
	{
		$version1 = new Version('2.0.3-dev+exp.sha.5114f85');
		$version2 = Semver::parse('2.0.3-alpha');

		$this->assertInstanceOf(get_class($version1), $version2);

		$this->assertFalse(Semver::compare($version2, $version1));

		$this->assertFalse(Semver::compare('2.0.3-dev+exp.sha.5114f85', '2.0.3-alpha'));

		$this->assertTrue(Semver::compare($version1, $version2, '<'));

		$this->assertTrue(Semver::compare(
			Semver::parse('2.0.3-dev'),
			$version1
		));

		$this->assertTrue($version1->compare('2.0.3-dev'));

		$this->assertFalse($version1->compare('2.0.3-dev.1'));

		$this->assertTrue(Semver::compare($version1, '2.0.3-dev+exp.sha.5114f85'));
	}


	public function testCompareAndChecking()
	{
		$version1 = Semver::parse('1.1.0-alpha+20130313144700');

		$this->assertFalse($version1->is('stable'));

		$this->assertTrue($version1->compare('1.0.0', '>'));

		$this->assertTrue($version1->compare('1.1.0-alpha'));

		$version2 = new Version('1.1.0-alpha');

		$this->assertTrue($version2->compare($version1));


		$this->assertTrue(Semver::compare($version1, $version2));
		$this->assertTrue(Semver::compare($version1, $version2, '>='));

		$this->assertFalse(Semver::compare($version1, $version2, '>'));
	}
}
