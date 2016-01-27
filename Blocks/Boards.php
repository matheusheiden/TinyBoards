<?php
namespace TinyBoard\Blocks;

use TinyBoard\Objects\Renderer as Renderer;

class Boards extends Renderer{

	public $_block = 'boards';
	
	public function __construct($isChild){
		parent::__construct($isChild);
	}

	public function getBoards(){
		return \TinyBoard\TinyBoard::getModel('\TinyBoard\Objects\Board')->getCollection();

	}
}