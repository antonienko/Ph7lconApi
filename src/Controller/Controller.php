<?php
namespace antonienko\Ph7lconApi\Controller;

use antonienko\Ph7lconApi\Response\JsonResponse;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Controller as PhalconController;

class Controller extends PhalconController
{
    protected function okResult($data) : ResponseInterface
    {
        return JsonResponse::ok($data);
    }

    protected function koResult(string $errorMessage, int $errorCode, int $developerErrorCode, string $developerErrorMessage) : ResponseInterface
    {
        return JsonResponse::error($errorMessage, $errorCode, $developerErrorCode, $developerErrorMessage);
    }
}