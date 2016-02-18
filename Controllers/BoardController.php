<?php
namespace TinyBoard\Controllers;
use TinyBoard\TinyBoard;

include_once('Controller.php');

class BoardController extends Controller
{
    public function viewAction()
    {
        /**
         * @var \TinyBoard\Blocks\Board
         */
        var_dump($this->getRequest()->getParams());
        $layout = $this->loadLayout('Board');
        $layout->setBoard(TinyBoard::getModel('\TinyBoard\Objects\Board')->load(1));
        $layout->renderLayout();

    }

    public function threadAction() {

    }
}
