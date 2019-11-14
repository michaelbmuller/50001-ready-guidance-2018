<?php

namespace Tests;

use DOE_50001_2018_Ready\Guidance;
use DOE_50001_2018_Ready\Markup;
use DOE_50001_2018_Ready\Task;
use PHPUnit\Framework\TestCase;

class MarkupTest extends TestCase
{
    public function test_resource_markup()
    {
        $initialText = 'Asdf [resource](Resource_Name) Asdf';
        $markedUpText = Markup::addResourceLinks($initialText);
        $this->assertEquals('Asdf Resource Name Asdf', $markedUpText);
    }

    public function test_task_markup()
    {
        $initialText = 'Asdf [task](Menu Name) Asdf';
        $markedUpText = Markup::addTaskLinks($initialText);
        $this->assertEquals('Asdf the Menu Name Task Asdf', $markedUpText);
    }

    public function test_accordions()
    {
        $initialText = 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';

        $markedUpText = Markup::addExpandables($initialText, 'Accordion');
        $accordionChanged = 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';
        $this->assertEquals($accordionChanged, $markedUpText);

        $markedUpText = Markup::addExpandables($initialText, 'Learn More');
        $learnMoreChanged = 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        $this->assertEquals($learnMoreChanged, $markedUpText);

        $markedUpText = Markup::addExpandables($initialText, 'Learn More');
        $markedUpText = Markup::addExpandables($markedUpText, 'Accordion');
        $bothChanged = 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        $this->assertEquals($bothChanged, $markedUpText);

        $markedUpText = Markup::addExpandables('Asdf', 'Learn More');
        $markedUpText = Markup::addExpandables($markedUpText, 'Accordion');
        $this->assertEquals('Asdf', $markedUpText);
    }

    public function test_task_markups()
    {
        $guidance = new Guidance();
        foreach ($guidance->getTasks() as $task) {
            /** @var Task $task */
            $this->assertStringNotContainsString("NOT FOUND",$task->getGettingItDone(),'Task '.$task->id().' | Getting It Done');
            $this->assertStringNotContainsString("NOT FOUND",$task->getTaskOverview(), 'Task '.$task->id().' | Task Overview');
            $this->assertStringNotContainsString("NOT FOUND",$task->getFullDescription($guidance), 'Task '.$task->id().' | Full Description');
            $this->assertStringNotContainsString("NOT FOUND",$task->getOtherIsoTips(), 'Task '.$task->id().' | Other ISO Tips');
            $this->assertStringNotContainsString("NOT FOUND",$task->getEnergyStarTips(), 'Task '.$task->id().' | Energy Star Tips');
            $this->assertStringNotContainsString("NOT FOUND",$task->getCustomTips(), 'Task '.$task->id().' | Custom Tips');
        }
    }

    /**
    public function test_task_markups_fr()
    {
        $guidance = new Guidance('fr');
        foreach ($guidance->getTasks() as $task) {
            /** @var Task $task *
            $this->assertStringNotContainsString("NOT FOUND",$task->getGettingItDone());
            $this->assertStringNotContainsString("NOT FOUND",$task->getTaskOverview());
            $this->assertStringNotContainsString("NOT FOUND",$task->getFullDescription());
            $this->assertStringNotContainsString("NOT FOUND",$task->getOtherIsoTips());
            $this->assertStringNotContainsString("NOT FOUND",$task->getEnergyStarTips());
            $this->assertStringNotContainsString("NOT FOUND",$task->getCustomTips());
        }
    }

    public function test_task_markups_es()
    {

        $guidance = new Guidance('es');
        foreach ($guidance->getTasks() as $task) {
            /** @var Task $task *
            $this->assertStringNotContainsString("NOT FOUND",$task->getGettingItDone());
            $this->assertStringNotContainsString("NOT FOUND",$task->getTaskOverview());
            $this->assertStringNotContainsString("NOT FOUND",$task->getFullDescription());
            $this->assertStringNotContainsString("NOT FOUND",$task->getOtherIsoTips());
            $this->assertStringNotContainsString("NOT FOUND",$task->getEnergyStarTips());
            $this->assertStringNotContainsString("NOT FOUND",$task->getCustomTips());
        }
    } */

    public function test_all_markups()
    {

        $initialText = 'Asdf [resource](Resource_Name) Asdf'
            . 'Asdf [task](Menu Name) Asdf'
            . 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';
        $finalText = 'Asdf Resource Name Asdf'
            . 'Asdf the Menu Name Task Asdf'
            . 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        $this->assertEquals($finalText, Markup::process($initialText));

    }


}
