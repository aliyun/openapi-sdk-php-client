[← Installation](Installation-EN.md) | Client[(中文)](Client-CN.md) | [Request →](Request-EN.md)
***

## Client
You may create multiple different clients simultaneously. Each client can have its own configuration, and each request can be sent by specified client. Use the Default Client if it is not specified. The client can be created by auto-loading of the configuration files, or created and managed manually. Different types of clients require different `Credential`，and different `Signature` algorithms that are selected. You may also customize the client: that is, pass in custom credentials and signatures.

### AccessKey Client
Setup AccessKey through [User Information Management][ak], they have full authority over the account, please keep them safe. Sometimes for security reasons, you cannot hand over a primary account AccessKey with full access to the developer of a project. You may create a sub-account [RAM Sub-account][ram] , grant its [authorization][permissions]，and use the AccessKey of RAM Sub-account to make API calls.
> Sample Code: Create a client with a certification type AccessKey, and set it to the Default Client，that is, a client named as `default`.

```php
<?php

use AlibabaCloud\Client\AlibabaCloud;

AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->asDefaultClient();
AlibabaCloud::accessKeyClient('accessKeyId', 'accessKeySecret')->name('default');
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

### Create the client automatically
> If there is `~/.alibabacloud/credentials` default `INI` file (Windows user shows `C:\Users\USER_NAME\.alibabacloud\credentials`), the program will automatically create clients with the specified type and name. The default file may not exist, but a parse error throws an exception. The client name is case-insensitive, and if the clients have the same name, the latter will override the former. The specified files can also be loaded indefinitely: `AlibabaCloud::load('/data/credentials', 'vfs://AlibabaCloud/credentials', ...);` This configuration file can be shared between different projects and between different tools.  Because it is outside the project and will not be accidentally committed to the version control. Environment variables can be used on Windows to refer to the home directory %UserProfile%. Unix-like systems can use the environment variable $HOME or ~ (tilde).

```ini
[default]                          # Default client
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


// Set default Region. When a request and the requested client do not have a region setting yet,the Default Region is used.
AlibabaCloud::setDefaultRegionId('cn-hangzhou');

// Get default Region
AlibabaCloud::getDefaultRegionId();
    
// Get all Clients
AlibabaCloud::all();
    
// Get specified client.If not found, throw an exception
AlibabaCloud::get('client1');

// Get Access Key from the specified client
AlibabaCloud::get('client1')->getCredential()->getAccessKeyId();

// Give a new name for the client
AlibabaCloud::get('client1')->name('otherName');

// Get default client region, and so on
AlibabaCloud::getDefaultClient()->regionId;
 
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

***
[← Installation](Installation-EN.md) | Client[(中文)](Client-CN.md) | [Request →](Request-EN.md)

[ak]: https://usercenter.console.aliyun.com/#/manage/ak
[ram]: https://ram.console.aliyun.com/users
[permissions]: https://ram.console.aliyun.com/permissions
[RAM Role]: https://ram.console.aliyun.com/#/role/list
