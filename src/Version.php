<?php
namespace Melbahja\Semver;


class Version implements Interfaces\VersionInterface
{
	/**
	 * @var string
	 */
	protected $version

	/**
	 * major
	 * @var integer
	 */
	, $x

	/**
	 * minor
	 * @var integer
	 */
	, $y

	/**
	 * path
	 * @var integer
	 */
	, $z

	/**
	 * build metadata
	 * @var string|null
	 */
	, $meta

	/**
	 * release
	 * @var string|null
	 */
	, $release;

	/**
	 * parse the version
	 * @param string $version
	 */
	public function __construct(string $version)
	{
		$version = explode('-', $version);
		$version[0] = explode('.', $version[0]);

		if (count($version[0]) !== 3) {
			throw new Exceptions\SemverException('version format is not valid');
		}

		$version[0][2] = $version[0][2] ?? 0;

		if ($version[0][2] !== 0 && strpos($version[0][2], '+') !== false) {

			$version[0][2] = explode('+', $version[0][2]);
			$this->z = (int) $version[0][2][0];
			$this->meta = $version[0][2][1] ?? null;
		
		} else {

			$this->z = (int) $version[0][2];
		}

		$this->x = (int) $version[0][0];
		$this->y = (int) $version[0][1] ?? 0;
		$this->version = "{$this->x}.{$this->y}.{$this->z}";

		if ($this->meta === null && isset($version[1])) {

			$version = explode('+', $version[1]);
			
			if ($version[0] !== 'stable') {
				
				$this->release = $version[0];
				$this->version .= "-{$version[0]}";	
			}
			$this->meta = $version[1] ?? null;
		}
	}

	/**
	 * get major version
	 * @return int
	 */
	public function getMajor(): int
	{
		return $this->x;
	}

	/**
	 * get minor version
	 * @return int
	 */
	public function getMinor(): int
	{
		return $this->y;
	}

	/**
	 * get patch 
	 * @return int
	 */
	public function getPatch(): int
	{
		return $this->z;
	}

	/**
	 * get build meta
	 * @return string|null
	 */
	public function getMeta(): ?string
	{
		return $this->meta;
	}

	/**
	 * get release name
	 * @return string|null
	 */
	public function getRelease(): ?string
	{
		return $this->release;
	}

	/**
	 * @param  string $v2
	 * @param  string $c
	 * @return bool
	 */
	public function compare(string $v2, $c = '='): bool
	{
		return Semver::compare($this->version, $v2, $c);
	}

	/**
	 * check version release
	 * @param  string  $release
	 * @return bool
	 */
	public function is(string $release): bool
	{
		if ($release === 'stable') {
			return ($this->x > 0 && $this->release === null);
		}

		return ($this->getRelease() === $release);
		
	}

	/**
	 * parsed version 
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->version;
	}
}
