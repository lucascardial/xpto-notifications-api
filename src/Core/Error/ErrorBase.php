<?php

namespace Core\Error;

/**
 * Class ErrorBase
 * This class is the base class for all known errors in the application.
 * It is used to standardize the error response and make it easier to handle errors in the application.
 *
 * @package Core\Error
 * @property string $message The error message
 * @property string $detail The detailed error message
 * @property HttpServerErrorEnum|HttpClientErrorCodeEnum $statusCode The HTTP status code of the error
 * @property string|null $errorCode The error code
 * @property array $extra Any extra information about the error
 */
class ErrorBase extends \Exception
{
    public function __construct(
        string $message,
        public readonly string $detail,
        HttpServerErrorEnum | HttpClientErrorCodeEnum $statusCode,
        public readonly ?string $errorCode = null,
        public readonly array $extra = []
    ){
        parent::__construct($message, $statusCode->value);
    }
}
