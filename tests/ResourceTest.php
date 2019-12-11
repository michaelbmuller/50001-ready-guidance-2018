<?php

namespace Tests;

use DOE_50001_2018_Ready\Guidance;
use DOE_50001_2018_Ready\Resource;
use PHPUnit\Framework\TestCase;

class ResourceTest extends TestCase
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
    public function setUp(): void
    {
        $this->guidance = new Guidance();
    }

    /**
     * @throws \Exception
     */
    public function test_load_resources()
    {
        $this->assertGreaterThan(0, count($this->guidance->resources));
        $this->assertTrue(isset($this->guidance->resources['Task1_Playbook']));
        $this->assertTrue(isset($this->guidance->resources['Task10_Excel']));
        foreach ($this->guidance->resources as $resource) {
            /** @var $resource Resource */
            if ($resource->file_name) $this->assertFileExists("resourceFiles/" . $resource->file_name);
        }
    }

    public function test_task_resources()
    {
        $this->assertGreaterThan(0, count($this->guidance->getTask(1)->resources));
    }

    public function test_get_link()
    {
        $this->assertEquals('/Energy Consumption Tracker (Task 8) [DOE Draft].xlsx',
            $this->guidance->resources['Task8_Excel']->getLink());
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