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

            $this->_variables['appSection'] = ucfirst($templateName);
            $this->_variables['appTitle'] = Application::config('applicationName');
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
        // Includes the default header if there is no custom view on the app folder
        if (file_exists('../app/views/header.html')) {
            $templateRendered = file_get_contents('../app/views/header.html');
        }
        else {
            $templateRendered = file_get_contents('../lib/views/header.html');
        }

        // Includes the current view template and replace the variables
        $templateRendered .= file_get_contents($this->_template);

        foreach ($this->_variables as $key => $value) {
            $templateRendered = preg_replace('/{{' . $key . '}}/', $value, $templateRendered);
        }

        // Includes the default footer if there is no custom view on the app folder
        if (file_exists('../app/views/footer.html')) {
            $templateRendered .= file_get_contents('../app/views/footer.html');
        }
        else {
            $templateRendered .= file_get_contents('../lib/views/footer.html');
        }

        return $templateRendered;
    }
}