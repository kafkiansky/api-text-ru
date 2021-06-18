<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\HttpAdapter;

final class CurlHttpClientAdapter extends HttpClient
{
    public function __construct(
        private int $timeout = self::DEFAULT_TIMEOUT,
        private int $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT,
        string $endpoint = self::DEFAULT_ENDPOINT
    ) {
        parent::__construct($endpoint);
    }

    /**
     * {@inheritdoc}
     */
    public function doRequest(string $method, string $endpoint, array $payload = [], array $headers = []): array
    {
        $curl = curl_init($endpoint);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        if (0 < count($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->prepareHeaders($headers));
        }

        switch ($method) {
            case self::POST:
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS,  $payload);

                break;
            default:
                // no-op
        }

        /** @var string $response */
        $response = curl_exec($curl);

        /** @var int $statusCode */
        $statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        curl_close($curl);

        return [$statusCode, $response];
    }

    /**
     * @param array<string, string|int|float> $headers
     *
     * @return list<non-empty-string>
     */
    private function prepareHeaders(array $headers): array
    {
        $result = [];

        foreach ($headers as $key => $value) {
            $result[] = $key . ': ' . $value;
        }

        return $result;
    }
}
