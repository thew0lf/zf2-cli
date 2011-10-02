<?php
return array(
    'cli_bootstrap_class' => 'Cli\Bootstrap',
    'console_options' => array(
        'list-all|a' => 'List all defined routes',
        'match-route|m=s' => 'Match a route'
    ),
    'di' => array( 'instance' => array(
        'alias' => array(
            'cli' => 'Cli\Controller\Cli'
        )
    )),
);
