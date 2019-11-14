<?php

namespace Tests;

use DOE_50001_2018_Ready\Guidance;
use DOE_50001_2018_Ready\Task;
use PHPUnit\Framework\TestCase;

class GuidanceTest extends TestCase
{
    /**
     * @var Guidance
     */
    protected $guidance;

    /**
     * GuidanceTest constructor.
     */
    public function setUp(): void
    {
        $this->guidance = new Guidance();
    }

    public function test_alternate_language()
    {
        $guidance = new Guidance('es');
        $this->assertEquals('es', $guidance->language);
        $this->assertEquals('es', $guidance->getTask(1)->language_displayed);
    }

    public function test_guidance_get_all_tasks()
    {
        foreach ($this->guidance->getTasks() as $task_id => $task) {
            $this->assertInstanceOf(Task::class, $task);
            $this->assertEquals($task_id, $task->id());
        }
    }

    public function test_guidance_get_section_tasks()
    {
        foreach ($this->guidance->getTasks('planning') as $task_id => $task) {
            $this->assertInstanceOf(Task::class, $task);
            $this->assertEquals($task_id, $task->id());
            $this->assertEquals('Planning', $task->section);
        }
    }

    public function test_get_task()
    {
        $this->assertEquals(1, $this->guidance->getTask(1)->id());
    }

    public function test_task_by_id_name()
    {
        $this->assertEquals('1', $this->guidance->getTaskByIDName('An EnMS and Your Organization')->id());
    }

    public function test_sections()
    {
        $currentSections = [
            'contextOfTheOrganization' => ['Context of the Organization', 1, 3],
            'leadership' => ['Leadership', 4, 3],
            'planning' => ['Planning', 7, 7],
            'support' => ['Support', 14, 3],
            'operation' => ['Operation', 17, 3],
            'performanceEvaluation' => ['Performance Evaluation', 20, 4],
            'improvement' => ['Improvement', 24, 2],
        ];
        $this->assertEquals($currentSections, $this->guidance->getSections());
    }

    public function test_section_name()
    {
        $this->assertEquals('Planning', $this->guidance->getSectionName('planning'));
    }

    public function test_previous_section()
    {
        $previousSection = $this->guidance->previousSection('contextOfTheOrganization');
        $this->assertEquals('dashboard', $previousSection);
        $previousSection = $this->guidance->previousSection('operation');
        $this->assertEquals('support', $previousSection);
    }

    public function test_next_section()
    {
        $previousSection = $this->guidance->nextSection('contextOfTheOrganization');
        $this->assertEquals('leadership', $previousSection);
        $previousSection = $this->guidance->nextSection('improvement');
        $this->assertEquals('dashboard', $previousSection);
    }

    public function test_iso_sections()
    {
        $tasks = $this->guidance->getTasksByISO('8.3');
        $this->assertEquals(19, $tasks[0]->id());
    }

    public function test_task_leads_to()
    {
        $this->assertEquals([8 => 8], $this->guidance->getTask(3)->leadsTo);
    }

    public function test_set_custom_tips()
    {
        $this->guidance->setCustomTips([
            1 => 'Something Useful',
            5 => 'Something Else Useful'
        ]);
        $this->assertTrue($this->guidance->custom_tips_added);
        $this->assertEquals('Something Useful', $this->guidance->getTask(1)->custom_tips);
        $this->assertEquals('Something Else Useful', $this->guidance->getTask(5)->custom_tips);
    }
}