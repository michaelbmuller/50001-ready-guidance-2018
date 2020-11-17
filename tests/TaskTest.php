<?php

namespace Tests;

use DOE_50001_2018_Ready\Task;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class TaskTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testTask()
    {
        $task = Task::load(1);
        static::assertSame(1, $task->id());
        static::assertSame('en', $task->language_requested);
        static::assertSame('en', $task->language_displayed);
        static::assertSame('An EnMS and Your Organization', $task->getMenuName());
    }

    /**
     * @throws \Exception
     */
    public function testLoadAllTasks()
    {
        for ($task_id = 1; $task_id <= 25; ++$task_id) {
            $task = Task::load($task_id);
            static::assertSame($task_id, $task->id());
        }
    }

    /**
     * @throws \Exception
     */
    public function testDefaultToEnglish()
    {
        $task = Task::load(1, 'XX');
        static::assertSame('XX', $task->language_requested);
        static::assertSame('en', $task->language_displayed);
    }

//    public function test_spanish()
//    {
//        $task = Task::load(1, 'es');
//        $this->assertEquals('es', $task->language_requested);
//        $this->assertEquals('es', $task->language_displayed);
//    }

    /**
     * @throws \Exception
     */
    public function testMissingTask()
    {
        $this->expectExceptionMessage('Task ID not valid');
        Task::load(0);
    }

    /**
     * @throws \Exception
     */
    public function testMissingTask2()
    {
        $this->expectExceptionMessage('Task ID not valid');
        Task::load(26);
    }
}
