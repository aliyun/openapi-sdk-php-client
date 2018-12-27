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
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php
 */

namespace AlibabaCloud\Client\Tests\Mock\Services\CS;

use AlibabaCloud\Client\Request\RoaRequest;

/**
 * Class DescribeClusterServicesRequest
 *
 * @package   AlibabaCloud\Client\Tests\Mock\Services\CS
 *
 * @author    Alibaba Cloud SDK <sdk-team@alibabacloud.com>
 * @copyright 2018 Alibaba Group
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/aliyun/openapi-sdk-php-client
 *
 * @property-read string $ClusterId
 * @method        string getClusterId()
 * @method        self setClusterId(string $clusterId)
 */
class DescribeClusterServicesRequest extends RoaRequest
{
    /**
     * @var string
     */
    public $pathPattern = '/clusters/[ClusterId]/services';
    /**
     * @var string
     */
    public $product = 'CS';
    /**
     * @var string
     */
    public $version = '2015-12-15';
    /**
     * @var string
     */
    public $action = 'DescribeClusterServices';

    /**
     * DescribeClusterServicesRequest constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->options($options);
    }
}
