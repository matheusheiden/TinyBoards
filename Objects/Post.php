<?php
namespace TinyBoard\Objects;

use TinyBoard\TinyBoard;

class Post extends DbEntity{

	//overide
	protected $_table = 'posts';

	public function __construct($data = null){
		parent::__construct();
		if ($data != null){
			$this->_attributes = $data;
			$this->_isNew = false;
		}
	}
	/*
	*	TODO: Treat condition when post has more images
	*/
	/**
	 * @return Image
	 */
	public function getImage(){
		$image = TinyBoard::getModel('TinyBoard\Objects\Image')->getImagesFromPost($this);
		return reset($image);
	}

	public function getId(){
		return $this->_attributes['id'];
	}

	public function getDate(){
		return $this->_attributes['date'];
	}
	public function getName(){
		return $this->_attributes['name'];
	}
	public function getContent(){
		return $this->_attributes['content'];
	}
	public function getSubject(){
		return $this->_attributes['subject'];
	}
	public function getPostsFromThread(){
		if ($this->getData('isOp')) {
			return $this->getCollection(null ,array('threadid'=>$this->getData('id')));
		}
		return "";
	}

}
