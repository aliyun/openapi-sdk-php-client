Upgrading Guide
===============

Signature V2 defaults to HMAC-SHA256
----------------------------------

AccessKey, STS, RAM role ARN, ECS RAM role, and RSA key-pair clients now use HMAC-SHA256 for AK-signed RPC and ROA requests. `SignatureVersion` remains `1.0`. RSA credential exchange still uses SHA256withRSA, and Bearer Token authentication is unchanged. No product SDK changes are required; update the installed `alibabacloud/client` dependency, including the version recorded in `composer.lock`.

An endpoint that requires HMAC-SHA1 can use an explicitly selected signature:

```php
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Credentials\AccessKeyCredential;
use AlibabaCloud\Client\Signature\ShaHmac1Signature;

AlibabaCloud::client(
    new AccessKeyCredential('accessKeyId', 'accessKeySecret'),
    new ShaHmac1Signature()
)->asDefaultClient();
```

Use `StsCredential` or `RamRoleArnCredential` in the same factory for temporary credentials or AssumeRole. The selected signature also applies to the internal AssumeRole and Location requests. RPC retries discard the previous signature and sign the parameters that will be sent.

SDK logger output, debug output, and exception messages mask AccessKey secrets, security/bearer tokens, and complete signatures. Debug mode now prints sanitized HTTP headers and errors instead of raw transport traces. Requests and readable results retain their original values. Synchronous and asynchronous transport failures expose a sanitized `ClientException` without the original unsafe transport exception chain.

1.x
-----------------------
- This is the first version. See <https://github.com/aliyun/openapi-sdk-php-client> for more information.
