<?php
namespace antonienko\Ph7lconApi\DI;

use Phalcon\Config;
use Phalcon\DiInterface as PhalconDiInterface;

interface DIInterface extends PhalconDiInterface
{
    public function setResourcesConfig(string $resourcesConfigFile);

    public function setDatabaseConnection(string $databaseConfigFile);
}