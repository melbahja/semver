<?php
namespace Melbahja\Semver;

class VersionParser
{
	/**
	 * parse string version
	 * @param  string $version
	 * @return Interfaces\VersionInterface
	 */
	public static function parse(string $version): Interfaces\VersionInterface
	{
		return new Version($version);
	}
}
