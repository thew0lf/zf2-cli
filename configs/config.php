<?php
return array(
    'cli_bootstrap_class' => 'Cli\Bootstrap',
    'di' => array( 'instance' => array(
        'alias' => array(
            'cli' => 'Cli\Controller\Cli'
        )
    )),
);
