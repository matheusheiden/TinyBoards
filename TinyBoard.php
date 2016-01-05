<?php
namespace TinyBoard;


include("Objects/Renderer.php");
include("Objects/DbEntity.php");
include_once("Objects/Board.php");
include_once("Objects/Image.php");
include_once("Objects/Post.php");
include_once("Objects/Config.php");
include_once("Blocks/Boards.php");
include_once("Blocks/Index.php");
include_once("Blocks/Post.php");
include_once("Blocks/Board.php");
include_once("Controllers/BoardController.php");
include_once("Controllers/IndexController.php");
include_once("Objects/HttpRequest.php");
include_once("Objects/TBException.php");
include_once("Objects/Log.php");

	class TinyBoard{

		/**
		 * @var Objects\HttpRequest
		 */
		private static $_request;


		//TinyBoard Starter
		public static function app(){
			session_start();
			self::$_request = new Objects\HttpRequest();
		}

		public static function controllerStarter()
		{
			$path = explode("?", $_SERVER['REQUEST_URI'])[0];
			$path = explode("/", $path);
			if (strpos($_SERVER['REQUEST_URI'], 'index.php')){
				if (isset($path[3])) {
					if (class_exists('TinyBoard\Controllers\\' . $path[3] . 'Controller')) {
						$class = 'TinyBoard\Controllers\\' . $path[3] . 'Controller';
						$controller = new $class();
						if (isset($path[4])) {
							$func = $path[4] . 'Action';
							if (method_exists($controller, $func)) {
								$controller->$func();
							} else {
								self::setHeader($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
							}
						} else {
							if (method_exists($controller, 'indexAction')) {
								$controller->indexAction();
							} else {
								self::setHeader($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
							}
						}
					} else {
						self::setHeader($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
					}
				} else {
					$controller = new Controllers\IndexController();
					$controller->indexAction();

				}
			}
		}

		public static function setHeader($value)
		{
			header($value);
		}

		public static function getParams(){
			return self::$_request->getParams();
		}

		public static function setSession($key, $data) {
			$_SESSION[$key] = $data;
		}

		public static function getSession($key){
			return $_SESSION[$key];
		}

		public static function getBlock($block){
			return new $block;
		}

		public static function getUrl($path = null, $get = null, $isSafe = false)
		{
			$url = !$isSafe ? self::getConfig('config/url') : self::getConfig('config/safe_url');
			if (!is_null($path))
				$url .= $path;
			if (!is_null($get))
				$url .= "?" . http_build_query($get);
			return $url;
		}

		/**
		 * Only returns the value of the config
		 */
		public static function getConfig($key)
		{
			return self::getModel('TinyBoard\Objects\Config')->load($key, 'key')->getData('value');
		}

		public static function getModel($model)
		{
			return new $model();
		}

		public static function throwException($msg)
		{
			throw new Objects\TBException($msg);
		}

		public static function getRequest()
		{
			return self::$_request;
		}

	}
