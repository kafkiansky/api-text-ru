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
 * @psalm-type HttpMethod = HttpClient::POST | HttpClient::GET
 */
abstract class HttpClient
{
    public const POST = 'POST';
    public const GET = 'GET';

    /**
     * Default response timeout (in seconds)
     */
    protected const DEFAULT_TIMEOUT = 10;

    /**
     * Default connect timeout (in seconds)
     */
    protected const DEFAULT_CONNECT_TIMEOUT = 2;

    /**
     * Default text.ru api endpoint
     */
    protected const DEFAULT_ENDPOINT = 'http://api.text.ru';

    /**
     * Http status code for an ok response
     */
    private const HTTP_OK = 200;

    private const UNKNOWN_ERROR = 'Unknown error.';

    /**
     * @var array<int, string>
     */
    protected const CODES_TO_ERRORS = [
        110 => 'Отсутствует проверяемый текст',
        111 => 'Проверяемый текст пустой',
        112 => 'Проверяемый текст слишком короткий',
        113 => 'Проверяемый текст слишком большой. Разбейте текст на несколько частей',
        120 => 'Отсутствует пользовательский ключ',
        121 => 'Пользовательский ключ пустой',
        140 => 'Ошибка доступа на сервере. Попробуйте позднее',
        141 => 'Несуществующий пользовательский ключ',
        142 => 'Нехватка символов на балансе',
        143 => 'Ошибка при передаче параметров на сервере. Попробуйте позднее',
        144 => 'Ошибка сервера. Попробуйте позднее',
        145 => 'Ошибка сервера. Попробуйте позднее',
        146 => 'Доступ ограничен',
        150 => 'Шинглов не найдено. Возможно текст слишком короткий',
        160 => 'Отсутствует проверяемый uid текста',
        161 => 'Uid текста пустой',
        170 => 'Отсутствует пользовательский ключ',
        171 => 'Пользовательский ключ пустой',
        180 => 'Текущая пара ключ-uid отсутствует в базе',
        181 => 'Текст ещё не проверен',
        182 => 'Текст проверен с ошибками. Деньги будут возвращены',
        183 => 'Ошибка сервера. Попробуйте позднее',
        429 => 'Исчерпан текущий лимит запросов. Попробуйте позже',
    ];

    public function __construct(private string $endpoint = self::DEFAULT_ENDPOINT)
    {
    }

    /**
     * @param HttpMethod $method
     * @param string $path
     * @param array<string, mixed> $payload
     * @param array<string, string|int|float> $headers
     *
     * @return HttpResponse
     */
    final public function request(string $method, string $path, array $payload = [], array $headers = []): HttpResponse
    {
        $endpoint = $this->createEndpoint($this->endpoint, $path);

        [$code, $response] = $this->doRequest($method, $endpoint, $payload, $headers);

        if (self::HTTP_OK !== $code) {
            $error = $response;

            if (isset(self::CODES_TO_ERRORS[$code])) {
                $error = self::CODES_TO_ERRORS[$code];
            }

            return HttpResponse::error($error);
        }

        /** @var array<string, string|int|array<array-key, mixed>> $decodedResponse */
        $decodedResponse = json_decode($response, true);

        if (isset($decodedResponse['error_code'])) {
            /** @var int $errorCode */
            $errorCode = $decodedResponse['error_code'];

            /** @var string $error */
            $error = $decodedResponse['error_desc'] ?? self::UNKNOWN_ERROR;

            if (isset(self::CODES_TO_ERRORS[$errorCode])) {
                $error = self::CODES_TO_ERRORS[$errorCode];
            }

            return HttpResponse::error($error);
        }

        return HttpResponse::ok($decodedResponse);
    }

    /**
     * @param HttpMethod $method
     * @param string $endpoint
     * @param array<string, mixed> $payload
     * @param array<string, string|int|float> $headers
     *
     * @return array{int, string}
     */
    abstract protected function doRequest(
        string $method,
        string $endpoint,
        array $payload = [],
        array $headers = []
    ): array;

    /**
     * @psalm-pure
     *
     * @param string $host
     * @param string $path
     *
     * @return string
     */
    private function createEndpoint(string $host, string $path): string
    {
        return sprintf('%s/%s', trim($host, '/'), trim($path, '/'));
    }
}
