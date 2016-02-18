<?php
namespace TinyBoard\Objects;

use TinyBoard\Objects\Utils\XmlLoader as XmlLoader;

class Renderer {

	const DOCTYPE_STRING = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
	const DEFAULT_CSS_PATH = "css/";
	const DEFAULT_JS_PATH = "js/";
	const DEFAULT_TEMPLATE_PATH = 'Renderers/';
	public $_block = 'default';
	protected $_layout = '';
	private $header = array();
	private $_config = "etc/layout.xml";
	private $_isChild = false;

	private $xmlLoader;

	public function __construct($isChild){
		$this->_isChild = $isChild;
		$this->_config = "etc/layout.xml";
		$this->xmlLoader = new XmlLoader();
		$this->setConfig();
	}

	public function setConfig(){
		try {
			$config = $this->xmlLoader->loadXml($this->_config)->parseXml();
			//Parse information from default block if current renderer isn`t a child block
			if (!$this->_isChild) {
				foreach ($config['default'] as $key => $value) {
					$this->$key((array)$value);
				}
			}
			//parse information from the block that is being loaded now
//			if (isset($config[$this->_block])){
				foreach ($config[$this->_block] as $key => $value) {
					$this->$key((array)$value);
				}
//			}
			return $this;
		} catch (\Exception $e) {
			var_dump($e);
		}
        return $this;
	}
	//TODO: Implement actions for failure when loading js and css

	public function addJs($js)
	{
		foreach ($js as $script) {
			if (filter_var($script, FILTER_VALIDATE_URL)) {
				array_push($this->header, "<script src='" . $script . "'></script>");

			} else {
				array_push($this->header, "<script src='" . self::DEFAULT_JS_PATH .\TinyBoard\TinyBoard::getUrl().$script . "'></script>");
			}
		}
		return $this;

	}

	public function addCss($css){
		foreach ($css as $style) {
			if(filter_var($style, FILTER_VALIDATE_URL)){
				array_push($this->header, "<link rel='stylesheet' type='text/css' href='" . $style . "'>");
			}
			else{
				array_push($this->header, "<link rel='stylesheet' type='text/css' href='".\TinyBoard\TinyBoard::getUrl().self::DEFAULT_CSS_PATH.$style."'>");
			}
		}
			return $this;
	}

	public function setLayout($phtml){
		$phtml = self::DEFAULT_TEMPLATE_PATH.$phtml[0];
		if (!file_exists($phtml))
            throw new \Exception("Template: $phtml wasn't found");
		$this->_layout = $phtml;
	}

	public function renderLayout(){
		echo self::DOCTYPE_STRING."\n";
		echo "<html>\n";
		$this->renderHeader();
		echo "<body>\n";
		include($this->_layout);
		echo "</body>\n";
		echo "\n</html>";
	}

	public function renderHeader()
	{
		echo "<head>\n" . implode($this->header, "\n") . "\n" . "</head>\n";
	}

	public function renderChild() {
		include($this->_layout);
	}
}
