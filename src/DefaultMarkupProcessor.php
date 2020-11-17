<?php

namespace DOE_50001_2018_Ready;

class DefaultMarkupProcessor implements MarkupProcessorInterface
{
    /**
     * Return resource id as string only.
     *
     * @param $resource_id
     *
     * @return mixed
     */
    public static function resourceLink($resource_id)
    {
        return preg_filter('[_]', ' ', $resource_id);
    }

    /**
     * Return Task Menu Name only.
     *
     * @param $task_id_name
     * @param bool|Guidance $guidance
     *
     * @return string
     */
    public static function taskLink($task_id_name, $guidance = false)
    {
        if ($guidance && !$task = $guidance->getTaskByIDName($task_id_name)) {
            return '[' . $task_id_name . '] TASK NOT FOUND';
        }

        return 'the ' . $task_id_name . ' Task';
    }

    /**
     * Format Accordion tags.
     *
     * @param $code
     * @param $title
     * @param $content
     *
     * @return string
     */
    public static function accordion($code, $title, $content)
    {
        return '<h4>' . $title . '</h4>' . $content;
    }

    /**
     * Format Learn More tags.
     *
     * @param $code
     * @param $title
     * @param $content
     *
     * @return string
     */
    public static function learnMore($code, $title, $content)
    {
        return '<h4>' . $title . '</h4>' . $content;
    }
}
