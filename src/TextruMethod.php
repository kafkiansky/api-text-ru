<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api;

use Kafkiansky\TextRu\Api\HttpAdapter\HttpClient;
use Kafkiansky\TextRu\Api\Interaction\ShouldBeDeserialized;

/**
 * @psalm-import-type HttpMethod from \Kafkiansky\TextRu\Api\HttpAdapter\HttpClient
 *
 * @template-covariant T implements ShouldBeDeserialized
 */
abstract class TextruMethod
{
    /**
     * @return string
     */
    abstract public function path(): string;

    /**
     * @return HttpMethod
     */
    public function httpMethod(): string
    {
        return HttpClient::POST;
    }

    /**
     * @return class-string<T>
     */
    abstract public function serializeTo(): string;

    /**
     * @return array<string, mixed>
     */
    abstract public function payload(): array;

    /**
     * @return array<string, string|int|float>
     */
    public function headers(): array
    {
        return [];
    }
}
