<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\HttpAdapter;

/**
 * @psalm-immutable
 */
final class HttpResponse
{
    /**
     * @param array<string, string|int|array<array-key, mixed>> $payload
     * @param bool $ok
     * @param string|null $error
     */
    private function __construct(
        public array $payload,
        public bool $ok,
        public ?string $error = null
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param array<string, string|int|array<array-key, mixed>> $payload
     *
     * @return HttpResponse
     */
    public static function ok(array $payload): HttpResponse
    {
        return new HttpResponse($payload, true);
    }

    /**
     * @psalm-pure
     *
     * @param string $error
     *
     * @return HttpResponse
     */
    public static function error(string $error): HttpResponse
    {
        return new HttpResponse([], false, $error);
    }
}
