<?php
namespace TinyBoard\Controllers;

use TinyBoard\TinyBoard;

class Controller
{
    public function __construct()
    {
        $this->preDispatch();
    }

    protected function preDispatch()
    {

    }

    /**
     * @param $layout
     * @return \TinyBoard\Objects\Renderer
     */
    public function loadLayout($layout)
    {
        return TinyBoard::getBlock('TinyBoard\\Blocks\\' . $layout);
    }

    /**
     * @return \TinyBoard\Objects\HttpRequest
     */
    protected function getRequest() {
        return TinyBoard::getRequest();
    }

    /**
     * @return \TinyBoard\Objects\HttpResponse
     */
    protected function getResponse() {
        return TinyBoard::getResponse();
    }
}
