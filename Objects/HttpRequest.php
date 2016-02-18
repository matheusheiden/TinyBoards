<?php
/**
 * Created by PhpStorm.
 * User: Matheus
 * Date: 12/5/2015
 * Time: 11:56 AM
 */

namespace TinyBoard\Objects;


/**
 * Class HttpRequest
 * @package TinyBoard\Objects
 */
class HttpRequest
{

    /**
     * This attribute clones the array $_FILES
     * @var array
     */
    private $_files;

    /**
     * this attribute clones $_POST
     * @var array
     */
    private $_post;

    /**
     * this attribute clones $_GET
     * @var array
     */
    private $_get;

    /**
     * clones server
     * @var array
     */
    private $_server;
    /**
     * Holds current action
     * @var \string
     */
    private $_currentAction;
    /**
     * current controller
     * @var \string
     */
    private $_currentController;

    /**
     * HttpRequest constructor.
     */
    public function __construct()
    {
        $this->_files = $_FILES;
        $this->_get = $_GET;
        $this->_post = $_POST;
        $this->_server = $_SERVER;
    }

    /**
     * @return array
     */
    public function getFiles() : array
    {
        return $this->_files;
    }

    /**
     * @return array
     */
    public function getServer() : array
    {
        return $this->_server;
    }

    /**
     * @return array
     */
    public function getParams():array
    {
        return array_merge($this->getGet(), $this->getPost());
    }

    /**
     * @return array
     */
    public function getGet() : array
    {
        return $this->_get;
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->_post;
    }

    public function getUri() : \string {
        return $this->_server['REQUEST_URI'];
    }

    public function getRequestUrl($isSecure = false) {
        return !$isSecure ? "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" : "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function setCurrentController($controller){
        $this->_currentController = $controller;
    }

    public function setCurrentAction($action){
        $this->_currentAction = $action;
    }

    public function getCurrentAction (){
        return $this->_currentAction;
    }
}