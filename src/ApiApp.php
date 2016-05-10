<?php
namespace antonienko\Ph7lconApi;

use antonienko\Ph7lconApi\DI\DIInterface;
use antonienko\Ph7lconApi\EventHandler\EventHandlerInterface;
use Phalcon\Mvc\Micro;

class ApiApp extends Micro
{
    public function __construct(DIInterface $di, EventHandlerInterface $errorHandler, EventHandlerInterface $notFoundHandler)
    {
        parent::__construct($di);
        $this->error(function (\Exception $exception) use ($errorHandler) {
            return $errorHandler->handle($exception);
        });
        $this->notFound(function () use ($notFoundHandler) {
            return $notFoundHandler->handle();
        });
    }
}