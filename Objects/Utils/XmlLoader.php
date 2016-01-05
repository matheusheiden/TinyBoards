<?php
namespace TinyBoard\Objects\Utils;
class XmlLoader {
	/**
	 * loaded xml is kept here
	 * @var string
	 */
	private $_currentXml;

	/**
	 * loads xml
	 * @param $path
	 * @return $this
	 * @throws \Exception
	 */
	public function loadXml($path){
		if (file_exists($path)) {
    		$this->_currentXml = simplexml_load_file($path);
    		if ( is_null($this->_currentXml) ){
				throw new \Exception("Error Loading XML", 1);
    		}
		} 
		else {
		    exit('Failed to open test.xml.');
		}

		return $this;
	}

	/**
	 * Parses xml transforming it to an array
	 * @return array
	 * @throws \Exception
	 */
	public function parseXml(): array
	{
		if ( is_null($this->_currentXml) )
			throw new \Exception("XML not loaded yet", 1);

		return json_decode(json_encode((array)$this->_currentXml), TRUE);
			
	}
}