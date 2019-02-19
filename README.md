English | [简体中文](./README-CN.md)


<p align="center"><img src="./src/Files/AlibabaCloud.svg"></p>
<p align="center">
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/alibabacloud/client"><img src="https://poser.pugx.org/alibabacloud/client/license" alt="License"></a>
<br/>
<a href="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client"><img src="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client/badges/quality-score.png" alt="Scrutinizer Code Quality"></a>
<a href="https://travis-ci.org/aliyun/openapi-sdk-php-client"><img src="https://travis-ci.org/aliyun/openapi-sdk-php-client.svg?branch=master" alt="Travis Build Status"></a>
<a href="https://ci.appveyor.com/project/songshenzong/openapi-sdk-php-client/branch/master"><img src="https://ci.appveyor.com/api/projects/status/0l0msff7dwvt7cqg/branch/master?svg=true" alt="Appveyor Build Status"></a>
<a href="https://codecov.io/gh/aliyun/openapi-sdk-php-client"><img src="https://codecov.io/gh/aliyun/openapi-sdk-php-client/branch/master/graph/badge.svg" alt="codecov"></a>
<a href="https://scrutinizer-ci.com/code-intelligence"><img src="https://scrutinizer-ci.com/g/aliyun/openapi-sdk-php-client/badges/code-intelligence.svg" alt="Code Intelligence Status"></a>
</p> 


## About
**Alibaba Cloud Client for PHP** is a client tool that helps PHP developers manage credentials and send requests, [Alibaba Cloud SDK for PHP][SDK] dependency on this tool.


## Requirements
- You must use PHP 5.5.0 or later.
- if you use the `RsaKeyPair` (Only Japan station is supported) client, you will also need [OpenSSL PHP extension][OpenSSL]. 


## Online Demo
[API Explorer](https://api.aliyun.com) provides the ability to call the cloud product OpenAPI online, and dynamically generate SDK Example code and quick retrieval interface, which can significantly reduce the difficulty of using the cloud API. **It is highly recommended**.

<a href="https://api.aliyun.com" target="api_explorer">
  <img src="https://img.alicdn.com/tfs/TB12GX6zW6qK1RjSZFmXXX0PFXa-744-122.png" width="180" />
</a>


## Recommendations
- Use [Composer][composer] and optimize automatic loading `composer dump-autoload --optimize`
- Install [cURL][cURL] 7.16.2 or later version
- Use [OPCache][OPCache]
- In a production environment, do not use [Xdebug][xdebug]


## Installation
1. Download and install Composer（Windows user please download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe))
```bash
curl -sS https://getcomposer.org/installer | php
```

2. Execute the Composer command, install the newest and stable version of Alibaba Cloud Client for PHP
```bash
php -d memory_limit=-1 composer.phar require alibabacloud/client
```

3. Require the Composer auto-loading tool
```php
<?php

require __DIR__ . '/vendor/autoload.php'; 
```


## Client
You may create multiple different clients simultaneously. Each client can have its own configuration, and each request can be sent by specified client. Use the Global Client if it is not specified. The client can be created by auto-loading of the configuration files, or created and managed manually. Different types of clients require different `Credential`，and different `Signature` algorithms that are selected. You may also customize the client: that is, pass in custom credentials and signatures.

### Create the client automatically
> If there is `~/.alibabacloud/credentials` default `INI` file (Windows user shows `C:\Users\USER_NAME\.alibabacloud\credentials`), the program will automatically create clients with the specified type and name. The default file may not exist, but a parse error throws an exception. The client name is case-insensitive, and if the clients have the same name, the latter will override the former. The specified files can also be loaded indefinitely: `AlibabaCloud::load('/data/credentials', 'vfs://AlibabaCloud/credentials', ...);` This configuration file can be shared between different projects and between different tools.  Because it is outside the project and will not be accidentally committed to the version control. Environment variables can be used on Windows to refer to the home directory %UserProfile%. Unix-like systems can use the environment variable $HOME or ~ (tilde).

