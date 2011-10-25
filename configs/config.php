<?php
return array(
    'cli_bootstrap_class' => 'Cli\Bootstrap',
    'console_options' => array(
        'list-all|a' => 'List all defined routes',
        'match-route|m=s' => 'Match a route'
    ),
    'routes' => array(
        array(
            'cli', // module
            'cli', // controller
            'list-all', //action
            'foo', // 1st param
            'bar' // 2nd param
        ),
        array(
            'cli', // module
            'cli', // controller
            'match-route', //action
            'foo', // 1st param
            'bar' // 2nd param
        ),
    ),
    'di' => array( 'instance' => array(
        'alias' => array(
            'cli' => 'Cli\Controller\Cli'
        )
    )),
);
