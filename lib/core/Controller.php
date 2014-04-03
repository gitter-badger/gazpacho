<?php
namespace Gazpacho;

use \Gazpacho\Logger;

/**
 * The base controller class.
 * All app controllers inherits from this class as this is an
 * abscract class.
 *
 * It only specifies basics properties like the view.
 * 
 * @property string $_view The view's name without extension.
 */
abstract class Controller
{
    private $_view;

    public function __construct() { }

    /**
     * Sets the controller's view
     * 
     * @param string $view View's name
     */
    public function setView($view)
    {
        $this->_view = $view;
    }

    /**
     * Returns the view's name
     *
     * @return string The view's name
     */
    public function view()
    {
        return $this->_view;
    }
}