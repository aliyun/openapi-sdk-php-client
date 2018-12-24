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
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\Request\Request;

/**
 * Class LocationService
 *
 * @package AlibabaCloud\Client\Regions
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link https://github.com/aliyun/openapi-sdk-php-client
 */
class LocationService
{

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var array
     */
    private static $cache = [];

    /**
     * LocationService constructor.
     *
     * @param Request $request
     */
    private function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Request $request
     * @param string  $domain
     *
     * @return mixed
     * @throws ClientException
     * @throws ServerException
     */
    public static function findProductDomain(Request $request, $domain = LOCATION_SERVICE_DOMAIN)
    {
        $instance = new static($request);
        $key      = $instance->request->realRegionId() . '#' . $instance->request->product;
        if (!isset(self::$cache[$key])) {
            $result = (new LocationServiceRequest($instance->request, $domain))->request();

            // @codeCoverageIgnoreStart
            if (!isset($result['Endpoints']['Endpoint'][0]['Endpoint'])) {
                throw new ClientException(
                    'Can Not Find RegionId From: ' . $domain,
                    \ALI_INVALID_REGION_ID
                );
            }

            if (!$result['Endpoints']['Endpoint'][0]['Endpoint']) {
                throw new ClientException(
                    'Invalid RegionId: ' . $result['Endpoints']['Endpoint'][0]['Endpoint'],
                    \ALI_INVALID_REGION_ID
                );
            }

            self::$cache[$key] = $result['Endpoints']['Endpoint'][0]['Endpoint'];
            // @codeCoverageIgnoreEnd
        }

        return self::$cache[$key];
    }

    /**
     * @param string $regionId
     * @param string $product
     * @param string $domain
     */
    public static function addEndPoint($regionId, $product, $domain)
    {
        $key               = $regionId . '#' . $product;
        self::$cache[$key] = $domain;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     * @return void
     */
    public static function modifyServiceDomain()
    {
    }
}
