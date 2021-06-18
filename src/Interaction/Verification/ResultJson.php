<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Verification;

/**
 * @psalm-immutable
 */
final class ResultJson
{
    public string $dateCheck;
    public string $unique;
    public ?string $clearText;

    /**
     * @var array
     */
    public array $urls;

    /**
     * @param string $dateCheck
     * @param string $unique
     * @param string|null $clearText
     * @param array $urls
     */
    public function __construct(
        string $dateCheck,
        string $unique,
        ?string $clearText = null,
        array $urls = []
    ) {
        $this->dateCheck = $dateCheck;
        $this->unique = $unique;
        $this->clearText = $clearText;
        $this->urls = $urls;
    }

    /**
     * @param array<string, string|int|array<array-key, mixed>> $payload
     *
     * @return ResultJson
     */
    public static function fromArray(array $payload): ResultJson
    {
        if (!isset($payload['result_json'])) {
            throw new \InvalidArgumentException('Required field "result_json" not defined.');
        }

        /** @var string $resultJson */
        $resultJson = $payload['result_json'];

        /** @var array{date_check: string, unique?: string|int} $payload */
        $payload = json_decode($resultJson, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(sprintf('Invalid result_json "%s"', json_last_error()));
        }

        $dateCheck = $payload['date_check'];
        $unique = $payload['unique'] ?? '';

        $result = new ResultJson($dateCheck, (string) $unique);

        if (isset($payload['urls'])) {
            /** @var array{url: string, plagiat: string, words: array} $urls */
            $urls = $payload['urls'];

            $result->urls = $urls;
        }

        if (isset($payload['clear_text'])) {
            /** @var string $clearText */
            $clearText = $payload['clear_text'];

            $result->clearText = $clearText;
        }

        return $result;
    }
}
