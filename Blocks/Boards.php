<?php
namespace TinyBoard\Blocks;

use TinyBoard\Objects\Renderer as Renderer;

class Blocks_Boards extends Renderer{

	public $_block = 'boards';
	
	public function __construct(){
		parent::__construct();
	}

	public function getBoards(){
		return TinyBoard::getModel('Board')->getCollection();

	}
}