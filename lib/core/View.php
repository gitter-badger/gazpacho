<?php
namespace Gazpacho;

use \Gazpacho\Logger;
use \Gazpacho\ViewException;

final class View
{
    private $_template;
    private $_variables;
    
    public function __construct($templateName, $variables = [])
    {
        $file = '../app/views/' . $templateName . '.html';
        if (file_exists($file)) {
            $this->_template = $file;
            $this->_variables = $variables;
        }
        else {
            throw new ViewException(ViewException::TEMPLATE_NOT_FOUND_ERROR, $templateName);
        }
    }

    public function render($asJson = FALSE)
    {
        if ($asJson) {
            header('Content-type:application/json;');
            return json_encode($this->_variables, TRUE);
        }
        else {
            header('Content-type:text/html; charset=UTF-8');
            return $this->parse();
        }
    }

    private function parse()
    {
        $templateRendered = file_get_contents($this->_template);

        foreach ($this->_variables as $key => $value) {
            $templateRendered = preg_replace('/{{' . $key . '}}/', $value, $templateRendered);
        }

        return $templateRendered;
    }
}