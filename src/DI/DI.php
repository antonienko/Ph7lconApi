<?php
namespace antonienko\Ph7lconApi\DI;

use antonienko\Ph7lconApi\Request\ApiRequest;
use antonienko\Ph7lconApi\Response\ErrorHandler;
use Phalcon\{
    Config, Config\Adapter\Yaml, Db\Adapter\Pdo\Mysql, Di as PhalconDi, Mvc\Router
};

class DI extends PhalconDi implements DIInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->setShared('request', function () {
            return new ApiRequest();
        });

        $this->setShared('router', function () {
            return new Router;
        });
    }


    public function setResourcesConfig(string $resourcesConfigFile)
    {
        $this->setShared('resources', function () use ($resourcesConfigFile) {
            return new Yaml($resourcesConfigFile);
        });
    }
    
    public function setErrorHandler(array $errorCodes)
    {
        $this->setShared('errorHandler', function () use ($errorCodes) {
            return new ErrorHandler($errorCodes);
        });
    }


    public function setDatabaseConnection(string $databaseConfigFile)
    {
        $this->setShared('db', function () use ($databaseConfigFile) {
            $config = new Yaml($databaseConfigFile);
            return new Mysql([
                'host' => $config->host,
                'username' => $config->username,
                'password' => $config->password,
                'dbname' => $config->dbname,
            ]);
        });
    }
}