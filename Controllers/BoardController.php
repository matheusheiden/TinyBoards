<?php
namespace TinyBoard\Controllers;
include_once('Controller.php');

class BoardController extends Controller
{
    public function indexAction()
    {
        $layout = $this->loadLayout('Board');
        $layout->renderLayout();

    }

    public function threadAction() {

    }
}
