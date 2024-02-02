<?php

namespace Moneroo\Traits;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use JsonException;
use Moneroo\Configs\Config;
use Moneroo\Exceptions\BadRequestException;
use Moneroo\Exceptions\ForbiddenException;
use Moneroo\Exceptions\InvalidPayloadException;
use Moneroo\Exceptions\InvalidResourceException;
use Moneroo\Exceptions\NotAcceptableException;
use Moneroo\Exceptions\ServerErrorException;
use Moneroo\Exceptions\ServiceUnavailableException;
use Moneroo\Exceptions\UnauthorizedException;

trait Request
{
    /**
     * Send request to the API.
     *
     * @param string                $method   - The HTTP method to use (GET, POST, PUT, PATCH, DELETE)
     * @param array                 $data     - The data to send
     * @param string                $endpoint - The API endpoint
     * @param GuzzleHttpClient|null $client   - The Guzzle HTTP client to use
     */
    public function sendRequest(string $method, array $data, string $endpoint, GuzzleHttpClient $client = null)
    {
        $baseUrl = (substr($this->baseUrl, -1) === '/')
            ? $this->baseUrl
            : $this->baseUrl . '/';

        $client = $client ?: new GuzzleHttpClient([
            'base_uri' => $baseUrl,
            'timeout'  => Config::TIMEOUT,
            'headers'  => [
                'User-Agent'    => 'Moneroo PHP SDK v' . Config::VERSION,
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
        ]);

        try {
            $response = $client->request($method, $endpoint, [
                'json'        => $data,
                'http_errors' => false,
            ]);

            $responsePayload = $this->decodePayload($response);

            return $this->processResponse($response, $responsePayload);
        } catch (ConnectException|JsonException|GuzzleException $e) {
            throw new ServerErrorException($e->getMessage());
        }
    }

    /**
     * @throws JsonException
     */
    private function decodePayload($response): object
    {
        return json_decode($response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Process the response.
     */
    private function processResponse(Response $response, object $responsePayload)
    {
        switch ($response->getStatusCode()) {
            case 201:
            case 200:
                return $responsePayload->data ?? $responsePayload;
            case 401:
                throw new UnauthorizedException($responsePayload->message ?? 'Unauthorized, Status Code: ' . $response->getStatusCode());
            case 403:
                throw new ForbiddenException($responsePayload->message ?? 'Forbidden, Status Code: ' . $response->getStatusCode());
            case 404:
                throw new InvalidResourceException($responsePayload->message ?? 'Not Found, Status Code: ' . $response->getStatusCode());
            case 400:
                throw new BadRequestException($responsePayload->message ?? 'Bad Request, Status Code: ' . $response->getStatusCode());
            case 422:
                throw new InvalidPayloadException($responsePayload->message ?? 'Invalid Payload, Status Code: ' . $response->getStatusCode());
            case 406:
                throw new NotAcceptableException($responsePayload->message ?? 'Not Acceptable, Status Code: ' . $response->getStatusCode());
            case 503:
                throw new ServiceUnavailableException($responsePayload->message ?? 'Service Unavailable, Status Code: ' . $response->getStatusCode());
            default:
                throw new ServerErrorException($responsePayload->message ?? 'Server Error, Status Code: ' . $response->getStatusCode());
        }
    }
}
