<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\HttpAdapter;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

final class GuzzleHttpClientAdapter extends HttpClient
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $guzzle;

    public function __construct(
        ?ClientInterface $guzzle = null,
        private int $timeout = self::DEFAULT_TIMEOUT,
        private int $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT,
        string $endpoint = self::DEFAULT_ENDPOINT
    ) {
        parent::__construct($endpoint);
        $this->guzzle = $guzzle ?: new Client();
    }

    protected function doRequest(string $method, string $endpoint, array $payload = [], array $headers = []): array
    {
        $response = $this->guzzle->request($method, $endpoint, [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::TIMEOUT => $this->timeout,
            RequestOptions::CONNECT_TIMEOUT => $this->connectTimeout,
            RequestOptions::HEADERS => $headers,
            RequestOptions::FORM_PARAMS => $payload
        ]);

        return [$response->getStatusCode(), (string) $response->getBody()];
    }
}
