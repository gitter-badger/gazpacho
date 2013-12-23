<?php
namespace Gazpacho;

use \Gazpacho\Logger;

final class Request
{
    private $_postParameters;
    public function postParameters()
    {
        return $this->_postParameters;
    }
    public function addPostParameter($key, $value)
    {
        $this->$_postParameters[$key] = $value;
    }

    private $_getParameters;
    public function getParameters()
    {
        return $this->_getParameters;
    }
    public function addGetParameter($key, $value)
    {
        $this->$_getParameters[$key] = $value;
    }

    public function __construct()
    {
        $this->_postParameters = &$_POST;
        $this->_getParameters = &$_GET;
    }

    public function parameter($parameter)
    {
        if (isset($this->_postParameters[$parameter])) {
            return $this->_postParameters[$parameter];
        }
        else if (isset($this->_getParameters[$parameter])) {
            return $this->_getParameters[$parameter];
        }
        else {
            Logger::write('Parameter \'' . $parameter . '\' not found in request…');
        }
    }
}