<?php
namespace TinyBoard\Blocks;

use TinyBoard\Objects\Renderer as Renderer;

class Blocks_Post extends Renderer {
	/**
	 * Name of current block
	 * @var string
	 */
	public $_block = 'post';
	/**
	 * @var \TinyBoard\Objects\Post
	 */
	private $_post;

	public function __construct($post=null) {
		parent::__construct();
		if ($post != null)
			$this->setPost($post);
	}

	public function getReplies() : array {
		return $this->_post->getPostsFromThread();
	}

	public function getImage()
	{
		return '<img src="data:image/' . $this->_post->getImage()->getData('filetype') . ';base64,' . (string)$this->_post->getImage() . '" />';
	}

	public function getPost(){
		return $this->_post;
	}

	public function setPost($post)
	{
		$this->_post = $post;
		return $this;
	}
}