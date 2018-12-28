<?php

namespace AlibabaCloud\Client;

use League\CLImate\CLImate;

/*
|--------------------------------------------------------------------------
| Global Functions for Alibaba Cloud
|--------------------------------------------------------------------------
|
 * Some common global functions are defined here.
 * This file will be automatically loaded.
|
*/

/**
 * @param string $string
 *
 * @return void
 */
function backgroundRed($string)
{
    (new CLImate())->br()->backgroundRed($string);
}

/**
 * @param string $string
 *
 * @return void
 */
function backgroundGreen($string)
{
    (new CLImate())->br()->backgroundGreen($string);
}

/**
 * @param string $string
 *
 * @return void
 */
function backgroundBlue($string)
{
    (new CLImate())->br()->backgroundBlue($string);
}

/**
 * @param string $string
 *
 * @return void
 */
function backgroundMagenta($string)
{
    (new CLImate())->br()->backgroundMagenta($string);
}

/**
 * @param array $array
 *
 * @return void
 */
function json($array)
{
    (new CLImate())->br()->backgroundGreen()->json($array);
}

/**
 * @param array $array
 *
 * @return void
 */
function redTable($array)
{
    /**
     * @noinspection PhpUndefinedMethodInspection
     */
    (new CLImate())->redTable($array);
}

/**
 * @param mixed  $result
 * @param string $title
 *
 * @return void
 */
function block($result, $title)
{
    (new CLImate())->br()->backgroundGreen()->flank($title, '--', 20);
    dump($result);
}

/**
 * @param array $arrays
 *
 * @return array
 */
function arrayMerge(array $arrays)
{
    $result = [];
    foreach ($arrays as $array) {
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $result[] = $value;
                continue;
            }

            if (isset($result[$key]) && is_array($result[$key])) {
                $result[$key] = arrayMerge(
                    [$result[$key], $value]
                );
                continue;
            }

            $result[$key] = $value;
        }
    }
    return $result;
}
