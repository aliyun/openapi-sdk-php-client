<?php

namespace AlibabaCloud\Client;

/*
|--------------------------------------------------------------------------
| Global Functions for Alibaba Cloud
|--------------------------------------------------------------------------
|
| Some common global functions are defined here.
| This file will be automatically loaded.
|
*/

/**
 * @return \League\CLImate\CLImate
 */
function cliMate()
{
    return new \League\CLImate\CLImate();
}

/**
 * @param string      $string
 * @param string|null $flank
 * @param string|null $char
 * @param int|null    $length
 *
 * @return void
 */
function backgroundRed($string, $flank = null, $char = null, $length = null)
{
    cliMate()->br();
    if ($flank !== null) {
        cliMate()->backgroundRed()->flank($flank, $char, $length);
        cliMate()->br();
    }
    cliMate()->backgroundRed($string);
    cliMate()->br();
}

/**
 * @param string      $string
 * @param string|null $flank
 * @param string|null $char
 * @param int|null    $length
 *
 * @return void
 */
function backgroundGreen($string, $flank = null, $char = null, $length = null)
{
    cliMate()->br();
    if ($flank !== null) {
        cliMate()->backgroundGreen()->flank($flank, $char, $length);
    }
    cliMate()->backgroundGreen($string);
    cliMate()->br();
}

/**
 * @param string      $string
 * @param string|null $flank
 * @param string|null $char
 * @param int|null    $length
 *
 * @return void
 */
function backgroundBlue($string, $flank = null, $char = null, $length = null)
{
    cliMate()->br();
    if ($flank !== null) {
        cliMate()->backgroundBlue()->flank($flank, $char, $length);
    }
    cliMate()->backgroundBlue($string);
    cliMate()->br();
}

/**
 * @param string      $string
 * @param string|null $flank
 * @param string|null $char
 * @param int|null    $length
 *
 * @return void
 */
function backgroundMagenta($string, $flank = null, $char = null, $length = null)
{
    cliMate()->br();
    if ($flank !== null) {
        cliMate()->backgroundMagenta()->flank($flank, $char, $length);
    }
    cliMate()->backgroundMagenta($string);
    cliMate()->br();
}

/**
 * @param array $array
 */
function json(array $array)
{
    cliMate()->br();
    cliMate()->backgroundGreen()->json($array);
    cliMate()->br();
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
    cliMate()->redTable($array);
}

/**
 * @param mixed  $result
 * @param string $title
 *
 * @return void
 */
function block($result, $title)
{
    cliMate()->backgroundGreen()->flank($title, '--', 20);
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
