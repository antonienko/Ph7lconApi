<?php
namespace antonienko\Ph7lconApi\ErrorHandler;

use Phalcon\Http\ResponseInterface;

interface ErrorHandlerInterface
{
    public function handle(\Exception $exception) : ResponseInterface;
}