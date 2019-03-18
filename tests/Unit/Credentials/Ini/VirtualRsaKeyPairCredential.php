<?php

namespace AlibabaCloud\Client\Tests\Unit\Credentials\Ini;

/**
 * Class VirtualRsaKeyPairCredential
 *
 * @codeCoverageIgnore
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Credentials\Ini
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
bLJLsNYlhQYkoKgXup7F7X9t2Z0wkOEnRagRuM+mZX3Vr6ZKVcusnH75e1R2a/eF
k95zoHyfj5nGSsSSYwrnNbxAVfbyCvP9QakNE35yM4PH7bCaUbzu/R3dAN+NDY51
edF4krNXlx2RjGVz/+CoD5gUFZZIPiEGxb0XyWNbCdioxj2W3O8eUjW3EZsPCVJh
u+oEYN/v5Lz1uGgPMzQn5d6F/bg+qo2FrqXhYZMrOW0d3b0kdZRCPEnkvpmjuIiU
l/8XE3Qj80TNlYRTlrMTtocJNpqXCsUp5+4+ftxWb1wvS6IDT/YN/uRuWSGIHce1
5Y5CwW3fAgMBAAECggEAAtJQuza/w3JISq+Z5WSFpy8BPT8rwT08ZMwVGbL5hIS9
W2ClTqcUXbD3lTjuK+XKowxKJFPR7130vaxRb+8lQkaGgrSzUVG8Sy6psLyomjnv
7d8ByPd6257vrZFTPpuUmxFkM88nWVVOOAsrBUYdRdzOtP1aibzRre6UUpNQN0nB
FDsg4xbxmh5I3hgSi9WzF8IQTog0lhvqZsAGuHpdBkLyTizdIKL7ZEN9UrdkW14M
4F33pH81nhNOO/rcopAdL0fwaAWE/H1/wuNGH7KGl7EvNTV40lIAhZG3LnElyF9U
ZnuKHIcOPXrwOvxOl8JBOgYHgsK/TtPNHfWloRWhCQKBgQDv/UhQfn0RKQ9wTR4d
Ev1qx9QPASUna0Ww1DAZ+ugm6mBEo70ZE1onJGa0sqdsZbghq3NDqCP0N4TzNTB4
CBaJlUiypdC6E4F/tP/+oeWdUZTtzzQWtxkzjYGaoM9B64KVKYmldiMxp9ce/ArX
FX6FfX/7r/VE+7tAiliCwDs5vQKBgQCh0Ii9Z/tSmiqAo7PAxVgTrWc/KA9/i0w9
PTuzXreeo6jkcurdQ6XNiiMOezGHilGA+cQY1U7RS0toNU9EZD8sZ2muWuA4mtLO
1HS3zQk8oUX/97pBV9rGYxXlBkLB/CbKm13zFdDma/wNwRsUawPYQAJDF2Ed80QW
p+zlIn8JywKBgQC3VSU2ILrILjbWEoOLsGMZfJg58iUA7QjrId2xKyTH/coXBYLC
si7vsfYn2kbeHwK/7er652q3+OW+qYZiW8NjzUAhAVznmVkXRx08107ClH0SAnUH
WU6OPG6iwnAyKoiyDG5TkWEnYNGMoPxi/M+PiKUJj4zt6uRMVKNzFwjnfQKBgCRy
vno7c8bVZwF23kRrrz0vb/Qv593I2LFqm4n5qc6X+rEKmZChbjVwChl28l8fbuBo
Yh1d3tUR6rhcWbCEDB7KZGmbmqnlZdqkzG2iR5Ral1Pizxds3KCXLRVbZaogS/ST
LoRUw6tDY5ENkDX3LPSG5nuKRpvicdHQnXG3ZXolAoGBANTLZ0EMi1iUtKCIXLo/
8b9+OaAPxx0W91iMlNDv6khC3ORWxdllrZxmnIkyK+72hVQBJrtiUxcWyZgzWzEn
AEVoPLRGHSrsCUIE45/p5MjLQRnRr5ymvrVial9BHRgnWaBQKnQCtwqCVz/+uByK
4QFBSU9O6GiZ12niapcL0co6
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
