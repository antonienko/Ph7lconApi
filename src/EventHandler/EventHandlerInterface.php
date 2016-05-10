<?php
namespace antonienko\Ph7lconApi\EventHandler;

use Phalcon\Http\ResponseInterface;

interface EventHandlerInterface
{
    public function handle($eventData = null) : ResponseInterface;
}