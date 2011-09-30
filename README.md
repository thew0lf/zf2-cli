CLI Module
=============

A CLI Module for ZF2.

This stuff is really hacky and a work in progress.

The main entry point is bin/cli.php (like public/index.php)

Set different paths there to the "application.config.php" file of an existing
zf2 project. This is currently set against Evan Coury's zf2-sandbox application.

In src/Cli/Bootstrap.php::setupOptions are set the command line arguments and are
read in src/Cli/Application.php::run