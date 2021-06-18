<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Verification;

use Kafkiansky\TextRu\Api\Interaction\ShouldBeDeserialized;

/**
 * @psalm-immutable
 */
final class TextVerificationResult implements ShouldBeDeserialized
{
    public string $textUnique;
    public ResultJson $resultJson;
    public SpellCheck $spellCheck;
    public SeoCheck $check;

    public function __construct(string $textUnique, ResultJson $resultJson, SpellCheck $spellCheck, SeoCheck $check)
    {
        $this->textUnique = $textUnique;
        $this->resultJson = $resultJson;
        $this->spellCheck = $spellCheck;
        $this->check = $check;
    }

    public static function reconstituteFromArray(array $payload): object
    {
        if (!isset($payload['text_unique'])) {
            throw new \InvalidArgumentException('Text unique is not defined.');
        }

        /** @var string $textUnique */
        $textUnique = $payload['text_unique'];

        return new TextVerificationResult(
            $textUnique,
            ResultJson::fromArray($payload),
            SpellCheck::fromArray($payload),
            SeoCheck::fromArray($payload),
        );
    }
}
