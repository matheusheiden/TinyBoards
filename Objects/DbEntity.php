<?php
namespace TinyBoard\Objects;

use TinyBoard\Objects\Utils\DbConn as DbConn;

include("Utils/DbConn.php");

class DbEntity
{
	/**
	 * Entity`s table
	 * @var string
	 */
	protected $_table = '';
	/**
	 * Entity`s Attributes
	 * @var array
	 */
	protected $_attributes = array();
	/**
     * Database connection
	 * @var DbConn
	 */
	protected $_dbConn;
	/**
	 * Defines if this object is a new object
	 * @var bool
	 */
	private $_isNew = true;
	
	public function __construct(){
		$this->_dbConn = DbConn::getInstance();
		$this->_attributes = $this->getAttributes();
	}

	/**
	 *
	 * @return mixed
	 */
	public function getAttributes(): array
	{
		$attr = array();
        $data = $this->_dbConn->getColumns($this->_table);
		foreach ($data as $value) {
			foreach ($value as $key => $name) {
				if ($key == 'Field') {
					$attr[] = $name;
				}
			}
		}
		return $attr;
	}

	/*
	*	Gets current object attributes
	*/

	public function __get($attribute)
	{
		if (array_key_exists($attribute, $this->_attributes)) {
			return $this->_attributes[$attribute];
		}
		return null;
	}

	/**
	 * saves the object on database
	 * @throws \Exception
     * @returns $this
	 */
    public function save() : DbEntity
	{
		$befo = $this->beforeSave();
		if ( $this->_isNew )
			$this->_dbConn->insert($this->_table, $befo['attr'], $befo['values']);
		else {

		}
        return $this;
	}

	/**
	 * Method executed before object is saved, it filters any data that doesn't need to be saved
	 * @return array
	 */
    protected function beforeSave(): array
	{
		$attr = $values = array();
		foreach ($this->_attributes as $key => $value) {
			if ($key == 'id' || $key == 'date') continue;
			$attr[] = $key;
			$values[] = $value;
		}
		return array("attr" => $attr, "values" => $values);
	}
	/*
	 @TODO: have some stuff to do before object loads
	*/

	public function beforeLoad(){

	}

    /**
     * @param null $data
     * @return array|mixed
     */
	public function getData($data = null){
		if (is_null($data))
			return $this->_attributes;	
		return $this->_attributes[$data];
	}

    /**
     * @param $id
     * @param null $attribute
     * @return $this
     * @throws \Exception
     */
	public function load($id, $attribute = null)
	{
		$this->_attributes = $this->_dbConn->select($this->_table, null, array(is_null($attribute) ? 'id' : $attribute => $id))[0];
		$this->_isNew = false;
		return $this;
	}

    /**
     * @param null $attribute
     * @param null $value
     * @return array
     * @throws \Exception
     */
	public function getCollection($attribute=null, $value=null){
		$data = $this->_dbConn->select($this->_table, $attribute, $value);
		$class = get_class($this);

		$ret = array();
		foreach ($data as $value){
			$ret[] = new $class($value);
		}
		return $ret;
	}

    /**
     * @param $attribute
     * @param $data
     * @returns $this
     */
	public function setData($attribute, $data)
	{
		if (!array_key_exists($attribute, $this->_attributes)) {
            trigger_error("'" . $attribute . "' doesn't exist on ", E_USER_NOTICE);
            return $this;
		}
        $this->_attributes[$attribute] = $data;
        return $this;
	}

}