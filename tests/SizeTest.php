<?php

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\Interaction\Account\Size;
use PHPUnit\Framework\TestCase;

final class SizeTest extends TestCase
{
    public function testCreatedSuccess(): void
    {
        $size = Size::reconstituteFromArray(['size' => 10]);
        self::assertEquals(10, $size->value);
    }

    public function testExceptionThrown(): void
    {
        self::expectExceptionMessage('Size field expected, but not found.');
        self::expectException(\InvalidArgumentException::class);
        Size::reconstituteFromArray([]);
    }
}
