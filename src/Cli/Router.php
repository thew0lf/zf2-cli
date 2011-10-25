<?php

namespace Cli;

class Router
{

    protected $routes = array();
    
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }
    
    public function match(array $arguments)
    {
        $possibleMatches = array();
        
        $numberOfArguments = count($arguments);
        
        foreach ($this->routes as $route) {
            if (count($route) == $numberOfArguments) {
                $possibleMatches[] = $route;
            }
        }
        
        if (count($possibleMatches) == 0) {
            return null;
        }
        
        foreach ($possibleMatches as $possibleMatch) {
            if ($possibleMatch[0] == $arguments[0]
                    and $possibleMatch[1] == $arguments[1]
                    and $possibleMatch[2] == $arguments[2]) {
                return $possibleMatch;
            }
        }
    }
    
}