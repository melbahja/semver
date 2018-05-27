<?php

namespace Melbahja\Semver\Tests;

use PHPUnit\Framework\TestCase;
use Melbahja\Semver\{
    VersionParser,
    Version
};

class VersionParserTest extends TestCase
{
    public function testParse()
    {
        $parseResult = VersionParser::parse('5.6.33');

        $this->assertInstanceOf(Version::class, $parseResult);
        $this->assertSame('5.6.33', (string) $parseResult);
    }
}
