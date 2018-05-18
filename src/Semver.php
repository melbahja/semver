<?php
namespace Melbahja\Semver;


class Semver
{

	/**
	 * parse version
	 * @param  string $version
	 * @return Interfaces\VersionInterface
	 */
	public static function parse(string $version): Interfaces\VersionInterface
	{
		return new Version($version);
	}

	/**
	 * compare two versions
	 * @param  string $v1
	 * @param  string $v2
	 * @param  string $c
	 * @return bool    
	 */
	public static function compare(string $v1, string $v2, string $c = '='): bool
	{
		return version_compare($v1, $v2, $c);
	}

}
