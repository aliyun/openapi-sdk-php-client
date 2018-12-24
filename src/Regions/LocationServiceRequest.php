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

namespace AlibabaCloud\Client\Regions;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Request\Request;
use AlibabaCloud\Client\Request\RpcRequest;

/**
 * LocationServiceRequest
 *
 * @package AlibabaCloud\Client\Credentials\Providers
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */
class LocationServiceRequest extends RpcRequest
{

    /**
     * LocationServiceRequest constructor.
     *
     * @param Request $request
     * @param string  $domain
     *
     * @throws ClientException
     */
    public function __construct(Request $request, $domain)
    {
        $this->product('Location');
        $this->version('2015-06-12');
        $this->action('DescribeEndpoints');
        $this->regionId(LOCATION_SERVICE_REGION);
        $this->format('JSON');
        $this->options['query']['Id']          = $request->realRegionId();
        $this->options['query']['ServiceCode'] = $request->locationServiceCode;
        $this->options['query']['Type']        = $request->locationEndpointType;
        $this->client($request->clientName);
        $this->domain($domain);
        if (isset($request->options['timeout'])) {
            $this->timeout($request->options['timeout']);
        }

        if (isset($request->options['connect_timeout'])) {
            $this->connectTimeout($request->options['connect_timeout']);
        }
        parent::__construct();
    }
}
