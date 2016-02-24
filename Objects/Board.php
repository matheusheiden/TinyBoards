<?php
namespace TinyBoard\Objects;


use TinyBoard\TinyBoard;

class Board extends DbEntity{

	/**
	 * Object's data model
	 * @var string
	 */
	protected $_table = 'boards';

	public function __construct($data = null){
		parent::__construct();
		if ($data != null){
			$this->_attributes = $data;
			$this->_isNew = false;
		}
	}

	public function getBoards(){
		return $this->getCollection();
	}

	public function getThreads() {
		/**
		 * @var Post $collection
		 */
		$collection = TinyBoard::getModel('\TinyBoard\Objects\Post');
		$collection = $collection->getCollection(null, array("isOp"=>1,"board_id"=>$this->getData('id')));
		return $collection;
	}
}