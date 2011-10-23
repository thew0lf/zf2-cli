<?php

namespace Cli;

use Zend\Config\Config,
    Zend\Loader\AutoloaderFactory;

class Module
{
    public function init()
    {
        $this->initAutoloader();
    }

    protected function initAutoloader()
    {
        AutoloaderFactory::factory(array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    public static function getConfig()
    {
        return new Config(include __DIR__ . '/configs/config.php');
    }
}
