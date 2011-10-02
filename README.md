CLI Module
=============

A CLI Module for ZF2.

This stuff is really hacky and a work in progress.

The main entry point is bin/cli.php (like public/index.php)

Set different paths there to the "application.config.php" file of an existing
zf2 project. This is currently set against Evan Coury's zf2-sandbox application.

In src/Cli/Bootstrap.php::setupOptions are set the command line arguments and are
read in src/Cli/Application.php::run

For the cli "route" to match, you need to have an action in the Cli controller
corresponding to the long flag which invokes that action. Example:

php bin/cli.php --foo-bar

will try to call the fooBarAction in the Cli controller.

Command line arguments can be configured in config.php by changing the
"console_options" key. Example:

'console_options' => array(
    'foo-bar|f' => 'call the fooBarAction'
),