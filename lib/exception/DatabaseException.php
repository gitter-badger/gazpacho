<?php
namespace Gazpacho;

use \Gazpacho\Logger;

class DatabaseException extends \Exception
{
    const UNKNOWN_FETCH_MODE_ERROR = 0;
    const QUERY_ERROR = 1;

    private $_messages = [
        'El método de extracción es desconocido…',
        'Error en la ejecucución de la consulta…'
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