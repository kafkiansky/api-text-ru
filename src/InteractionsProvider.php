<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api;

use Kafkiansky\TextRu\Api\HttpAdapter\CurlHttpClientAdapter;
use Kafkiansky\TextRu\Api\HttpAdapter\GuzzleHttpClientAdapter;
use Kafkiansky\TextRu\Api\HttpAdapter\HttpClient;
use Kafkiansky\TextRu\Api\Interaction\ShouldBeDeserialized;
use Kafkiansky\TextRu\Api\Result\Failure;
use Kafkiansky\TextRu\Api\Result\Result;
use Kafkiansky\TextRu\Api\Result\Success;

final class InteractionsProvider
{
    private UserKey $userKey;
    private HttpClient $httpClient;

    public function __construct(
        UserKey $userKey,
        ?HttpClient $httpClient = null
    ) {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient ?: (function (): HttpClient {
            if (interface_exists('\GuzzleHttp\ClientInterface')) {
                return new GuzzleHttpClientAdapter();
            }

            if (extension_loaded('curl')) {
                return new CurlHttpClientAdapter();
            }

            throw new \RuntimeException(
                sprintf('Neither curl extension, nor guzzlehttp/guzzle not found on your machine, please install one of them.')
            );
        })();
    }

    public function call(TextruMethod $method): Result
    {
        $httpResponse = $this->httpClient->request($method->httpMethod(), $method->path(), array_merge([
            'userkey' => $this->userKey->value,
        ], $method->payload()));

        if ($httpResponse->ok) {
            /** @var ShouldBeDeserialized $shouldBeDeserialized */
            $shouldBeDeserialized = $method->serializeTo();

            return new Success($shouldBeDeserialized::reconstituteFromArray($httpResponse->payload));
        }

        return new Failure($httpResponse->error ?: '');
    }
}