```ini
[global]                           # Global client
enable = true                      # Enable，Enabled by default if this option not present
type = access_key                  # Certification type: access_key
access_key_id = foo                # Key
access_key_secret = bar            # Secret
region_id = cn-hangzhou            # Optional，Region
debug = true                       # Optional，Debug mode will output the details under CLI
timeout = 0.2                      # Optional，Time-out period. if >1, unit is seconds; if<1, unit will be converted to milliseconds by multiplying 1000 automatically
connect_Timeout = 0.03             # Optional，Connection timeout, same as timeout
cert_file = /path/server.pem       # Optional，Certification file
cert_password = password           # Optional，Certification password, can be empty if no password
proxy = tcp://localhost:8125       # Optional，General proxy
proxy_http = tcp://localhost:8125  # Optional，HTTP proxy
proxy_https = tcp://localhost:9124 # Optional，HTTPS proxy
proxy_no = .mit.edu,foo.com        # Optional，Ignored Domain Name by proxy

[client1]                          # Client that is named as `client1`
type = ecs_ram_role                # Certification type: ecs_ram_role
role_name = EcsRamRoleTest         # Role Name
#..................................# As above, other configurations ignored.

[client2]                          # Client that is named as `client2` 
enable = false                     # Disable
type = ram_role_arn                # Certification type: ram_role_arn
access_key_id = foo
access_key_secret = bar
role_arn = role_arn
role_session_name = session_name
#..................................# As above, other configurations ignored.

[client3]                          # Client that is named as `client3`
type = bearer_token                # Certification type: bearer_token
bearer_token = bearer_token        # Token
#..................................# As above, other configurations ignored.

[client4]                          # Client that is named as `client4`
type = rsa_key_pair                # Certification type: rsa_key_pair
public_key_id = publicKeyId        # Public Key ID
private_key_file = /your/pk.pem    # Private Key file
#..................................# As above, other configurations ignored.

```

### AccessKey Client
Setup AccessKey through [User Information Management][ak], they have full authority over the account, please keep them safe. Sometimes for security reasons, you cannot hand over a primary account AccessKey with full access to the developer of a project. You may create a sub-account [RAM Sub-account][ram] , grant its [authorization][permissions]，and use the AccessKey of RAM Sub-account to make API calls.
> Sample Code: Create a client with a certification type AccessKey, and set it to the Global Client，that is, a client named as `global`.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->asGlobalClient();
AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->name('global');
```


### RamRoleArn Client
By specifying [RAM Role][RAM Role], the client will be able to automatically request maintenance of STS Token before making a request, and be automatically converted to a time-limited STS client. You may also apply for Token maintenance by yourself before creating `STS Client`.  
> Sample Code: Create a client with a certification type RamRoleArn, name it as `ramRoleArnClient`.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::ramRoleArnClient('accessKeyId', 'accessKeySecret', 'roleArn', 'roleSessionName')
              ->name('ramRoleArnClient');
```


### EcsRamRole Client
By specifying the role name, the client will be able to automatically request maintenance of STS Token before making a request, and be automatically converted to a time-limited STS client. You may also apply for Token maintenance by yourself before creating `STS Client`.  
> Sample Code: Create a client with a certification type EcsRamRole, name it as `ecsRamRoleClient`.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::ecsRamRoleClient('roleName')->name('ecsRamRoleClient');
```


### Bearer Token Client
If clients with this certification type are required by the Cloud Call Centre (CCC), please apply for Bearer Token maintenance by yourself.
> Sample Code: Create a client with a certification type Bearer Token, name it as `bearerTokenClient`.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::bearerTokenClient('token')->name('bearerTokenClient');
```


