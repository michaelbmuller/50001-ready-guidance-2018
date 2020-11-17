<?php

namespace Tests;

use DOE_50001_2018_Ready\Guidance;
use DOE_50001_2018_Ready\Resource;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ResourceTest extends TestCase
{
    /**
     * @var Guidance
     */
    protected $guidance;

    /**
     * GuidanceTest constructor.
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->guidance = new Guidance();
    }

    /**
     * @throws \Exception
     */
    public function testLoadResources()
    {
        static::assertGreaterThan(0, \count($this->guidance->resources));
        static::assertTrue(isset($this->guidance->resources['Task1_Playbook']));
        static::assertTrue(isset($this->guidance->resources['Task10_Excel']));
        foreach ($this->guidance->resources as $resource) {
            /** @var Resource $resource */
            if ($resource->file_name) {
                static::assertFileExists('resourceFiles/' . $resource->file_name);
            }
        }
    }

    public function testTaskResources()
    {
        static::assertGreaterThan(0, \count($this->guidance->getTask(8)->resources));
    }

    public function testGetLink()
    {
        static::assertSame(
            '/Energy Consumption Tracker (Task 8) [ET.08.01.00].xlsx',
            $this->guidance->resources['Task8_Excel']->getLink()
        );
    }

//    /**
//     * @throws \Exception
//     */
//    public function test_load_ES_resources()
//    {
//
//        $this->guidance = new Guidance('es');
//        $this->assertGreaterThan(0, count($this->guidance->resources));
//
//        $this->assertTrue(isset($this->guidance->resources['Business_Drivers_EnMS']));
//        $this->assertTrue(isset($this->guidance->resources['50001Ready_PortfolioManager']));
//        foreach ($this->guidance->resources as $resource) {
//            /** @var $resource Resource */
//            if ($resource->file_name) $this->assertFileExists("resourceFiles/" . $resource->file_name);
//        }
//    }

//    /**
//     * @throws \Exception
//     */
//    public function test_load_FR_resources()
//    {
//
//        $this->guidance = new Guidance('fr');
//        $this->assertGreaterThan(0, count($this->guidance->resources));
//
//        $this->assertTrue(isset($this->guidance->resources['Business_Drivers_EnMS']));
//        foreach ($this->guidance->resources as $resource) {
//            /** @var $resource Resource */
//            if ($resource->file_name) $this->assertFileExists("resourceFiles/" . $resource->file_name);
//        }
//    }
}
