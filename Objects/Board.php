<?php
namespace TinyBoard\Objects;


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
		}
	}

	public function getBoards(){
		return $this->getCollection();
	}
}