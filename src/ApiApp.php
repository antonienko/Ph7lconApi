<?php
namespace antonienko\Ph7lconApi;

use antonienko\Ph7lconApi\DI\DIInterface;
use Phalcon\Mvc\Micro;

class ApiApp extends Micro
{
    public function __construct(DIInterface $di)
    {
        
        parent::__construct($di);
    }
}