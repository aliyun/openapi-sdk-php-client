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

use AlibabaCloud\Client\Request\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Result from Alibaba Cloud
 *
 * @package   AlibabaCloud\Client\Result
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 */
class Result implements \ArrayAccess, \IteratorAggregate, \Countable
{
    use ArrayAccessTrait;
    use HasDataTrait;
    use FormatTrait;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $data = [];

    /**
     * Result constructor.
     *
     * @param Response $response
     * @param Request  $request
     */
    public function __construct(Response $response, Request $request = null)
    {
        $format = ($request instanceof Request) ? \strtoupper($request->format) : 'JSON';

        switch ($format) {
            case 'JSON':
                $this->data = $this->jsonToArray($response->getBody()->getContents());
                break;
            case 'XML':
                $this->data = $this->xmlToArray($response->getBody()->getContents());
                break;
            case 'RAW':
                $this->data = $this->jsonToArray($response->getBody()->getContents());
                break;
            default:
                $this->data = $this->jsonToArray($response->getBody()->getContents());
        }

        if (empty($this->data)) {
            $this->data = [];
        }
        $this->response = $response;
        $this->request  = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return 200 <= $this->response->getStatusCode() && 300 > $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->response->getBody()->getContents();
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!isset($this->data[$name])) {
            return null;
        }
        return \json_decode(\json_encode($this->data))->$name;
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        if (isset($this->data[$name])) {
            $this->data[$name] = $value;
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }
}
