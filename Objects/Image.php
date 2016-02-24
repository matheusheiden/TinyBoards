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

	private function encodeImage($image) : \string
	{
		return base64_encode($image);
	}
	public function getResolution(){
		return getimagesizefromstring(base64_decode($this->getData('image')));
	}

	/**
	 * returns image size in bytes
	 * @return int
	 */
	public function getSize() {
		return $this->formatBytes(strlen(base64_decode($this->getData('image'))));
	}
	public function formatBytes($size, $precision = 0) {
		$base = log($size, 1024);
		$suffixes = array('', 'KB', 'MB', 'GB', 'TB');

		return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}


}