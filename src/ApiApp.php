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
            return $notFoundHandler->handle($this->request->getURI());
        });

        $this->mountResources();
    }

    private function mountResources()
    {
        /** @var Yaml $resources_configuration */
        $resources_configuration = $this->di->get('resources');

        $versions = $resources_configuration->get('versions');
        foreach ($versions as $version => $version_config) {
            $namespace = $version_config->get('namespace');
            $resources = $version_config->get('resources');
            foreach ($resources as $resource_name => $resource) {
                $collection = new Collection();
                $collection->setPrefix(
                    sprintf(
                        '/%s/%s',
                        strtolower($version),
                        strtolower($resource_name)
                    )
                );
                $collection->setHandler(
                    sprintf(
                        '%s\\%sController',
                        $namespace,
                        $resource_name
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