<?php

namespace AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini;

/**
 * Class VirtualRsaKeyPairCredential
 *
 * @codeCoverageIgnore
 *
 * @package   AlibabaCloud\Client\Tests\HigherthanorEqualtoVersion7_2\Unit\Credentials\Ini
 */
class VirtualRsaKeyPairCredential extends VirtualAccessKeyCredential
{

    /**
     * @return string
     */
    public static function noPublicKeyId()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = rsa_key_pair
EOT;

        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function noPrivateKeyFile()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = rsa_key_pair
public_key_id = public_key_id
EOT;

        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function badPrivateKeyFilePath()
    {
        $content = <<<EOT
[phpunit]
enable = true
type = rsa_key_pair
public_key_id = public_key_id
private_key_file = /bad/path.pem
EOT;

        return (new static($content))->url();
    }

    /**
     * @return string
     */
    public static function privateKeyFileUrl()
    {
        $line1   = \AlibabaCloud\Client\env('PRIVATE_KEY_LINE_1');
        $content = <<<EOT
-----BEGIN PRIVATE KEY-----
$line1
aSVN0DOlFZAx8kIkDaRAVNLuuKv4fvGbKgYeOh2aGOhfIKHHNX20YedFzKFinBAtSVfYDMVX+8iM
NKJNjC46kCWq9n7+wIdyeRPnP0exVs0dx+XU9hzChD8zmQaiTyodDCarxJTQ0uOerMt38/pDptpN
yjEeitl8hwyR2TvblqEKdZurTLGrhbnYZJgureRyQUYjl40cRqZEmorAM0d6rPgq3Zl1IS2zF6IX
TBGJ749PBty+S9h6f8/sThgQCdV3xkgHdhekzL02+z868tnMjlo7E4QzfdnEohnt+ffYyJgbSMto
LO/sjWsIbkZJAgMBAAECggEAZgKwAslDRr30xjnlarat1XFH0Yp7/W+Z7MQYtlMXrob7h6+h+mDQ
2wGXGnYpyNwtxbQydga2KYC25jQ4t/PnCdmDnySi6YmwY7rQMhvfnm9UJeK273MtaiPR+wUBQtRY
08aXboeH3EzxwfC9D9fcBK1sMuJC58aN8WH02jvvW7kwiiPcVFb61XY4iZVMR8MciXP7uwDoswF+
GsZYsI9HH6XvnHcY3ZCgj9ST7cxsRZAlpX55M1qzoxf26hHOtEHvamho67PDPsT/fspq0hALJHln
NlJAPnc2tjIiliUD1piIrwqbv8ITYlR1O++rBZv5mFRO39LMxMaZpvIkwqPqrQKBgQDWs2cofQjU
nNfkIWAPBOY/+jitBFh6uaVjrgf9Y5DpliOFwtCqCKe8219/GhbQfwLGG+WzPWZnd1/QGCcuWVsq
p4UVJDFjk2nsPDOnaWofOZrPrD96Qicnw53xl14oQ2auAD3jQtTtfRrjGmM4LIRUWf89iFMqq3ii
QH9p39qg3wKBgQCtqKPpBsLTvtsbahl6acdPFfAygLnD7RAHTO7EiyKNq3frdnS5R8AoUpY1x/7L
WSEM5aVRfOfwg1k1wIBzcMCI2sx6x7i62DgdEL1Zythuntm5HmMAhGl+XRCnLpToi+BXxPTnMAbB
vf0nFQdQJoJArNM1Ck8BvWeq8xb9nN011wKBgQDWanB5ZPVur/yDnjk6hqAUAKadU5uxZLmhZOoh
yk+sl/591WNijCZIW6VxX/Ks4ks44h9x873TUspjHdvzU9XSMV6dEHoqgcvk2vKTHJmY+YR8Jf92
753+/kM8RPkJqNZgq2kjD1lqm+hAKdgw/3RgcUiQgRbdpEVjdJpKd/71bQKBgCVT1X+2U1R+dsxq
vvVAHXZTaeEBKG0D3Okk0UHwAkpfbBRxzt8wnA5OyjjfN1ZwXxlNl35vkc9x/FAAg9vMhaYlGcTe
f0eySEV/HqRZZLJKdNREwtUOoTpnOLgm3B0sS9mx3U6AVUN52ht3eq3wyRirzW5eO+NM2ia1v+Bd
wnLbAoGAZ3Xmb3ubMKkuEVu3+S1Tr/Zz1qDtuhZqz8Bq/DyH3296xcK3BaaZ1+uDlbyrvI2caubX
JSvmwzTiRLZ7uTKrRZJ+Y8Qmnw1VeBJtGR5u9Y2olCBU1gUImLJUrZkxV7o7hDWCboWZ7mBb6Sxa
x8FAVJKZe6YfOYPx2OQzuLGRXCI=
-----END PRIVATE KEY-----

EOT;

        return (new static($content, 'rsa_ok'))->url();
    }

    /**
     * @return string
     */
    public static function badPrivateKey()
    {
        $content = <<<EOT
-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBANo4ozuqmZ3znf9G
gSYfSQjHf3bhqOgY3aDV4dItmfGpekj5lam7iVeVaM/+qaA763ycbwtdgzJmgV5k
nUyN0sa0CExMtuxj2mPGEypB1PlT9cdxVeV7tNUafdGivZgux/6/HvfUL+5+BscP
QxLJG8V9KmmqF6Fbk3QUDLK1M9hPAgMBAAECgYA7dLMEzraMEpQ5uTv25w8/FRvl
mEQhAkEAj74/cUdpoiM0m4Id392/HaeJik3pJhLvR0xp424/CBwTR/49ZZD121nd
DNEk+cojqC7adcIVQ9x6jFfejegN1QJBANGjzvTjPW/OhbU/TZXZFy9hrdYSLd69
OP0lHMsIp6XBB7CFA3y6w2qMCUPjJ3wOTglyBsKjoSRuPxTQ9TGS9IECQQClahFq
K44HPAaADobsh8tS9KxW/bxNF6yLvssj8is4Z2sRTRFfrulQcf79JiJND5DAV866
KnLZdZy5DK6T/MmX
-----END PRIVATE KEY-----
EOT;

        return (new static($content))->url();
    }
}
