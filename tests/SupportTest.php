<?php

namespace Tests;

use DOE_50001_2018_Ready\Support;
use PHPUnit\Framework\TestCase;

class SupportTest extends TestCase
{
    public function test_covert_section_name()
    {
        $this->assertEquals('testTest', Support::ConvertSectionName('test test'));
    }

    /**
     * @throws \Exception
     */
    public function test_missing_file(){
        $this->expectExceptionMessage('Requested File Not Found');
        Support::getFile('asdf');
    }
}