<?php
namespace antonienko\Ph7lconApi\Response;

class HttpCodes
{
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const NOT_ALLOWED = 405;
    const SERVER_ERROR = 500;
    const SERVICE_UNAVAILABLE = 503;

    private static $codeReason = [
        self::OK                  => 'Ok',
        self::CREATED             => 'Created',
        self::ACCEPTED            => 'Accepted',
        self::BAD_REQUEST         => 'Bad Request',
        self::UNAUTHORIZED        => 'Unauthorized',
        self::FORBIDDEN           => 'Forbidden',
        self::NOT_FOUND           => 'URL Not found',
        self::NOT_ALLOWED         => 'Access not allowed',
        self::SERVER_ERROR        => 'Server internal error',
        self::SERVICE_UNAVAILABLE => 'Service temporarily unavailable',
    ];

    public static function __callStatic($name, $arguments) : HttpCode
    {
        $code = strtoupper($name);
        return new HttpCode(constant("self::$code"), self::$codeReason[constant("self::$code")]);
    }

    public static function getAverageErrorCode(array $codes) : HttpCode
    {
        $all_equal = true;
        $there_is_a_5xx = false;

        $initial = $codes[0];

        foreach ($codes as $code) {
            if ($code !== $initial) {
                $all_equal = false;
            }
            if ($code >= 500) {
                $there_is_a_5xx = true;
            }
        }
        if ($all_equal) {
            return new HttpCode($initial, self::$codeReason[$initial]);
        } elseif ($there_is_a_5xx) {
            return new HttpCode(500, self::$codeReason[500]);
        } else {
            return new HttpCode(400, self::$codeReason[400]);
        }
    }

    public static function isOkCode(int $code) : bool
    {
        return $code < 400;
    }
}