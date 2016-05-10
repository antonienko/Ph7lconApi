<?php
namespace antonienko\Ph7lconApi;

use antonienko\Ph7lconApi\DI\DIInterface;
use antonienko\Ph7lconApi\ErrorHandler\ErrorHandlerInterface;
use Phalcon\Mvc\Micro;

class ApiApp extends Micro
{
    public function __construct(DIInterface $di, ErrorHandlerInterface $errorHandler)
    {
        parent::__construct($di);
        $this->error(function (\Exception $exception) use ($errorHandler) {
            return $errorHandler->handle($exception);
        });
    }
}