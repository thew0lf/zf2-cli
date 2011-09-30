<?php

namespace Cli\Controller;

use Zend\Mvc\Controller\ActionController;

class Cli extends ActionController
{
    public function indexAction()
    {
        return array('content' => 'IT WORKS!');
    }
    
    public function listAllAction()
    {
        return 'LIST ALL THE THINGS!';
    }
    
    public function matchRouteAction()
    {
        return 'MATCH ALL THE THINGS!';
    }
}
