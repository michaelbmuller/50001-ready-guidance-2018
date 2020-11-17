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

class Markup
{
    /**
     * Regular Expression identifying resource tag.
     *
     * @var string
     */
    public static $RESOURCE_TAG_PATTERN = '|(\[resource\]\()[^)]+[)]|';
    /**
     * Regular Expression identifying task tag.
     *
     * @var string
     */
    public static $TASK_TAG_PATTERN = '|(\[task\]\()[^)]+[)]|';

    /**
     * Processes markup of current task guidance and returns updated text.
     *
     * @param $text
     * @param string        $markup_processor
     * @param bool|Guidance $guidance
     *
     * @return mixed|string
     */
    public static function process($text, $markup_processor = DefaultMarkupProcessor::class, $guidance = false)
    {
        $text = self::addResourceLinks($text, $markup_processor);
        $text = self::addTaskLinks($text, $markup_processor, $guidance);
        $text = self::addExpandables($text, 'Learn More', $markup_processor);

        return self::addExpandables($text, 'Accordion', $markup_processor);
    }

    /**
     * Update resource tags.
     *
     * @param $text
     * @param string $markup_processor
     *
     * @return mixed
     */
    public static function addResourceLinks($text, $markup_processor = DefaultMarkupProcessor::class)
    {
        return preg_replace_callback(
            self::$RESOURCE_TAG_PATTERN,
            function ($matches) use ($markup_processor) {
                $resource_id = substr($matches[0], 11, -1);

                /** @noinspection PhpUndefinedMethodInspection */
                return $markup_processor::resourceLink($resource_id);
            },
            $text
        );
    }

    /**
     * Update task tags.
     *
     * @param $text
     * @param string        $markup_processor
     * @param bool|Guidance $guidance
     *
     * @return mixed
     */
    public static function addTaskLinks($text, $markup_processor = DefaultMarkupProcessor::class, $guidance = false)
    {
        return preg_replace_callback(
            self::$TASK_TAG_PATTERN,
            function ($matches) use ($markup_processor, $guidance) {
                $task_menu_name = trim(substr($matches[0], 7, -1));

                /** @noinspection PhpUndefinedMethodInspection */
                return $markup_processor::taskLink($task_menu_name, $guidance);
            },
            $text
        );
    }

    /**
     * Update expandable elements tags
     * - Accordion
     * - Learn More.
     *
     * @param $text
     * @param mixed $triggerText
     * @param mixed $markup_processor
     *
     * @return string
     */
    public static function addExpandables($text, $triggerText, $markup_processor = DefaultMarkupProcessor::class)
    {
        $pieces = explode("<p>[{$triggerText}]", $text);
        for ($x = 1; $x <= \count($pieces) - 1; ++$x) {
            $sub_pieces = explode("<p>[{$triggerText} End]</p>", $pieces[$x]);
            $sub_pieces[0] = substr(trim($sub_pieces[0]), 1);
            $regularContent = $sub_pieces[1];
            $sub_sub_pieces = explode(')</p>', $sub_pieces[0]);
            $title = $sub_sub_pieces[0];
            unset($sub_sub_pieces[0]);
            $content = implode(')', $sub_sub_pieces);

            if ('Accordion' === $triggerText) {
                $updatedContent = $markup_processor::accordion('learnMore_' . $x, $title, $content);
            }
            if ('Learn More' === $triggerText) {
                $updatedContent = $markup_processor::learnMore('learnMore_' . $x, $title, $content);
            }

            $pieces[$x] = $updatedContent . $regularContent;
        }

        return implode('', $pieces);
    }
}
