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

    public static function error(string $errorMessage, int $errorCode, int $developerErrorCode = null, string $developerErrorMessage = null)
    {
        $result = [
            'status' => 'KO',
            'errorMessage' => $errorMessage,
            'developerErrorCode' => $developerErrorCode,
            'developerErrorMessage' => $developerErrorMessage,
        ];
        return self::instantiate($result, $errorCode, 'KO');
    }

    public static function ok($data)
    {
        $result = [
            'status' => 'OK',
            'data' => $data
        ];
        return self::instantiate($result, 200, 'OK');
    }

    private static function instantiate(array $content, int $statusCode, string $statusMessage) : JsonResponse
    {
        return (new self)
            ->setContentType('application/json')
            ->setJsonContent($content)
            ->setStatusCode($statusCode, $statusMessage);
    }
}