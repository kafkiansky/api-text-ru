<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests\Tools;

use Kafkiansky\TextRu\Api\HttpAdapter\HttpClient;

final class FakeHttpClient extends HttpClient
{
    public static array $lastPayload = [];

    public function __construct(
        private string $response,
        private int $statusCode = 200,
        string $endpoint = self::DEFAULT_ENDPOINT
    ) {
        parent::__construct($endpoint);
    }

    public static function flush(): void
    {
        self::$lastPayload = [];
    }

    protected function doRequest(string $method, string $endpoint, array $payload = [], array $headers = []): array
    {
        self::$lastPayload = $payload;

        return [$this->statusCode, $this->response];
    }
}