### RsaKeyPair Client
By specifying the public key ID and the private key file, the client will be able to automatically request maintenance of the AccessKey before sending the request, and be automatically converted to a time-limited AccessKey client. Only Japan station is supported. 
> Sample Code: Create a client with a certification type RsaKeyPair, name it as `rsaKeyPairClient`.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::rsaKeyPairClient('publicKeyId', '/your/privateKey.pem')->name('rsaKeyPairClient');
```


### Client Operations

```php
<?php
    
use AlibabaCloud\Client\AlibabaCloud;
    
// Create a client, chain calls and set other options.
AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')
            ->regionId('cn-hangzhou') // Set the client region. Use this setting if there is a request of using this client and no individual setting is present.
            ->timeout(1) // 1 second timeout. Use this setting if there is a request of using this client and no individual setting is present.
            ->connectTimeout(0.1) // 10 milliseconds of connection timeout. When the units are less than 1, unit will be converted to milliseconds automatically. Use this setting if there is a request of using this client and no individual setting is present.
            ->debug(true) // Enable the debug, the details will be output under CLI. Use this setting if there is a request of using this client and no individual setting is present.
            ->name('client1');


// Set global Region. When a request and the requested client do not have a region setting yet,the Global Region is used.
AlibabaCloud::setGlobalRegionId('cn-hangzhou');

// Get Global Region
AlibabaCloud::getGlobalRegionId();
    
// Get all Clients
AlibabaCloud::all();
    
// Get specified client.If not found, throw an exception
AlibabaCloud::get('client1');

// Get Access Key from the specified client
AlibabaCloud::get('client1')->getCredential()->getAccessKeyId();

// Give a new name for the client
AlibabaCloud::get('client1')->name('otherName');

// Get global default client region, and so on
AlibabaCloud::getGlobalClient()->regionId;
 
// Determine whether the client with specified name exists
AlibabaCloud::has('client1');

// Delete a client
AlibabaCloud::del('client1');

// Clear all client configurations
AlibabaCloud::flush();
    
// Create the client from the default configuration file. Skip if the file not found, throw an exception if file parsing error present
AlibabaCloud::load();

// Create the client from the specified configuration file. throw an exception if the file not found or file parsing error present
AlibabaCloud::load('your/path/file', 'vfs://AlibabaCloud/credentials', '...');

// Get the AccessKey or STS Access Credentials from a client. Return immediately if the client belongs to the credential
AlibabaCloud::ecsRamRoleClient('role')->getSessionCredential();

