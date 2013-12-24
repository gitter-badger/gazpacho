<?php
namespace Gazpacho;

use \Gazpacho\Logger;

abstract class Controller
{
    private $_view;

    public function __construct() { }

    public function setView($view)
    {
        $this->_view = $view;
    }

    public function view()
    {
        return $this->_view;
    }
}