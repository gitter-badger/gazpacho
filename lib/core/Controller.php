<?php
namespace Gazpacho;

use \Gazpacho\Logger;

abstract class Controller
{
    public function __construct()
    {
        Logger::write('Controller initialization…');
    }
}