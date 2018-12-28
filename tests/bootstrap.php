<?php

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
}

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

if (!getenv('NLP_ACCESS_KEY_ID')) {
    putenv('NLP_ACCESS_KEY_ID=foo');
}
if (!getenv('NLP_ACCESS_KEY_SECRET')) {
    putenv('NLP_ACCESS_KEY_SECRET=bar');
}

if (!getenv('JP_ACCESS_KEY_ID')) {
    putenv('JP_ACCESS_KEY_ID=foo');
}
if (!getenv('JP_ACCESS_KEY_SECRET')) {
    putenv('JP_ACCESS_KEY_SECRET=bar');
}

if (!getenv('BEARER_TOKEN')) {
    putenv('BEARER_TOKEN=token');
}
if (!getenv('CCC_INSTANCE_ID')) {
    putenv('CCC_INSTANCE_ID=ID');
}

if (!getenv('PUBLIC_KEY_ID')) {
    putenv('PUBLIC_KEY_ID=public_key_id');
}
