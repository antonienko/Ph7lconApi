<?php
namespace antonienko\Ph7lconApi\Response;

use Phalcon\Http\Response;
use Phalcon\Http\ResponseInterface;

final class JsonResponse extends Response implements ResponseInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function ok($data)
    {
        return self::okInstance($data, HttpCodes::ok());
    }

    public static function created($data)
    {
        return self::okInstance($data, HttpCodes::created());
    }
    public static function accepted($data)
    {
        return self::okInstance($data, HttpCodes::accepted());
    }

    public static function error($data, HttpCode $httpCode)
    {
        return self::errorInstance($data, $httpCode);
    }

    private static function instantiate(array $content, int $statusCode, string $statusMessage) : JsonResponse
    {
        return (new self)
            ->setContentType('application/json')
            ->setJsonContent($content)
            ->setStatusCode($statusCode, $statusMessage);
    }

    private static function okInstance(array $data, HttpCode $httpCode) : JsonResponse
    {
        return self::instantiate(self::getOkResult($data), $httpCode->getStatusCode(), $httpCode->getStatusMessage());
    }

    private static function errorInstance(array $data, HttpCode $httpCode) : JsonResponse
    {
        return self::instantiate(self::getKoResult($data), $httpCode->getStatusCode(), $httpCode->getStatusMessage());
    }

    private static function getOkResult($data) : array
    {
        $result = [
            'status' => 'OK',
            'data'   => $data
        ];
        return $result;
    }

    private static function getKoResult($data) : array
    {
        $result = [
            'status' => 'KO',
            'errors'   => $data
        ];
        return $result;
    }
}