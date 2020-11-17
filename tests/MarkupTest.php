<?php

namespace Tests;

use DOE_50001_2018_Ready\Guidance;
use DOE_50001_2018_Ready\Markup;
use DOE_50001_2018_Ready\Task;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class MarkupTest extends TestCase
{
    public function testResourceMarkup()
    {
        $initialText = 'Asdf [resource](Resource_Name) Asdf';
        $markedUpText = Markup::addResourceLinks($initialText);
        static::assertSame('Asdf Resource Name Asdf', $markedUpText);
    }

    public function testTaskMarkup()
    {
        $initialText = 'Asdf [task](Menu Name) Asdf';
        $markedUpText = Markup::addTaskLinks($initialText);
        static::assertSame('Asdf the Menu Name Task Asdf', $markedUpText);
    }

    public function testAccordions()
    {
        $initialText = 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';

        $markedUpText = Markup::addExpandables($initialText, 'Accordion');
        $accordionChanged = 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';
        static::assertSame($accordionChanged, $markedUpText);

        $markedUpText = Markup::addExpandables($initialText, 'Learn More');
        $learnMoreChanged = 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        static::assertSame($learnMoreChanged, $markedUpText);

        $markedUpText = Markup::addExpandables($initialText, 'Learn More');
        $markedUpText = Markup::addExpandables($markedUpText, 'Accordion');
        $bothChanged = 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        static::assertSame($bothChanged, $markedUpText);

        $markedUpText = Markup::addExpandables('Asdf', 'Learn More');
        $markedUpText = Markup::addExpandables($markedUpText, 'Accordion');
        static::assertSame('Asdf', $markedUpText);
    }

    public function testTaskMarkups()
    {
        $guidance = new Guidance();
        foreach ($guidance->getTasks() as $task) {
            /* @var Task $task */
            static::assertStringNotContainsString('NOT FOUND', $task->getGettingItDone(), 'Task ' . $task->id() . ' | Getting It Done');
            static::assertStringNotContainsString('NOT FOUND', $task->getTaskOverview(), 'Task ' . $task->id() . ' | Task Overview');
            static::assertStringNotContainsString('NOT FOUND', $task->getFullDescription(), 'Task ' . $task->id() . ' | Full Description');
            static::assertStringNotContainsString('NOT FOUND', $task->getOtherIsoTips(), 'Task ' . $task->id() . ' | Other ISO Tips');
            static::assertStringNotContainsString('NOT FOUND', $task->getEnergyStarTips(), 'Task ' . $task->id() . ' | Energy Star Tips');
            static::assertStringNotContainsString('NOT FOUND', $task->getCustomTips(), 'Task ' . $task->id() . ' | Custom Tips');
        }
    }

    /**
     * public function test_task_markups_fr()
     * {
     * $guidance = new Guidance('fr');
     * foreach ($guidance->getTasks() as $task) {
     * /** @var Task $task *
     * /** @var Task $task *
     * $this->assertStringNotContainsString("NOT FOUND",$task->getGettingItDone());
     * $this->assertStringNotContainsString("NOT FOUND",$task->getTaskOverview());
     * $this->assertStringNotContainsString("NOT FOUND",$task->getFullDescription());
     * $this->assertStringNotContainsString("NOT FOUND",$task->getOtherIsoTips());
     * $this->assertStringNotContainsString("NOT FOUND",$task->getEnergyStarTips());
     * $this->assertStringNotContainsString("NOT FOUND",$task->getCustomTips());
     * }
     * } */
    public function testAllMarkups()
    {
        $initialText = 'Asdf [resource](Resource_Name) Asdf'
            . 'Asdf [task](Menu Name) Asdf'
            . 'Asdf <p>[Accordion](Accordion Title)</p> Asdf <p>[Accordion End]</p> Asdf '
            . 'Asdf <p>[Learn More](Learn More Title)</p> Asdf <p>[Learn More End]</p> Asdf ';
        $finalText = 'Asdf Resource Name Asdf'
            . 'Asdf the Menu Name Task Asdf'
            . 'Asdf <h4>Accordion Title</h4> Asdf Asdf '
            . 'Asdf <h4>Learn More Title</h4> Asdf Asdf ';
        static::assertSame($finalText, Markup::process($initialText));
    }
}
