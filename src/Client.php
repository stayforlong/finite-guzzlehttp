<?php declare(strict_types=1);

namespace StayForLong\FiniteGuzzleHTTP;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * HTTP Client which grants finite timeouts for requests using cURL handler to avoid indefinite waits.
 */
class Client
{
    /**
     * Default HTTP request timeout in seconds.
     *
     * @var float
     */
    private const DEFAULT_TIMEOUT = 10.;

    /** @var string */
    private const VERSION = '0.1.0';

    /** @var GuzzleClient */
    private $client;

    /** @var float */
    private $timeout;

    /**
     * @param GuzzleClient $client
     * @param float $timeout
     */
    public function __construct(GuzzleClient $client, float $timeout = self::DEFAULT_TIMEOUT)
    {
        $this->client = $client;
        $this->timeout = $timeout;
    }

    /**
     * @inheritDoc
     */
    public function get(UriInterface $uri, array $options = [])
    {
        return $this->client->get($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function head(UriInterface $uri, array $options = [])
    {
        return $this->client->head($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function put(UriInterface $uri, array $options = [])
    {
        return $this->client->put($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function post(UriInterface $uri, array $options = [])
    {
        return $this->client->post($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function patch(UriInterface $uri, array $options = [])
    {
        return $this->client->patch($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function delete(UriInterface $uri, array $options = [])
    {
        return $this->client->delete($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function getAsync(UriInterface $uri, array $options = [])
    {
        return $this->client->getAsync($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function headAsync(UriInterface $uri, array $options = [])
    {
        return $this->client->headAsync($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function putAsync(UriInterface $uri, array $options = [])
    {
        return $this->client->putAsync($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function postAsync(UriInterface $uri, array $options = [])
    {
        return $this->client->postAsync($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function patchAsync(UriInterface $uri, array $options = [])
    {
        return $this->client->patchAsync($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function deleteAsync(UriInterface $uri, array $options = [])
    {
        return $this->client->deleteAsync($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function sendAsync(RequestInterface $uri, array $options = [])
    {
        return $this->client->sendAsync($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function send(RequestInterface $uri, array $options = [])
    {
        return $this->client->send($uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function requestAsync(string $method, $uri = '', array $options = [])
    {
        return $this->client->requestAsync($method, $uri, $this->applyOptions($options));
    }

    /**
     * @inheritDoc
     */
    public function request(string $method, $uri = '', array $options = [])
    {
        return $this->client->request($method, $uri, $this->applyOptions($options));
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function applyOptions(array $options): array
    {
        if (!isset($options['headers'])) {
            $options += ['headers' => ['User-Agent' => $this->defaultUserAgent()]];
        }

        if (!isset($options['connect_timeout'])) {
            $options += ['connect_timeout' => $this->timeout];
        }

        if (!isset($options['read_timeout'])) {
            $options += ['read_timeout' => $this->timeout];
        }

        if (!isset($options['timeout'])) {
            $options += ['timeout' => $this->timeout];
        }

        return $options;
    }

    /**
     * @return string
     */
    private function defaultUserAgent(): string
    {
        return 'StayForLong/FiniteGuzzleHTTP/'.Client::VERSION.' curl/'.\curl_version()['version'].' PHP/'.PHP_VERSION;
    }
}
