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

namespace AlibabaCloud\Client\Result;

use Exception;

/**
 * Class FormatTrait
 *
 * @package   AlibabaCloud\Client\Result
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
trait FormatTrait
{
    /**
     * @param string $string
     *
     * @return array
     */
    private function xmlToArray($string)
    {
        try {
            return json_decode(json_encode(simplexml_load_string($string)), true);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private function jsonToArray($response)
    {
        try {
            return \GuzzleHttp\json_decode($response, true);
        } catch (\InvalidArgumentException $e) {
            return [];
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        return \json_encode($this->data);
    }
}
