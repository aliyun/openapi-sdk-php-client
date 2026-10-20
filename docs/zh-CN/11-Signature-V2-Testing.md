# 签名 V2 复测

本次默认算法由 HMAC-SHA1 改为 HMAC-SHA256，`SignatureVersion` 仍为 `1.0`。以下测试使用模拟响应和合成凭证，不需要真实 AccessKey，也不会向云端发送请求。

## 已安装开发依赖的环境

在本仓库根目录运行：

```sh
vendor/bin/phpunit --no-configuration --bootstrap tests/bootstrap.php \
  --filter '(SignatureV2Test|RequestDiagnosticsTest|SensitiveDataTest)' tests/Unit
```

预期为 `36 tests, 272 assertions`。本次实际验证环境为 PHP 8.2/PHPUnit 9.6。新增测试使用 PHPUnit 7.5 及以上版本的字符串断言，需选择兼容当前 PHP 的测试运行器。本库开发依赖声明允许 PHPUnit 5.7 至 9.x；生产代码的最低 PHP 版本声明仍为 5.5，不能把现代环境的测试结果视为旧 PHP 已运行验证。

`--no-configuration` 用于避开仓库旧 `phpunit.xml` 的加载器和覆盖率配置。不要用 `composer test`、`composer unit` 代替上述限定范围的命令；现有完整测试集中包含真实 API 调用。

## 现代 PHP 的独立测试环境

若旧开发依赖无法在现代 PHP 上完整安装，可在独立目录安装 PHPUnit 9.6 和本库所需运行依赖。无需修改本仓库的 `composer.json` 或提交生成的依赖文件。以下以 PHP 8.2 为例，先将路径替换为自己的目录：

```sh
export CLIENT_SOURCE="$(pwd)"
export SIGNATURE_TEST_ENV="/absolute/path/to/php-client-test-env"
mkdir -p "$SIGNATURE_TEST_ENV"
composer --working-dir="$SIGNATURE_TEST_ENV" require \
  'guzzlehttp/guzzle:^7.0' 'mtdowling/jmespath.php:^2.5' \
  'adbario/php-dot-notation:^2.4.1' 'clagiordano/weblibs-configmanager:^1.0' \
  'psr/log:^1.1' 'symfony/dotenv:^3.4'
composer --working-dir="$SIGNATURE_TEST_ENV" require --dev 'phpunit/phpunit:^9.6'
```

在该独立目录创建 `bootstrap.php`，显式加载本地修改后的 Client 源码和测试，避免误测已发布版本：

```php
<?php
$loader = require __DIR__ . '/vendor/autoload.php';
$source = getenv('CLIENT_SOURCE');
$loader->addPsr4('AlibabaCloud\\Client\\', $source . '/src');
$loader->addPsr4('AlibabaCloud\\Client\\Tests\\', $source . '/tests');
require_once $source . '/src/Functions.php';
```

回到本仓库根目录执行：

```sh
php "$SIGNATURE_TEST_ENV/vendor/bin/phpunit" --no-configuration \
  --bootstrap "$SIGNATURE_TEST_ENV/bootstrap.php" --do-not-cache-result \
  --filter '(SignatureV2Test|RequestDiagnosticsTest|SensitiveDataTest)' tests/Unit
```

验证 Guzzle 6 兼容性时，在独立依赖目录将 `guzzlehttp/guzzle` 约束改为 `^6.5`、更新相关依赖后，使用同一命令重跑。Guzzle 6 的旧依赖在 PHP 8.2 上可能报告废弃提示，应与测试失败区分。

## 覆盖内容与结果判断

| 测试 | 验证内容 |
| --- | --- |
| `SignatureV2Test` | AK、STS 的 RPC GET/POST 和 ROA GET/POST 最终请求，独立 HMAC 验算及 ROA Content-MD5。 |
| `SignatureV2Test` | 默认 HMAC-SHA256、显式 HMAC-SHA1 回退，协议版本均保持 `1.0`。 |
| `SignatureV2Test` | AssumeRole 换证与业务请求继承所选算法；ECS 元数据换证、RSA 换证后的业务请求使用 SHA256；RSA 换证与 Bearer 行为保留。 |
| `SignatureV2Test` | 异步请求与 RPC POST 重试；重试排除旧签名，待签参数与实际发送参数一致。 |
| `RequestDiagnosticsTest` | 日志、调试输出、同步/异步异常不泄露 SK、Token、完整签名；包括自定义响应 Header 格式及凭证响应。请求和结果保留原值。 |
| `SensitiveDataTest` | JSON、XML、Query、Header、直接及两层 URL 编码脱敏，含 `MessageTokenDTO`、`SessionAccessKeySecret` 和含空格的 Header 值。 |

本次在 PHP 8.2 上分别使用 Guzzle 7 和 Guzzle 6 验证新增离线用例；受影响的既有离线测试也已回归。未进行真实云端 API 联调，也未运行全部历史 PHP 版本。发布前仍需用测试账号确认目标 RPC、ROA、STS 端点接受 HMAC-SHA256，并确认消费项目实际安装的 `alibabacloud/client` 版本及锁文件已更新。
