<?php

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\Interaction\Verification\TextVerificationResult;
use PHPUnit\Framework\TestCase;

final class TextVerificationResultTest extends TestCase
{
    public function testCreatedSuccess(): void
    {
        /** @var TextVerificationResult $result */
        $result = TextVerificationResult::reconstituteFromArray([
            'text_unique' => '100.00',
            'result_json' => json_encode(['date_check' => '18.06.2021 08:36:15'])
        ]);

        self::assertEquals('100.00', $result->textUnique);
        self::assertEquals('18.06.2021 08:36:15', $result->resultJson->dateCheck);
    }

    public function testInvalidData(): void
    {
        self::expectExceptionMessage('Text unique is not defined.');
        self::expectException(\InvalidArgumentException::class);
        TextVerificationResult::reconstituteFromArray([]);
    }

    public function testInvalidDataWithoutResultJson(): void
    {
        self::expectExceptionMessage('Required field "result_json" not defined.');
        self::expectException(\InvalidArgumentException::class);
        TextVerificationResult::reconstituteFromArray(['text_unique' => '100.00']);
    }
}
