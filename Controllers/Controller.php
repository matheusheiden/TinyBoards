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

    public function loadLayout($layout)
    {
        return TinyBoard::getBlock('TinyBoard\\Blocks\\' . $layout);
    }

    protected function getRequest()
    {
        return TinyBoard::getRequest();
    }
}
