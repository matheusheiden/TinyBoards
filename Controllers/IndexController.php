<?php
namespace TinyBoard\Controllers;

use TinyBoard\TinyBoard;

include_once("Controller.php");

class IndexController extends Controller
{
    public function indexAction()
    {
        $layout = $this->loadLayout('Index');
        $layout->renderLayout();
    }

    public function postAction()
    {
        var_dump(TinyBoard::getParams());
    }
}
