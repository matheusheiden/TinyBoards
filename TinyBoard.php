<?php
namespace TinyBoard;


use TinyBoard\Controllers\Controller;
use TinyBoard\Objects\Log;
use TinyBoard\Objects\TBException;

include('./Autoloader.php');

	class TinyBoard{

		/**
		 * @var Objects\HttpRequest
		 */
		private static $_request;

		/**
		 * @var Objects\HttpResponse
		 */
		private static $_response;

		//TinyBoard Starter
		public static function app(){
			session_start();
            self::$_request = new Objects\HttpRequest();
			self::$_response = new Objects\HttpResponse();
			if (self::isInstalled()){
				self::getResponse()->redirect(self::getConfig('config/url')."installer.php");
			}

		}

		public static function controllerStarter()
		{
			$_https = self::getConfig('https/enabled');
			$_currentUrl = self::getRequest()->getRequestUrl($_https);
			$_uri = self::getRequest()->getUri();
			$_path = "";
			$_url = $_https ? self::getConfig('config/safe_url') : self::getConfig('config/url');
			if ( self::getConfig('url_rewrite/enabled') and strpos($_uri, 'index.php') === false ) {
				$_path = substr($_currentUrl, strlen($_url), strlen($_currentUrl) );
			}
			else {
				$_currentUrl = rtrim($_currentUrl, "\/");
				$_url = rtrim($_url, "/");
				$_url = $_url."/index.php";
				$_path = substr($_currentUrl, strlen($_url), strlen($_currentUrl) );
			}
			if ($_path != false) {
				$pathToLoad = explode("/", $_path);
				$pathToLoad = array_values(array_filter($pathToLoad));
				$class = "TinyBoard\\Controllers\\".ucfirst($pathToLoad[0])."Controller";
				try {
					$_controller = new $class();
					if ( isset($pathToLoad[1]) ) {
						$method = $pathToLoad[1]."Action";
						if (method_exists($_controller, $method)){
							$_controller->$method();
						}
						else {
							self::getResponse()->set404();
						}
					}
					else {
						if (method_exists($_controller, "indexAction")){
							$_controller->indexAction();
						}
						else {
							self::getResponse()->set404();
						}
					}
				}
				catch (\Exception $e){
					self::log($e);
					// controller doesn't exist set 404
					self::getResponse()->set404();
				}
			}
			else {
				$_controller = new Controllers\IndexController();
				$_controller->indexAction();
			}
		}

		public static function setHeader($value)
		{
			self::getResponse()->setHeader($value);
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

		/**
		 * @param $block
		 * @return \TinyBoard\Objects\Renderer
		 */
		public static function getBlock($block, $isChild = false){
			return new $block($isChild);
		}

		/**
		 * @param null $path
		 * @param null $get
		 * @param bool|false $isSafe
		 * @return string
		 */
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

		/**
		 * @return Objects\HttpRequest
		 */
		public static function getRequest()
		{
			return self::$_request;
		}

		/**
		 * @return Objects\HttpResponse
		 */
		public static function getResponse() {
			return self::$_response;
		}

		/**
		 * @param $content
		 * @param int $flag
		 * @param string $filename
		 * @param bool|false $skipCheck
		 */
		public static function log($content, $flag=Log::DEBUG_FLAG, $filename = "system.log", $skipCheck = false){
			new Log($filename, $content, $flag, $skipCheck);
		}

		/**
		 * Verifies if TinyBoard db is created
		 * @return bool
		 */
		public static function isInstalled() {
			return file_exists("etc/local.xml");
		}

	}
