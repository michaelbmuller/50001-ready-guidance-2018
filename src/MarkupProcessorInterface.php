<?php
/**
 * This file is part of the 50001 Ready Guidance package.
 *
 * Copyright Michael B Muller, 2017
 *
 * Initially written by Michael B Muller <muller.michaelb@gmail.com>
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */

namespace DOE_50001_2018_Ready;

interface MarkupProcessorInterface
{
    /**
     * Return resource id as string only.
     *
     * @param $resource_id
     *
     * @return mixed
     */
    public static function resourceLink($resource_id);

    /**
     * Return Task Menu Name only.
     *
     * @param $task_id_name
     * @param bool|Guidance $guidance
     *
     * @return string
     */
    public static function taskLink($task_id_name, $guidance = false);

    /**
     * Format Accordion tags.
     *
     * @param $code
     * @param $title
     * @param $content
     *
     * @return string
     */
    public static function accordion($code, $title, $content);

    /**
     * Format Learn More tags.
     *
     * @param $code
     * @param $title
     * @param $content
     *
     * @return string
     */
    public static function learnMore($code, $title, $content);
}
