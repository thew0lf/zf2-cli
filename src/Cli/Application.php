<?php

namespace Cli;

use ArrayObject,
    Zend\Mvc\AppContext,
    Zend\Mvc\Router,
    Zend\Di\Exception\ClassNotFoundException,
    Zend\Di\Locator,
    Zend\EventManager\EventCollection,
    Zend\EventManager\EventManager,
    Zend\EventManager\Event,
    Zend\Http\Header\Cookie,
    Zend\Http\Request as HttpRequest,
    Zend\Http\Response as HttpResponse,
    Zend\Stdlib\Dispatchable,
    Zend\Stdlib\IsAssocArray,
    Zend\Stdlib\Parameters,
    Zend\Stdlib\RequestDescription as Request,
    Zend\Stdlib\ResponseDescription as Response;

/**
 * Main application class for invoking applications
 *
 * Expects the user will provide a Service Locator or Dependency Injector, as 
 * well as a configured router. Once done, calling run() will invoke the 
 * application, first routing, then dispatching the discovered controller. A
 * response will then be returned, which may then be sent to the caller.
 */
class Application /* implements AppContext */
{
    protected $locator;
    
    protected $opts;

    protected $router;

    /**
     * Set a service locator/DI object
     *
     * @param  Locator $locator 
     * @return AppContext
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
        return $this;
    }

    public function setOpts($opts)
    {
        $this->opts = $opts;
        return $this;
    }
    
    /**
     * Get the locator object
     * 
     * @return null|Locator
     */
    public function getLocator()
    {
        return $this->locator;
    }
    
    public function getOpts()
    {
        return $this->opts;
    }
    
    public function run()
    {
        try {
            $opts = $this->getOpts();
            
            $options = $opts->getOptions();
            
            $listAll = $opts->getOption('a');
            $match = $opts->getOption('m');
            
            $actionName = null;
            $controller = null;
            
            if($listAll === true) {
                $actionName = 'list-all';
            } else {
                $actionName = 'match-route';
            }
        
            $actionName = \Zend\Mvc\Controller\ActionController::getMethodFromAction($actionName);
            
            $locator = $this->getLocator();
            
            $controller = $locator->get('cli');
            
            if ($controller instanceof LocatorAware) {
                $controller->setLocator($locator);
            }
            
            $response = null;
            
            if (method_exists($controller, $actionName)) {
                $response = $controller->$actionName();
            } else {
                $response = $opts->getUsageMessage();
            }
            
            echo $response . PHP_EOL;
            
        } catch (\Zend\Console\Exception\RuntimeException $e) {
            echo $e->getUsageMessage();
            exit;
        }
        
//        return $response;
    }
}
