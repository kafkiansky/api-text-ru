<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Text;

use Kafkiansky\TextRu\Api\TextruMethod;

/**
 * @template T of TextUid
 *
 * @template-extends TextruMethod<T>
 */
final class CheckText extends TextruMethod
{
    private string $text;

    /**
     * @var list<non-empty-string>
     */
    private array $exceptDomain = [];

    /**
     * @var list<non-empty-string>
     */
    private array $exceptUrl = [];
    private ?string $visible = null;
    private ?string $copying = null;
    private ?string $callback = null;

    public function __construct(string $text)
    {
        if ('' === $text) {
            throw new \InvalidArgumentException('Text cannot be empty.');
        }

        $this->text = $text;
    }

    public static function new(string $text): CheckText
    {
        return new CheckText($text);
    }

    /**
     * @param list<non-empty-string> $domains
     *
     * @return CheckText
     */
    public function exceptDomain(array $domains): CheckText
    {
        $this->exceptDomain = $domains;

        return $this;
    }

    /**
     * @param list<non-empty-string> $urls
     *
     * @return CheckText
     */
    public function exceptUrl(array $urls): CheckText
    {
        $this->exceptUrl = $urls;

        return $this;
    }

    /**
     * @return CheckText
     */
    public function shouldBeVisible(): CheckText
    {
        $this->visible = 'vis_on';

        return $this;
    }

    /**
     * @return CheckText
     */
    public function mustNotBeCopying(): CheckText
    {
        $this->copying = 'noadd';

        return $this;
    }

    /**
     * @param non-empty-string $uri
     *
     * @return CheckText
     */
    public function withCallback(string $uri): CheckText
    {
        /** @psalm-suppress TypeDoesNotContainType */
        if ('' === $uri) {
            throw new \InvalidArgumentException('Callback cannot be an empty string.');
        }

        $this->callback = $uri;

        return $this;
    }

    public function path(): string
    {
        return 'post';
    }

    public function serializeTo(): string
    {
        return TextUid::class;
    }

    public function payload(): array
    {
        return array_filter([
            'text' => $this->text,
            'visible' => $this->visible,
            'copying' => $this->copying,
            'callback' => $this->callback,
            'exceptdomain' => 0 < count($this->exceptDomain) ? implode(',', $this->exceptDomain) : null,
            'excepturl' => 0 < count($this->exceptUrl) ? implode(',', $this->exceptUrl) : null,
        ]);
    }
}
