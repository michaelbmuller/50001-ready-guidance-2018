<?php

namespace Tests;

use DOE_50001_2018_Ready\Support;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SupportTest extends TestCase
{
    public function testCovertSectionName()
    {
        static::assertSame('testTest', Support::ConvertSectionName('test test'));
    }

    /**
     * @throws \Exception
     */
    public function testMissingFile()
    {
        $this->expectExceptionMessage('Requested File Not Found');
        Support::getFile('asdf');
    }
}
