<?php
namespace Gazpacho;

use \Gazpacho\Logger;

class RouteException extends \Exception
{
    const METHOD_NOT_FOUND_ERROR = 0;
    const CONTROLLER_NOT_FOUND_ERROR = 1;

    private $_messages = [
        'Method "%s" not found…',
        'Controller "%s" not found…'
    ];

    private $_element;

    public function __construct($code, $element)
    {
        $this->message = $this->_messages[$code];
        $this->_element = $element;
    }

    public function message()
    {
        return str_replace('%s', $this->_element, $this->message);
    }
}