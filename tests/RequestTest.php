<?php

namespace Moneroo\Tests;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Moneroo\Traits\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    use Request;
    public string $secretKey;
    public string $baseUrl;
    public GuzzleHttpClient $client;

    public function setUp(): void
    {
        $this->secretKey = 'some_secret_key';
        $this->baseUrl = 'https://api.example.com';

        $handlerStack = HandlerStack::create();
        $this->client = new GuzzleHttpClient(['handler' => $handlerStack]);
    }

    private function prepareMockResponse($statusCode, array $body = [], $headers = []): void
    {
        $response = new Response($statusCode, $headers, json_encode($body, JSON_THROW_ON_ERROR));
        $mock = new MockHandler([$response]);
        $handlerStack = HandlerStack::create($mock);
        $this->client = new GuzzleHttpClient(['handler' => $handlerStack]);
    }

    /**
     * It should return a valid response for 200 status code.
     *
     * @test
     */
    public function it_should_return_a_valid_response_for_200_status_code(): void
    {
        $this->prepareMockResponse(200, ['data' => 'some data']);

        $response = $this->sendRequest('get', [], 'some-endpoint', $this->client);

        $this->assertEquals('some data', $response);
    }

    /**
     * It should return a valid response for 201 status code.
     *
     * @test
     */
    public function it_should_return_a_valid_response_for_201_status_code(): void
    {
        $this->prepareMockResponse(201, ['data' => 'created data']);

        $response = $this->sendRequest('get', [], 'some-endpoint', $this->client);

        $this->assertEquals('created data', $response);
    }

    /**
     * It should throw an exception for 400 status code.
     *
     * @test
     */
    public function it_should_throw_an_exception_for_400_status_code(): void
    {
        $this->prepareMockResponse(400, ['message' => 'Bad Request']);

        $this->expectException(\Moneroo\Exceptions\BadRequestException::class);
        $this->expectExceptionMessage('Bad Request');

        $this->sendRequest('get', [], 'some-endpoint', $this->client);
    }

    /**
     * It should throw an exception for 401 status code.
     *
     * @test
     */
    public function it_should_throw_an_exception_for_401_status_code(): void
    {
        $this->prepareMockResponse(401, ['message' => 'Unauthorized']);

        $this->expectException(\Moneroo\Exceptions\UnauthorizedException::class);
        $this->expectExceptionMessage('Unauthorized');

        $this->sendRequest('get', [], 'some-endpoint', $this->client);
    }

    /**
     * It should throw an exception for 403 status code.
     *
     * @test
     */
    public function it_should_throw_an_exception_for_403_status_code(): void
    {
        $this->prepareMockResponse(403, ['message' => 'Forbidden']);

        $this->expectException(\Moneroo\Exceptions\ForbiddenException::class);
        $this->expectExceptionMessage('Forbidden');

        $this->sendRequest('get', [], 'some-endpoint', $this->client);
    }

    /**
     * It should throw an exception for 404 status code.
     *
     * @test
     */
    public function it_should_throw_an_exception_for_404_status_code(): void
    {
        $this->prepareMockResponse(404, ['message' => 'Not Found']);

        $this->expectException(\Moneroo\Exceptions\InvalidResourceException::class);
        $this->expectExceptionMessage('Not Found');

        $this->sendRequest('get', [], 'some-endpoint', $this->client);
    }
}
