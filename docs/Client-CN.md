[← 安装](Installation-CN.md) | 客户端[(English)](Client-EN.md) | [请求 →](Request-CN.md)
***

## 客户端
您可以同时创建多个不同的客户端，每个客户端都可以有独立的配置，每一个请求都可以指定发送的客户端，如果不指定则使用默认客户端。客户端可以通过配置文件自动加载创建，也可以手动创建、管理。不同类型的客户端需要不同的凭证 `Credential`，内部也选取不同的签名算法 `Signature`，您也可以自定义客户端：即传入自定义的凭证和签名。

### AccessKey 客户端
通过[用户信息管理][ak]设置AccessKey，它们具有该账户完全的权限，请妥善保管。有时出于安全考虑，您不能把具有完全访问权限的主账户 AccessKey 交于一个项目的开发者使用，您可以[创建RAM子账户][ram]并为子账户[授权][permissions]，使用RAM子用户的 AccessKey 来进行API调用。  
> 示例代码：创建一个 AccessKey 方式认证的客户端，并设置为默认客户端，即命名为 `default` 的客户端。

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->asDefaultClient();
AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->name('default');
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

### 自动创建客户端
> 如果存在 `~/.alibabacloud/credentials` 默认 `INI` 文件 （Windows 用户为 `C:\Users\USER_NAME\.alibabacloud\credentials`），程序会自动创建指定类型和名称的客户端。默认文件可以不存在，但解析错误会抛出异常。  客户端名称不分大小写，若客户端同名，后者会覆盖前者。也可以无限的加载指定文件： `AlibabaCloud::load('/data/credentials', 'vfs://AlibabaCloud/credentials', ...);` 不同的项目、工具之间可以共用这个配置文件，因为超出项目之外，也不会被意外提交到版本控制。Windows 上可以使用环境变量引用到主目录 %UserProfile%。类 Unix 的系统可以使用环境变量 $HOME 或 ~ (tilde)。  

```ini
[default]                          # 默认客户端
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


// 设置默认区域，当某个请求和请求的客户端没有设置区域，则使用默认区域
AlibabaCloud::setDefaultRegionId('cn-hangzhou');

// 获取默认区域
AlibabaCloud::getDefaultRegionId();
    
// 获取所有客户端
AlibabaCloud::all();

// 获取指定客户端，不存在则抛出异常
AlibabaCloud::get('client1');
    
// 获取指定客户端的 Access Key
AlibabaCloud::get('client1')->getCredential()->getAccessKeyId();

// 给指定客户端起一个新名字
AlibabaCloud::get('client1')->name('otherName');

// 获取默认客户端的区域，等等
AlibabaCloud::getDefaultClient()->regionId;
 
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

***
[← 安装](Installation-CN.md) | 客户端[(English)](Client-EN.md) | [请求 →](Request-CN.md)

[ak]: https://usercenter.console.aliyun.com/#/manage/ak
[ram]: https://ram.console.aliyun.com/users
[permissions]: https://ram.console.aliyun.com/permissions
[RAM Role]: https://ram.console.aliyun.com/#/role/list
