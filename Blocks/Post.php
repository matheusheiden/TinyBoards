<?php
namespace TinyBoard\Blocks;

use TinyBoard\Objects\Renderer as Renderer;

class Post extends Renderer {
	/**
	 * Name of current block
	 * @var string
	 */
	public $_block = 'post';
	/**
	 * @var \TinyBoard\Objects\Post
	 */
	private $_post;

	public function getReplies() : array {
		return $this->_post->getPostsFromThread();
	}

	public function getImage()
	{
		return '<img src="data:image/' . $this->_post->getImage()->getData('filetype') . ';base64,' . (string)$this->_post->getImage() . '" height="'.$this->getImageAdjustedHeight().'" width="'.$this->getImageAdjustedWidth().'" />';
	}

	public function getPost(){
		return $this->_post;
	}

	public function setPost($post)
	{
		$this->_post = $post;
		return $this;
	}
	public function getImageAdjustedHeight() {
		$resInfo = $this->getPost()->getImage()->getResolution();
		$ratio = $resInfo[0] / $resInfo[1];
		print_r($ratio);
		return $resInfo[0] / $ratio;
	}
	public function getImageAdjustedWidth() {
		$resInfo = $this->getPost()->getImage()->getResolution();
		$ratio = $resInfo[0] / $resInfo[1];
		return $resInfo[1] * $ratio;

	}
}