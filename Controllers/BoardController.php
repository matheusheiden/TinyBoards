<?php
namespace TinyBoard\Controllers;
use TinyBoard\TinyBoard;

include_once('Controller.php');

class BoardController extends Controller
{
    public function indexAction()
    {
        /**
         * @var \TinyBoard\Blocks\Board
         */
        $layout = $this->loadLayout('Board');
        $layout->setBoard(TinyBoard::getModel('\TinyBoard\Objects\Board')->load(1));
        $layout->renderLayout();

    }

    public function threadAction() {

    }
}
