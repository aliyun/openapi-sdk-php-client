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
 * @category AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */

use AlibabaCloud\Client\AlibabaCloud;
use Symfony\Component\Dotenv\Dotenv;

/*
|--------------------------------------------------------------------------
| Test Entry File for Alibaba Cloud
|--------------------------------------------------------------------------
|
| This file will be automatically loaded.
|
*/

error_reporting(E_ALL);
ini_set('display_errors', '1');
if (!ini_get('date.timezone')) {
    date_default_timezone_set('GMT');
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| We'll simply require it into the script here so that we don't have to
| worry about manual loading any of our classes later on.
|
*/

require dirname(__DIR__) . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Loading environment variable files
|--------------------------------------------------------------------------
|
| If the file exists, load it.
|
*/

$env = __DIR__ . '/../.env';
if (is_readable($env)) {
    $dotenv = new Dotenv();
    $dotenv->load($env);
} else {
    AlibabaCloud::accessKeyClient('key', 'secret')
                ->asGlobalClient()
                ->timeout(4)
                ->connectTimeout(4);
}
AlibabaCloud::setGlobalRegionId('cn-hangzhou');

/*
|--------------------------------------------------------------------------
| Handling environmental variables
|--------------------------------------------------------------------------
|
| If there is no environmental variable, then it is defined randomly.
|
*/
if (!getenv('ACCESS_KEY_ID')) {
    putenv('ACCESS_KEY_ID=foo');
}
if (!getenv('ACCESS_KEY_SECRET')) {
    putenv('ACCESS_KEY_SECRET=bar');
}
if (!getenv('ROLE_ARN')) {
    putenv('ROLE_ARN=role_arn');
}
if (!getenv('ROLE_SESSION_NAME')) {
    putenv('ROLE_SESSION_NAME=role_session_name');
}
if (!getenv('ECS_ROLE_NAME')) {
    putenv('ECS_ROLE_NAME=ecs_role_name');
}
