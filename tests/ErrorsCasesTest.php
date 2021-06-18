<?php

/**
 * This file is part of kafkiansky/api-text-ru package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\TextRu\Api\Tests;

use Kafkiansky\TextRu\Api\Interaction\Text\CheckText;

final class ErrorsCasesTest extends InteractionTestCase
{
    public function providerErrors(): \Generator
    {
        yield [110, 'Отсутствует проверяемый текст'];
        yield [111, 'Проверяемый текст пустой'];
        yield [112, 'Проверяемый текст слишком короткий'];
        yield [113, 'Проверяемый текст слишком большой. Разбейте текст на несколько частей'];
        yield [120, 'Отсутствует пользовательский ключ'];
        yield [121, 'Пользовательский ключ пустой'];
        yield [140, 'Ошибка доступа на сервере. Попробуйте позднее'];
        yield [141, 'Несуществующий пользовательский ключ'];
        yield [142, 'Нехватка символов на балансе'];
        yield [143, 'Ошибка при передаче параметров на сервере. Попробуйте позднее'];
        yield [144, 'Ошибка сервера. Попробуйте позднее'];
        yield [145, 'Ошибка сервера. Попробуйте позднее'];
        yield [146, 'Доступ ограничен'];
        yield [150, 'Шинглов не найдено. Возможно текст слишком короткий'];
        yield [160, 'Отсутствует проверяемый uid текста'];
        yield [161, 'Uid текста пустой'];
        yield [170, 'Отсутствует пользовательский ключ'];
        yield [171, 'Пользовательский ключ пустой'];
        yield [180, 'Текущая пара ключ-uid отсутствует в базе'];
        yield [181, 'Текст ещё не проверен'];
        yield [182, 'Текст проверен с ошибками. Деньги будут возвращены'];
        yield [183, 'Ошибка сервера. Попробуйте позднее'];
        yield [429, 'Исчерпан текущий лимит запросов. Попробуйте позже'];
    }

    /**
     * @dataProvider providerErrors
     *
     * @param int $code
     * @param string $message
     */
    public function testThatErrorMessageShowsCorrect(int $code, string $message): void
    {
        $provider = $this->createInteractionProvider(
            json_encode(['error_code' => $code, 'error_desc' => $message])
        );

        $result = $provider->call(new CheckText('Lorem ipsum. Lorem ipsum. Lorem ipsum. Lorem ipsum.'));

        self::assertTrue($result->isFailed());
        self::assertEquals($message, $result->obtain());
    }
}
