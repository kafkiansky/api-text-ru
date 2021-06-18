<?php

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\Interaction\Text\TextUid;
use PHPUnit\Framework\TestCase;

final class TextUidTest extends TestCase
{
    public function testCreatedSuccess(): void
    {
        $textUid = TextUid::reconstituteFromArray(['text_uid' => '5235235235']);
        self::assertEquals('5235235235', $textUid->uid);
    }

    public function testInvalidUid(): void
    {
        self::expectExceptionMessage('Text uid is required, but not defined.');
        self::expectException(\InvalidArgumentException::class);
        TextUid::reconstituteFromArray([]);
    }
}
