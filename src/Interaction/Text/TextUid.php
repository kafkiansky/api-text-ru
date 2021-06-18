<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Interaction\Text;

use Kafkiansky\TextRu\Api\Interaction\ShouldBeDeserialized;

/**
 * @psalm-immutable
 */
final class TextUid implements ShouldBeDeserialized
{
    public function __construct(public string $uid)
    {
    }

    public static function reconstituteFromArray(array $payload): object
    {
        if (isset($payload['text_uid'])) {
            /** @var string $uid */
            $uid = $payload['text_uid'];

            return new TextUid($uid);
        }

        throw new \InvalidArgumentException('Text uid is required, but not defined.');
    }
}
