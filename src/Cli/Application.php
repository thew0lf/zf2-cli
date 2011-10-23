<?php

namespace Cli;

use ArrayObject,
    Zend\Mvc\AppContext,
    Zend\Di\Exception\ClassNotFoundException,
    Zend\Di\Locator,
    Zend\Tool\Framework\Client\Console\ResponseDecorator\Blockize;

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
            $arguments = $opts->getRemainingArgs();
        } catch (\Zend\Console\Exception\RuntimeException $e) {
            $response = $this->getHelp();
            goto end;
        }
        
        if (count($arguments) == 0) {
            $response = $this->getHelp();
            goto end;
        }
        
        $controllerName = array_shift($arguments);
        
        if (count($options) == 0) {
            $response = $this->getHelp();
            goto end;
        }

        $actionName = $options[0];

        $actionName = \Zend\Mvc\Controller\ActionController::getMethodFromAction($actionName);

        $locator = $this->getLocator();

        try {
            $controller = $locator->get($controllerName);
        } catch (ClassNotFoundException $e) {
            $response = $this->getHelp();
            goto end;
        }

        if ($controller instanceof LocatorAware) {
            $controller->setLocator($locator);
        }

        $response = null;

        if (method_exists($controller, $actionName)) {
            $response = $controller->$actionName();
        } else {
            goto end;
        }
        
        end:
        echo $response . PHP_EOL;
    }
    
    protected function getHelp()
    {
        $help = <<<HLP
To run this CLI application, pass the name of the controller
you want to invoke as the first argument and the name of the action
as the second argument.
HLP;
        
        $help .= PHP_EOL . $this->getOpts()->getUsageMessage();
        
        $decorator = new Blockize;
        
        $help = $decorator->decorate($help, 78);
        
        return $help;
    }
}
