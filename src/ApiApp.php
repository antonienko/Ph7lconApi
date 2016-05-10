<?php
namespace antonienko\Ph7lconApi;

use antonienko\Ph7lconApi\DI\DIInterface;
use antonienko\Ph7lconApi\EventHandler\EventHandlerInterface;
use Phalcon\Config;
use Phalcon\Config\Adapter\Yaml;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

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

        $this->mountResources();
    }

    private function mountResources()
    {


        /** @var Yaml $resources_configuration */
        $resources_configuration = $this->di->get('resources');
        $namespace = $resources_configuration->get('namespace');
        foreach ($resources_configuration->get('versions') as $version => $resources) {
            foreach ($resources as $resourceName => $resource) {
                $collection = new Collection();
                $collection->setPrefix(
                    sprintf(
                        '/%s/%s',
                        strtolower($version),
                        strtolower($resourceName)
                    )
                );
                $collection->setHandler(
                    sprintf(
                        '\\%s\\%s\\Controllers\\%sController',
                        $namespace,
                        $version,
                        $resourceName
                    )
                );
                $collection->setLazy(true);
                foreach ($resource as $httpMethod => $actions) {
                    foreach ($actions as $actionName => $action) {
                        $httpMethod = strtolower($httpMethod);
                        $collection->$httpMethod($action, $actionName);
                    }
                }
                $this->mount($collection);
            }
        }
    }
}