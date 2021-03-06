<?php

/**
 * Slim Magic Service Container
 *
 * @link      https://github.com/atlantic8-web/slim-magic
 * @copyright Copyright (c) 2011-2016 Christof Coetzee
 * @license   https://github.com/atlantic8-web/slim-magic/blob/master/LICENSE (MIT License)
 */

namespace SlimMagic;

class ServiceContainer
{

    protected $slim;
    protected $config;

    final public function __construct(\Slim\App $slim, $config)
    {
        $this->slim = $slim;
        $this->config = $config;
        $this->configNormalize();
    }

    final public function getConfig()
    {
        return $this->config;
    }

    final public function getSlimContainer()
    {
        return $this->slim->getContainer();
    }

    final public function getSlim()
    {
        return $this->slim;
    }

    final private function configNormalize()
    {
        $defaultSpec = [
            'methods' => ['GET'],
            'classmap' => 'routeNotDefined',
            'middleware' => [],
            'arguments' => [],
            'name' => ''
        ];
        $defaultAll = [
            'middleware' => [],
            'middleware_order' => 1,
            'service' => []
        ];

        $this->config['all'] = isset($this->config['all']) ? array_merge($defaultAll, $this->config['all']) : $defaultAll;
        $confAll = $this->config['all'];

        foreach ($this->config['routes'] as $route => $spec) {
            $spec['methods'] = empty($spec['methods']) ? ['GET'] : array_map('strtoupper', (array) $spec['methods']);
            $spec = array_merge($defaultSpec, $spec);

            $this->config['routes'][$route] = $spec;
        }
    }

}
