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
 * @category  AlibabaCloud
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */

namespace AlibabaCloud\Client;

use AlibabaCloud\Client\Clients\Client;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Result\Result;

/**
 * Class DefaultAcsClient
 *
 * @package    AlibabaCloud
 *
 * @author     Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright  Alibaba Group
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link       https://github.com/aliyun/openapi-sdk-php-client
 *
 * @deprecated since version 2.0
 */
class DefaultAcsClient
{

    /**
     * @var string
     */
    public $randClientName;

    /**
     * DefaultAcsClient constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->randClientName = \uniqid('', false);
        $client->name($this->randClientName);
    }

    /**
     * @deprecated
     *
     * @param Request|Result $request
     *
     * @return Result|string
     * @throws ClientException
     * @throws ServerException
     */
    public function getAcsResponse($request)
    {
        if ($request instanceof Result) {
            return $request;
        }

        return $request->client($this->randClientName)->request();
    }
}
