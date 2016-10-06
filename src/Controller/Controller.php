<?php
namespace antonienko\Ph7lconApi\Controller;

use antonienko\Ph7lconApi\Response\ErrorHandler;
use Phalcon\Mvc\Controller as PhalconController;

class Controller extends PhalconController
{
    /** @var ErrorHandler */
    protected $errorHandler;

    public function onConstruct()
    {
        $this->errorHandler = $this->di->get('errorHandler');
    }
}
