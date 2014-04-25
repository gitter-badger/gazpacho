<?php
/**
 *  Application configuration array.
 *
 *  This is the main application configuration array.
 *  You must put here all the app configuration constants and retrieve them using:
 *
 *  `Application::config('__config_key__');`
 *
 *  The default configurations are:
 *
 *  - environment: Use to specify which environment the application is. This is
 *  mainly used by `Logger`and `Database` classes. Default values are `debug`,
 *  `test` and `production`.
 *  - applicationName: Specifies the app namespace and the title to appear on
 *  the web pages. It is used by the `script/generate` command.
 *  - version: The application current version.
 *
 * @see Gazpacho\Logger
 * @see Gazpacho\Database
 */
return [
    'environment' => 'debug',
    'applicationName' => 'Dummy',
    'version' => '0.0.1'
];