<?php
namespace Gazpacho;

use \Gazpacho\Logger;

class ViewException extends \Exception
{
    const TEMPLATE_NOT_FOUND_ERROR = 0;

    private $_messages = [
        'Vista "%s" no encontrada…'
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