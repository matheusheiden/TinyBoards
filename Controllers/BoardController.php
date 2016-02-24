<?php
namespace TinyBoard\Controllers;
use TinyBoard\TinyBoard;

include_once('Controller.php');

class BoardController extends Controller
{
    public function viewAction()
    {
        $id = array_keys($this->getRequest()->getUriAsGet());
        $id = reset($id);
        /**
         * @var \TinyBoard\Blocks\Board $layout
         * @var \TinyBoard\Objects\Board $board
         */
        $board = TinyBoard::getModel('\TinyBoard\Objects\Board');
        if ( $id ){
            $board->load($id,'name');
        }
        //If board exists loads layout and renders it
        if ( !$board->isNew() ) {
            $layout = $this->loadLayout('Board');
            $layout->setBoard($board);
            $layout->renderLayout();
            return;
        }
        /**
         * @TODO CREATE 404 REDIRECT
         */
        $this->getResponse()->redirect(\TinyBoard\TinyBoard::getUrl());


    }

    public function threadAction() {

    }
}