// Get the AccessKey or STS Access Credentials from a specified client. Return immediately if the client belongs to the credential
AlibabaCloud::get('client1')->getSessionCredential();
```


## Request

Each request supports Chain Settings, Construct Settings, and so on. In addition to the requesting parameters, the `Client`, `Timeout`, `Region`, `Debug Mode` et al. can be set separately.For the constructing and `options()` parameters, please refer to: [Guzzle Request Options][guzzle-docs]

> The [Alibaba Cloud SDK for PHP][SDK] provides a quick access method for products based on the inheritance of Alibaba Cloud Client for PHP, making it easier for you to use Alibaba Cloud services.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

try {
    // Chain calls and send ROA request
    $roaResult = AlibabaCloud::roaRequest()
                             ->client('client1') // Specify client, if not, the global client is used by default
                             ->regionId('cn-hangzhou') // Specify the requested regionId, if not specified, use the client regionId, then global regionId
                             ->product('CS') // Specify product
                             ->version('2015-12-15') // Specify product version
                             ->action('DescribeClusterServices') // Specify product interface
                             ->serviceCode('cs') // Set ServiceCode for addressing, optional
                             ->endpointType('openAPI') // Set type, optional
                             ->method('GET') // Set request method
                             ->host('cs.aliyun.com') // Location Service will not be enabled if the host is specified. For example, service with a Certification type-Bearer Token should be specified
                             ->pathPattern('/clusters/[ClusterId]/services') // Specify path rule with ROA-style
                             ->connectTimeout(0.1) // 10 milliseconds of connection timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->timeout(0.1) // 10 milliseconds of timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->debug(true) // Enable Debug, details will be output under CLI
                             ->withClusterId('123456') // Assign values to parameters in the path. Method: with + Parameter
                             ->request(); // Make a request and return to result object. The request is to be placed at the end of the setting

    // Chain calls and send RPC request
    $rpcResult = AlibabaCloud::rpcRequest()
                             ->client('client1') // Specify client, if not, the global client is used by default
                             ->product('Cdn')
                             ->version('2014-11-11')
                             ->action('DescribeCdnService')
                             ->method('POST')
                             ->connectTimeout(0.1) // 10 milliseconds of connection timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->timeout(0.1) // 10 milliseconds of timeout. When the units < 1, units will be converted to milliseconds automatically
                             ->debug(true) // Enable Debug, details will be output under CLI
                             ->request();// Make a request and return to result object. The request is to be placed at the end of the setting
        

    // Construct calls and send RPC request
    $request3 = AlibabaCloud::rpcRequest([
                                 'debug'           => true,
                                 'timeout'         => 0.01,
                                 'connect_timeout' => 0.01,
                                         'query'   => [
                                               'Product' => 'Cdn',
                                               'Version' => '2014-11-11',
                                               'Action'  => 'DescribeCdnService',
                                         ],
                               ]);
    $result3  = $request3->request();

    // Priority of setting
    $result4 = AlibabaCloud::rpcRequest([
                                   'debug'           => true,
                                   'timeout'         => 0.01,
                                   'connect_timeout' => 0.01,
                                   'query'           => [
                                      'Product' => 'Cdn',
                                      'Version' => '2014-11-11',
                                      'Action'  => 'DescribeCdnService',
                                   ],
                                ])->options([
                                                // All parameters can be also set by Options method or reset
                                                'query' => [
                                                    'Product'      => 'I will overwrite this value in constructor',
                                                    'Version'      => 'I am new value',
                                                ],
                                              ])
                                   ->options([
                                                // The Options method can be called multiple times
                                                'query' => [
                                                    'Product' => 'I will overwrite the previous value',
                                                    'Version' => 'I will overwrite the previous value',
                                                    'Action'  => 'I will overwrite the previous value',
                                                    'New'     => 'I am new value',
                                                ],
                                              ])
                                   ->debug(false) // Overwrite the true of the former
                                   ->timeout(0.02) // Overwrite the 0.01 of the former
                                   ->request();
    
} catch (ClientException $exception) {
    // Get error message
    print_r($exception->getErrorMessage());
} catch (ServerException $exception) {
    // Get error code
    print_r($exception->getErrorCode());
    // Get Request Id
    print_r($exception->getRequestId());
    // Get error message
    print_r($exception->getErrorMessage());
    // Get result object
    print_r($exception->getResult());
    // Get response object
    print_r($exception->getResult()->getResponse());
    // Get request object
    print_r($exception->getResult()->getRequest());
}
```


## Result
Returned result is not just filed, but the objects with characters like `ArrayAccess`, `IteratorAggregate`, `Countable`, `JmesPath` et al.

```php
<?php

/**
 * @var AlibabaCloud\Client\Result\Result $result
 */

// Accessing results by objects
echo $result->RequestId;

// Accessing results by array
echo $result['RequestId'];
echo $result['AccessPointSet.AccessPointType'];

// Convert result to array
$result->toArray();

// Convert result to Json
$result->toJson();

// Result contains some fields
$result->has('RequestId');
$result->has('AccessPointSet.AccessPointType');
    
// Is the result empty
$result->isEmpty();
$result->isEmpty('RequestId');
$result->isEmpty('AccessPointSet.AccessPointType');
    
// Search and match from the result
$result->search('AccessPointSet.AccessPointType[0].Name');

// Get a field from the results
$result->get();
$result->get('AccessPointSet.AccessPointType');

// Count result elements
$result->count();
$result->count('AccessPointSet.AccessPointType');

// Is the result requested successful
$result->isSuccess();

// Get response from the result
$result->getResponse();

// Get the request object from the result
$result->getRequest();
```


