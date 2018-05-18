<?php
namespace Melbahja\Semver\Interfaces;

interface VersionInterface
{

	public function __construct(string $version);

	public function getMajor(): int;

	public function getMinor(): int;

	public function getPatch(): int;

	public function getMeta(): ?string;

	public function getRelease(): ?string;

	public function is(string $release): bool;

	public function compare(string $version, $c = '='): bool;

	public function __toString(): string;
}
