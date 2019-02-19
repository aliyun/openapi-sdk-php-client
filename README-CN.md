[English](./README.md) | 简体中文


<p align="center"><img src="./src/Files/Aliyun.svg"></p>
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


## 关于
**Alibaba Cloud Client for PHP** 是帮助 PHP 开发者管理凭据、发送请求的客户端工具，[Alibaba Cloud SDK for PHP][SDK] 由本工具提供底层支持。


## 要求
- 您必须使用 PHP 5.5.0 或更高版本。
- 如果您使用了 `RsaKeyPair` 客户端（仅支持日本站），还需要 [OpenSSL PHP 扩展][OpenSSL]。


## 建议
- 使用 [Composer][composer] 并优化自动加载 `composer dump-autoload --optimize`
- 安装 [cURL][cURL] 7.16.2 或更高版本
- 使用 [OPCache][OPCache]
- 生产环境中不要使用 [Xdebug][xdebug]


## 在线示例
[API Explorer](https://api.aliyun.com) 提供在线调用阿里云产品，并动态生成 SDK 代码和快速检索接口等能力，能显著降低使用云 API 的难度，强烈推荐使用。

<a href="https://api.aliyun.com" target="api_explorer">
  <img src="https://img.alicdn.com/tfs/TB12GX6zW6qK1RjSZFmXXX0PFXa-744-122.png" width="180" />
</a>


## 安装
1. 下载并安装 Composer（Windows 用户请下载并运行 [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)）
```bash
curl -sS https://getcomposer.org/installer | php
```

2. 执行 Composer 命令安装 Alibaba Cloud Client for PHP 的最新稳定版本
```bash
php -d memory_limit=-1 composer.phar require alibabacloud/client
```

3. 在代码中引入 Composer 自动加载工具
```php
<?php

require __DIR__ . '/vendor/autoload.php'; 
```


## 客户端
您可以同时创建多个不同的客户端，每个客户端都可以有独立的配置，每一个请求都可以指定发送的客户端，如果不指定则使用全局客户端。客户端可以通过配置文件自动加载创建，也可以手动创建、管理。不同类型的客户端需要不同的凭证 `Credential`，内部也选取不同的签名算法 `Signature`，您也可以自定义客户端：即传入自定义的凭证和签名。

### 自动创建客户端
> 如果存在 `~/.alibabacloud/credentials` 默认 `INI` 文件 （Windows 用户为 `C:\Users\USER_NAME\.alibabacloud\credentials`），程序会自动创建指定类型和名称的客户端。默认文件可以不存在，但解析错误会抛出异常。  客户端名称不分大小写，若客户端同名，后者会覆盖前者。也可以无限的加载指定文件： `AlibabaCloud::load('/data/credentials', 'vfs://AlibabaCloud/credentials', ...);` 不同的项目、工具之间可以共用这个配置文件，因为超出项目之外，也不会被意外提交到版本控制。Windows 上可以使用环境变量引用到主目录 %UserProfile%。类 Unix 的系统可以使用环境变量 $HOME 或 ~ (tilde)。  

```ini
[global]                           # 全局客户端
enable = true                      # 启用，没有该选项默认启用
type = access_key                  # 认证方式为 access_key
access_key_id = foo                # Key
access_key_secret = bar            # Secret
region_id = cn-hangzhou            # 非必填，区域
debug = true                       # 非必填，Debug模式会在CLI下输出详细信息
timeout = 0.2                      # 非必填，超时时间，>1为单位为秒, <1自动乘1000转为毫秒
connect_Timeout = 0.03             # 非必填，连接超时时间，同超时时间
cert_file = /path/server.pem       # 非必填，证书文件
cert_password = password           # 非必填，证书密码，没有密码可不填
proxy = tcp://localhost:8125       # 非必填，总代理
proxy_http = tcp://localhost:8125  # 非必填，HTTP代理
proxy_https = tcp://localhost:9124 # 非必填，HTTPS代理
proxy_no = .mit.edu,foo.com        # 非必填，代理忽略的域名

[client1]                          # 命名为 `client1` 的客户端
type = ecs_ram_role                # 认证方式为 ecs_ram_role
role_name = EcsRamRoleTest         # Role Name
#..................................# 其他配置忽略同上

[client2]                          # 命名为 `client2` 的客户端
enable = false                     # 不启用
type = ram_role_arn                # 认证方式为 ram_role_arn
access_key_id = foo
access_key_secret = bar
role_arn = role_arn
role_session_name = session_name
#..................................# 其他配置忽略同上

[client3]                          # 命名为 `client3` 的客户端
type = bearer_token                # 认证方式为 bearer_token
bearer_token = bearer_token        # Token
#..................................# 其他配置忽略同上

[client4]                          # 命名为 `client4` 的客户端
type = rsa_key_pair                # 认证方式为 rsa_key_pair
public_key_id = publicKeyId        # Public Key ID
private_key_file = /your/pk.pem    # Private Key 文件
#..................................# 其他配置忽略同上

```

### AccessKey 客户端
通过[用户信息管理][ak]设置AccessKey，它们具有该账户完全的权限，请妥善保管。有时出于安全考虑，您不能把具有完全访问权限的主账户 AccessKey 交于一个项目的开发者使用，您可以[创建RAM子账户][ram]并为子账户[授权][permissions]，使用RAM子用户的 AccessKey 来进行API调用。  
> 示例代码：创建一个 AccessKey 方式认证的客户端，并设置为全局客户端，即命名为 `global` 的客户端。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->asGlobalClient();
AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->name('global');
```


### RamRoleArn 客户端
通过指定[RAM角色][RAM Role]，让客户端在发起请求前自动申请维护 STS Token，自动转变为一个有时限性的STS客户端。您也可以自行申请维护 STS Token，再创建 `STS客户端`。  
> 示例代码：创建一个 RamRoleArn 方式认证的客户端，命名 `ramRoleArnClient`。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::ramRoleArnClient('accessKeyId', 'accessKeySecret', 'roleArn', 'roleSessionName')
              ->name('ramRoleArnClient');
```


### EcsRamRole 客户端
通过指定角色名称，让客户端在发起请求前自动申请维护 STS Token，自动转变为一个有时限性的STS客户端。您也可以自行申请维护 STS Token，再创建 `STS客户端`。  
> 示例代码：创建一个 EcsRamRole 方式认证的客户端，命名 `ecsRamRoleClient`。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::ecsRamRoleClient('roleName')->name('ecsRamRoleClient');
```


### Bearer Token 客户端
如呼叫中心(CCC)需用此类认证方式的客户端，请自行申请维护 Bearer Token。  
> 示例代码：创建一个 Bearer Token 方式认证的客户端，命名 `bearerTokenClient`。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::bearerTokenClient('token')->name('bearerTokenClient');
```

### RsaKeyPair 客户端
通过指定公钥ID和私钥文件，让客户端在发起请求前自动申请维护 AccessKey，自动转变成为一个有时限性的AccessKey客户端，仅支持日本站。  
> 示例代码：创建一个 RsaKeyPair 方式认证的客户端，命名 `rsaKeyPairClient`。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::rsaKeyPairClient('publicKeyId', '/your/privateKey.pem')->name('rsaKeyPairClient');
```


### 客户端的操作

```php
<?php
    
use AlibabaCloud\Client\AlibabaCloud;
    
// 创建一个客户端并链式调用设置其它选项
AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')
            ->regionId('cn-hangzhou') // 设置客户端区域，使用该客户端且没有单独设置的请求都使用此设置
            ->timeout(1) // 超时1秒，使用该客户端且没有单独设置的请求都使用此设置
            ->connectTimeout(0.1) // 连接超时10毫秒，当单位小于1，则自动转换为毫秒，使用该客户端且没有单独设置的请求都使用此设置
            ->debug(true) // 开启调试，CLI下会输出详细信息，使用该客户端且没有单独设置的请求都使用此设置
            ->name('client1');


// 设置全局区域，当某个请求和请求的客户端没有设置区域，则使用全局区域
AlibabaCloud::setGlobalRegionId('cn-hangzhou');

// 获取全局区域
AlibabaCloud::getGlobalRegionId();
    
// 获取所有客户端
AlibabaCloud::all();

// 获取指定客户端，不存在则抛出异常
AlibabaCloud::get('client1');
    
// 获取指定客户端的 Access Key
AlibabaCloud::get('client1')->getCredential()->getAccessKeyId();

// 给指定客户端起一个新名字
AlibabaCloud::get('client1')->name('otherName');

// 获取全局默认客户端的区域，等等
AlibabaCloud::getGlobalClient()->regionId;
 
// 判断指定名称客户端是否存在
AlibabaCloud::has('client1');
    
// 删除一个客户端
AlibabaCloud::del('client1');

// 清除所有客户端配置
AlibabaCloud::flush();

// 根据默认配置文件创建客户端，文件不存在跳过，文件解析错误抛出异常
AlibabaCloud::load();

// 指定配置文件创建客户端，文件不存或解析错误将抛出异常
AlibabaCloud::load('your/path/file', 'vfs://AlibabaCloud/credentials', '...');

// 获取某种客户端的 AccessKey 或 STS 访问凭据，若该客户端本属于该凭据则直接返回
AlibabaCloud::ecsRamRoleClient('role')->getSessionCredential();

// 获取指定客户端的 AccessKey 或 STS 访问凭据，若该客户端本属于该凭据则直接返回
AlibabaCloud::get('client1')->getSessionCredential();
```


## 请求

每个请求都支持链式设置、构造设置等，除请求参数外，还可单独设置 `客户端`、 `超时`、 `区域`、 `调试模式` 等。构造参数和 `options()` 参数请参考：[请求选项 Guzzle中文文档][guzzle-docs]

> [Alibaba Cloud SDK for PHP][SDK] 在继承 Alibaba Cloud Client for PHP 的基础上提供了产品快捷访问方法，让您更加轻松的使用阿里云服务。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
        
try {
    // 链式调用发送 ROA 风格请求
    $roaResult = AlibabaCloud::roaRequest()
                             ->client('client1') // 指定发送请求的客户端，不指定默认使用全局客户端
                             ->regionId('cn-hangzhou') // 指定请求的区域，不指定则使用客户端区域、全局区域
                             ->product('CS') // 指定产品
                             ->version('2015-12-15') // 指定产品版本
                             ->action('DescribeClusterServices') // 指定产品接口
                             ->serviceCode('cs') // 设置 ServiceCode 以备寻址，非必须
                             ->endpointType('openAPI') // 设置类型，非必须
                             ->method('GET') // 指定请求方式
                             ->host('cs.aliyun.com') // 指定域名则不会寻址，如认证方式为 Bearer Token 的服务则需要指定
                             ->pathPattern('/clusters/[ClusterId]/services') // 指定ROA风格路径规则
                             ->connectTimeout(0.1) // 设置连接超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->timeout(0.1) // 设置超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->debug(true) // 开启调试，CLI下会输出详细信息
                             ->withClusterId('123456') // 为路径中参数赋值，方法名：with + 参数
                             ->request(); // 发起请求并返回结果对象，请求需要放在设置的最后面

    // 链式调用发送 RPC 风格请求
    $rpcResult = AlibabaCloud::rpcRequest()
                             ->client('client1') // 指定发送请求的客户端，不指定默认使用全局客户端
                             ->product('Cdn')
                             ->version('2014-11-11')
                             ->action('DescribeCdnService')
                             ->method('POST')
                             ->connectTimeout(0.1) // 设置连接超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->timeout(0.1) // 设置超时10毫秒，当单位小于1，则自动转换为毫秒
                             ->debug(true) // 开启调试CLI下会输出详细信息
                             ->request();
        

    // 构造调用发送 RPC 风格请求
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

    // 设置的优先级
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
                                                // 所有参数也可以在 options 方法中设置或重新设置
                                                'query' => [
                                                    'Product'      => '我会覆盖构造函数的这个值',
                                                    'Version'      => '我是新增的值',
                                                ],
                                              ])
                                   ->options([
                                                // 可以多次调用 options 方法
                                                'query' => [
                                                    'Product' => '我会覆盖以前的值',
                                                    'Version' => '我会覆盖以前的值',
                                                    'Action'  => '我会覆盖以前的值',
                                                    'New'     => '我是新增的值',
                                                ],
                                              ])
                                   ->debug(false) // 最后调用的会覆盖前者的 true
                                   ->timeout(0.02) // 最后调用的会覆盖前者的 0.01
                                   ->request();
    
} catch (ClientException $exception) {
    // 获取错误消息
    print_r($exception->getErrorMessage());
} catch (ServerException $exception) {
    // 获取错误代码
    print_r($exception->getErrorCode());
    // 获取 Request Id
    print_r($exception->getRequestId());
    // 获取错误消息
    print_r($exception->getErrorMessage());
    // 获取结果对象
    print_r($exception->getResult());
    // 获取响应对象
    print_r($exception->getResult()->getResponse());
    // 获取请求对象
    print_r($exception->getResult()->getRequest());
}
```


## 结果
返回的结果不只是字段，而是个实现了 `ArrayAccess`、 `IteratorAggregate`、 `Countable`、 `JmesPath` 等特性的对象。

```php
<?php

/**
 * @var AlibabaCloud\Client\Result\Result $result
 */

// 以对象方式访问结果
echo $result->RequestId;

// 以数组方式访问结果
echo $result['RequestId'];
echo $result['AccessPointSet.AccessPointType'];

// 将结果转换为数组
$result->toArray();

// 将结果转换为Json
$result->toJson();

// 结果是否包含某字段
$result->has('RequestId');
$result->has('AccessPointSet.AccessPointType');

// 结果是否为空
$result->isEmpty();
$result->isEmpty('RequestId');
$result->isEmpty('AccessPointSet.AccessPointType');
    
// 在结果中匹配搜索
$result->search('AccessPointSet.AccessPointType[0].Name');

// 在结果中获取某个字段
$result->get();
$result->get('AccessPointSet.AccessPointType');

// 统计结果元素
$result->count();
$result->count('AccessPointSet.AccessPointType');

// 请求结果是否成功
$result->isSuccess();

// 获取结果的返回对象
$result->getResponse();

// 获取结果的请求对象
$result->getRequest();
```


## 区域
每个请求都会携带区域 `regionId`，由于大部分请求的区域相同，没有必要为每个请求设置区域，请参考 [Region 列表][endpoints]。

### 为请求指定区域
> 如果为请求单独指定区域，将不使用客户端区域或全局区域。
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$result = AlibabaCloud::rpcRequest()
                         ->client('client1') // 指定发送请求的客户端，不指定默认使用全局客户端
                         ->regionId('cn-hangzhou') // 指定请求的区域为 cn-hangzhou
                         ->product('Cdn')
                         ->version('2014-11-11')
                         ->action('DescribeCdnService')
                         ->method('POST')
                         ->request();
```

### 为客户端指定区域
> 您还可以在创建客户端时指定区域，如果使用该客户端的请求没有被指定区域，则使用该客户端的区域。
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')
            ->regionId('cn-hangzhou') // 指定客户端区域为 cn-hangzhou
            ->name('client1');
```

### 设定全局区域
> 如果请求和请求的客户端都没有设置区域，将使用全局区域。
```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// 设置全局区域为 cn-hangzhou
AlibabaCloud::setGlobalRegionId('cn-hangzhou');

// 获取全局区域
AlibabaCloud::getGlobalRegionId();
```


## 域名
在发送每个产品的具体请求前，Alibaba Cloud Client for PHP 会查找该产品在该区域的域名再发起请求，请参考 [Host 列表][endpoints]。

### 为请求指定域名
> 如果为请求指定了域名，则不启用寻址服务。建议指定的域名和服务器的区域相同，或者距离相近。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

$request = AlibabaCloud::rpcRequest()
                       ->product('Sts')
                       ->version('2015-04-01')
                       ->action('GenerateSessionAccessKey')
                       ->host('sts.ap-northeast-1.aliyuncs.com') // 指定域名
                       ->request();
```

### 为寻址服务增加可查找的域名
> 您还可以为某产品在某区域指定域名，寻址服务将不会发起请求，直接使用该域名。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

// 为某产品增加在 cn-hangzhou 区域的域名
AlibabaCloud::addHost('product_name', 'product_name.cn-hangzhou.aliyuncs.com', 'cn-hangzhou');

// 为某产品增加全局域名，如果指定区域没有被指定域名，将使用全局域名
AlibabaCloud::addHost('product_name', 'product_name.aliyuncs.com');
```


## 调试
如果存在环境变量 `DEBUG=sdk` ，所有请求将启用调试输出。


## 相关
* [阿里云服务 Regions & Endpoints][endpoints]
* [OpenAPI Explorer][open-api]
* [Packagist][packagist]
* [Composer][composer]
* [Guzzle中文文档][guzzle-docs]
* [最新源码][latest-release]

[SDK]: https://github.com/aliyun/openapi-sdk-php/blob/master/README-CN.md
[open-api]: https://api.aliyun.com
[latest-release]: https://github.com/aliyun/openapi-sdk-php-client
[guzzle-docs]: https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html
[composer]: http://getcomposer.org
[packagist]: https://packagist.org/packages/alibabacloud/sdk
[ak]: https://usercenter.console.aliyun.com/#/manage/ak
[home]: https://home.console.aliyun.com
[ram]: https://ram.console.aliyun.com/users
[permissions]: https://ram.console.aliyun.com/permissions
[aliyun]: https://www.aliyun.com
[endpoints]: https://developer.aliyun.com/endpoints
[cURL]: http://php.net/manual/zh/book.curl.php
[OPCache]: http://php.net/manual/zh/book.opcache.php
[xdebug]: http://xdebug.org
[OpenSSL]: http://php.net/manual/zh/book.openssl.php
[RAM Role]: https://ram.console.aliyun.com/#/role/list
[client]: https://github.com/aliyun/openapi-sdk-php-client