## Region
Each request carries an region called `regionId`. Since most of the requested regions are the same, it is not necessary to set the region for each request, Please refer to [Region List][endpoints].

### Specify the Region for the Request
> If you specify an Region separately for the request, the client Region or global Region will not be used.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$result = AlibabaCloud::rpcRequest()
                         ->client('client1') // Specify client, if not, the global client is used by default
                         ->regionId('cn-hangzhou') // Specify the requested Region as cn-hangzhou
                         ->product('Cdn')
                         ->version('2014-11-11')
                         ->action('DescribeCdnService')
                         ->method('POST')
                         ->request();
```

### Specify the Region for the Client
> You can also specify an Region when you create a client, and if the client's request is not specified Region, use the client's Region.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')
            ->regionId('cn-hangzhou') // Specify the client Region as cn-hangzhou
            ->name('client1');
```

### Set the global Region
> If both the Request and Request's client do not have an Region, the global Region will be used.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// Set the global Region to cn-hangzhou
AlibabaCloud::setGlobalRegionId('cn-hangzhou');

// Get the global Region
AlibabaCloud::getGlobalRegionId();
```


## Host
Before sending the detailed request for each product, Alibaba Cloud Client for PHP will find the Host of the product in the region, Please refer to [Host List][endpoints].

### Specify the Host for the request
> If a Host is specified for the request, the Location Service will not be enabled. It is recommended that the specified Host be the same as the server's region, or close.
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$request = AlibabaCloud::rpcRequest()
                       ->product('Sts')
                       ->version('2015-04-01')
                       ->action('GenerateSessionAccessKey')
                       ->host('sts.ap-northeast-1.aliyuncs.com') // Specify the Host
                       ->request();
```

### Add a searchable Host for the addressing service
> You can also set a Host in a region for a product. The addressing service will not make a request, but use this Host directly.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// Add a Host in the cn-hangzhou region for a product
AlibabaCloud::addHost('product_name', 'product_name.cn-hangzhou.aliyuncs.com', 'cn-hangzhou');

// Add a global Host for a product. If the specified Region is not specified Host, the global Host will be used.
AlibabaCloud::addHost('product_name', 'product_name.aliyuncs.com');
```


## Debugging
If there is an environment variable `DEBUG=sdk` , all requests will enable debug mode.


## References
* [Alibaba Cloud Regions & Endpoints][endpoints]
* [OpenAPI Explorer][open-api]
* [Packagist][packagist]
* [Composer][composer]
* [Guzzle Documentation][guzzle-docs]
* [Latest Release][latest-release]

[SDK]: https://github.com/aliyun/openapi-sdk-php
[open-api]: https://api.alibabacloud.com
[latest-release]: https://github.com/aliyun/openapi-sdk-php-client
[guzzle-docs]: http://docs.guzzlephp.org/en/stable/request-options.html
[composer]: http://getcomposer.org
[packagist]: https://packagist.org/packages/alibabacloud/sdk
[ak]: https://usercenter.console.aliyun.com/#/manage/ak
[home]: https://home.console.aliyun.com
[ram]: https://ram.console.aliyun.com/users
[permissions]: https://ram.console.aliyun.com/permissions
[alibabacloud]: https://www.alibabacloud.com
[endpoints]: https://developer.aliyun.com/endpoints
[cURL]: http://php.net/manual/en/book.curl.php
[OPCache]: http://php.net/manual/en/book.opcache.php
[xdebug]: http://xdebug.org
[OpenSSL]: http://php.net/manual/en/book.openssl.php
[RAM Role]: https://ram.console.aliyun.com/#/role/list
[client]: https://github.com/aliyun/openapi-sdk-php-client
