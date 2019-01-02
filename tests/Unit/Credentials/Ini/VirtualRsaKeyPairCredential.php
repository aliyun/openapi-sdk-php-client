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
        $content = <<<EOT
-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBANo4ozuqmZ3znf9G
gSYfSQjHf3bhqOgY3aDV4dItmfGpekj5lam7iVeVaM/+qaA763ycbwtdgzJmgV5k
nUyN0sa0CExMtuxj2mPGEypB1PlT9cdxVeV7tNUafdGivZgux/6/HvfUL+5+BscP
QxLJG8V9KmmqF6Fbk3QUDLK1M9hPAgMBAAECgYA7dLMEzraMEpQ5uTv25w8/FRvl
iBY9Jok8CQo9+a636TUoLNhaJn6FHnAwO3J79ddzXCvlLNVSJhuZXFB/SyTh/ZJO
ytUtRVqzEMmYAH2ssuQ5jX2ZbTvKs+7ZD1K+ErfAyEmKq9kgjdZlHawbY9ZYNHFX
N+teLtNgS6HkDdAQAQJBAP0W5aC5DnCiW+dzpn59vncxuErhTuL2jzVFrcULsff1
9FYCNd1MPd+eOuQiEgolNEzFmXHUMkZ3d7fUKwLkjm8CQQDcuxZtFOtVSKfR0zsh
ifcvGpcnf/Vouc0CrHv6bc687jSeLtZNi20T/HZRa2zKLa16lFwD7N27ZSyL5xnS
mEQhAkEAj74/cUdpoiM0m4Id392/HaeJik3pJhLvR0xp424/CBwTR/49ZZD121nd
DNEk+cojqC7adcIVQ9x6jFfejegN1QJBANGjzvTjPW/OhbU/TZXZFy9hrdYSLd69
OP0lHMsIp6XBB7CFA3y6w2qMCUPjJ3wOTglyBsKjoSRuPxTQ9TGS9IECQQClahFq
K44HPAaADobsh8tS9KxW/bxNF6yLvssj8is4Z2sRTRFfrulQcf79JiJND5DAV866
KnLZdZy5DK6T/MmX
-----END PRIVATE KEY-----
EOT;
        return (new static($content))->url();
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
