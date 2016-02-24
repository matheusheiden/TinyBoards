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
        return array_merge($this->getGet(), $this->getPost(), $this->getUriAsGet());
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

    public function getCurrentController(){
        return $this->_currentController;
    }
    public function setCurrentAction($action){
        $this->_currentAction = $action;
    }

    public function getCurrentAction (){
        return $this->_currentAction;
    }
    public function getUriAsGet() {
        $_uri = explode("/", $this->getUri());
        $iterateAt = 0;
        if ( in_array('index',$_uri) && $this->getCurrentAction() == 'index' ){
            $iterateAt = array_search('index',$_uri);
        }
        elseif(!in_array('index',$_uri) && $this->getCurrentAction() == 'index'){
            $iterateAt = array_search($this->getCurrentController(),$_uri);
        }
        else {
            $iterateAt = array_search( $this->getCurrentAction(), $_uri);
        }
        $return = array();
        for ($i = $iterateAt+1; $i <= count($_uri); $i=$i+2){
            $return[$this->trimGet($_uri[$i])] = isset($_uri[$i+1]) ? $this->trimGet($_uri[$i+1]) : null;
        }
        return $return;
    }

    private function trimGet($value) {
        if (strpos($value, "?") ) {
            return trim($value, substr($value, strpos($value, '?')));
        }
        return $value;
    }
}