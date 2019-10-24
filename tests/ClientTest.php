<?php declare(strict_types=1);

namespace StayForLong\FiniteGuzzleHTTP\Tests;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use StayForLong\FiniteGuzzleHTTP\Client;

class ClientTest extends TestCase
{
    /** @var Client */
    private $client;

    /** @var string */
    private $endpoint;

    public function setUp(): void
    {
        $this->client = new Client(new GuzzleClient, 0.01);
        $this->endpoint = 'http://stayforlong.com/';
    }

    public function testGetHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->get(new Uri($this->endpoint));
        });
    }

    public function testHeadHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->head(new Uri($this->endpoint));
        });
    }

    public function testPutHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->put(new Uri($this->endpoint));
        });
    }

    public function testPostHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->post(new Uri($this->endpoint));
        });
    }

    public function testPatchHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->patch(new Uri($this->endpoint));
        });
    }

    public function testDeleteHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->delete(new Uri($this->endpoint));
        });
    }

    public function testGetAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->getAsync(new Uri($this->endpoint))]);
        });
    }

    public function testHeadAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->headAsync(new Uri($this->endpoint))]);
        });
    }

    public function testPutAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->putAsync(new Uri($this->endpoint))]);
        });
    }

    public function testPostAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->postAsync(new Uri($this->endpoint))]);
        });
    }

    public function testPatchAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->patchAsync(new Uri($this->endpoint))]);
        });
    }

    public function testDeleteAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->deleteAsync(new Uri($this->endpoint))]);
        });
    }

    public function testSendAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->sendAsync(new Request('get', $this->endpoint))]);
        });
    }

    public function testSendHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->send(new Request('get', $this->endpoint));
        });
    }

    public function testRequestAsyncHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            Promise\unwrap([$this->client->requestAsync('get', $this->endpoint)]);
        });
    }

    public function testRequestHasFiniteTimeout(): void
    {
        $this->checkTimedOutException(function () {
            $this->client->request('get', $this->endpoint);
        });
    }

    private function checkTimedOutException(\Closure $closure)
    {
        try {
            $closure();
        } catch (ConnectException $e) {
            // error 28 belongs to timed out operation https://curl.haxx.se/libcurl/c/libcurl-errors.html
            $this->assertStringContainsString('cURL error 28', $e->getMessage());
        }
    }
}
