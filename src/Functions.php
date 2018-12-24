<?php
/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * --------------------------------------------------------------------------
 *
 * PHP version 5
 *
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

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
    /** @noinspection PhpUndefinedMethodInspection */
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
