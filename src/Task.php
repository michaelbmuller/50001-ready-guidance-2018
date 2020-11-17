<?php
/**
 * This file is part of the 50001 Ready Guidance package.
 *
 * Written by Michael B Muller <muller.michaelb@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DOE_50001_2018_Ready;

/**
 * Class Task.
 */
class Task
{
    /**
     * Language Code Requested.
     *
     * @var string
     */
    public $language_requested;
    /**
     * Language displayed
     *  - may not be selected language if not available.
     *
     * @var string
     */
    public $language_displayed;
    /**
     * Task file name.
     *
     * @var string
     */
    public $task_file_name;
    /**
     * Task file contents.
     *
     * @var string
     */
    public $task_file_contents;
    /**
     * Section code.
     *
     * @var string
     */
    public $sectionCode;
    /**
     * Task section name
     * - translated if selected and available.
     *
     * @var string
     */
    public $section;
    /**
     * Optional custom tips
     * - default null.
     *
     * @var string
     */
    public $custom_tips;
    /**
     * Array of associated resources.
     *
     * @var
     */
    public $resources = [];
    /**
     * Array of prerequisite task ids.
     *
     * @var array
     */
    public $prerequisites = [];
    /**
     * Array of Tasks this Task leads to.
     *
     * @var array
     */
    public $leadsTo = [];
    /**
     * Array of related ISO sections.
     *
     * @var array
     */
    public $relatedIsoSections = [];
    /**
     * Class name of set task markup processor.
     *
     * @var string
     */
    protected $markupProcessor;
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $version;
    /**
     * @var Guidance
     */
    protected $guidance;
    /**
     * Title
     * - translated if selected and available.
     *
     * @var string
     */
    protected $title;
    /**
     * Menu Name
     * - translated if selected and available.
     *
     * @var string
     */
    protected $menuName;
    /**
     * Getting It Done
     * - translated if selected and available.
     *
     * @var string
     */
    protected $getting_it_done;
    /**
     * Task Overview.
     *
     * @var string
     */
    protected $task_overview;
    /**
     * Full Description.
     *
     * @var
     */
    protected $full_description;
    /**
     * Tips related to other implemented ISO management systems.
     *
     * @var string
     */
    protected $other_iso_tips;
    /**
     * Tips related to previous ENERGY STAR experience.
     *
     * @var string
     */
    protected $energyStar_tips;

    /**
     * Load task.
     *
     * @param $task_id
     * @param bool|Guidance|string $guidance
     * @param string               $markupProcessor
     *
     * @throws \Exception
     *
     * @return Task
     */
    public static function load($task_id, $guidance = false, $markupProcessor = DefaultMarkupProcessor::class)
    {
        if ($task_id < 1 || $task_id > 25) {
            throw new \Exception('Task ID not valid', 404);
        }
        $task = new self();
        $task->id = $task_id;
        $task->guidance = ($guidance instanceof Guidance) ? $guidance : false;
        $task->language_requested = $task->guidance ? $task->guidance->language : ($guidance ?: 'en');
        $task->markupProcessor = $markupProcessor;

        $task->loadFile();

        return $task;
    }

    /**
     * Return ID.
     *
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Return Menu Name.
     *
     * @return mixed|string
     */
    public function getMenuName()
    {
        return $this->menuName;
    }

    /**
     * Return Title.
     *
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returned marked up version of Getting It Done.
     *
     * @return mixed|string
     */
    public function getGettingItDone()
    {
        return Markup::process($this->getting_it_done, $this->markupProcessor, $this->guidance);
    }

    /**
     * Returned marked up version of Task Overview.
     *
     * @return mixed|string
     */
    public function getTaskOverview()
    {
        return Markup::process($this->task_overview, $this->markupProcessor, $this->guidance);
    }

    /**
     * Returned marked up version of Full Description.
     *
     *
     * @return mixed|string
     */
    public function getFullDescription()
    {
        return Markup::process($this->full_description, $this->markupProcessor, $this->guidance);
    }

    /**
     * Returned marked up version of Other ISO tips.
     *
     * @return mixed|string
     */
    public function getOtherIsoTips()
    {
        return Markup::process($this->other_iso_tips, $this->markupProcessor);
    }

    /**
     * Returned marked up version of ENERGY STAR tips.
     *
     * @return mixed|string
     */
    public function getEnergyStarTips()
    {
        return Markup::process($this->energyStar_tips, $this->markupProcessor);
    }

    /**
     * Returned marked up version of custom tips.
     *
     * @return mixed|string
     */
    public function getCustomTips()
    {
        return Markup::process($this->custom_tips, $this->markupProcessor);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Process and load task file data.
     *
     * @throws \Exception
     */
    protected function loadFile()
    {
        $full_id = $this->id < 10 ? '0' . $this->id : $this->id;
        list($this->task_file_contents, $this->language_displayed) = Support::getFile('50001_ready_task_' . $full_id, $this->language_requested);
        $taskPieces = explode('----------', $this->task_file_contents);
        $this->version = trim(explode(' ', $taskPieces[2])[0]);
        $this->menuName = trim($taskPieces[4]);
        $this->title = trim($taskPieces[6]);
        $this->getting_it_done = trim($taskPieces[8]);
        $this->task_overview = trim($taskPieces[10]);
        $this->full_description = trim($taskPieces[12]);
        $this->other_iso_tips = trim($taskPieces[14]);
        $this->energyStar_tips = trim($taskPieces[16]);
    }
}
