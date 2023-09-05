<?php

namespace Moneroo;

use Moneroo\Configs\Config;
use Moneroo\Exceptions\InvalidPayloadException;

class Moneroo
{
    use Traits\Request;

    /**
     *  API public key.
     */
    public string $publicKey;

    /**
     *  API secret key.
     */
    public string $secretKey;

    /**
     *  API base URL.
     */
    public string $baseUrl;

    public function __construct(
        string $publicKey,
        string $secretKey,
        bool $devMode = false,
        string $baseUrl = Config::BASE_URL
    ) {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;

        $this->baseUrl = ($devMode === true)
            ? $baseUrl
            : Config::BASE_URL;

        if (empty($this->publicKey)) {
            throw new InvalidPayloadException('Public key is not set or not a string.');
        }

        if (empty($this->secretKey)) {
            throw new InvalidPayloadException('Secret key is not set or not a string.');
        }
    }
}
