<?php
namespace TinyBoard\Blocks;


use TinyBoard\Objects\Renderer;

class Board extends Renderer {
    /**
     * @var string
     */
    public $_block = 'board';
    /**
     * @var \TinyBoard\Objects\Board
     */
    private  $_board;

    /**
     * Sets current board
     * @param \TinyBoard\Objects\Board $board
     */
    public function setBoard($board) {
        $this->_board = $board;

    }

    public function getName() {
        return $this->_board->getData('name');
    }


}