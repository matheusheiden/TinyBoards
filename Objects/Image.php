<?php
namespace TinyBoard\Objects;

class Image extends DbEntity {

	protected $_table = 'images';

	public function __construct($data = null){
		parent::__construct();
		if ($data != null){
			$this->_attributes = $data;
		}
	}

	public function getImagesFromPost(Post $post): array
	{
		return $this->getCollection(null, array('post_id'=>$post->getData('id')));
	}

	public function __toString(){
		return (string)$this->getData('image');
	}

	public function setImage($filename, $image)
	{
		$this->setData('name', $filename);
	}

	private function encodeImage($image) : string
	{
		return base64_encode($image);
	}
}