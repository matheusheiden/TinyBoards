<?php
namespace TinyBoard\Objects\Utils;
class DbConn{
    /**
     * The object itself for
     * @var $this
     */
	public static $conn;

    /**
     * The object to create database connection
     * @var \PDO
     */
	protected $pdoClient;
    /**
     * The query that's going to be executed
     * @var string
     */
	private $query;
    /**
     * Database username
     * @var string
     */
    private $username = '';
    /**
     * database password
     * @var string
     */
    private $password = '';
    /**
     * database name
     * @var string
     */
    private $database = '';

    /**
     * database host
     * @var string
     */
    private $host = '';

	private function __construct(){
        $this->loadConfig();
        $this->pdoClient = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->username, $this->password);
	}

	/**
	 * Loads Db connection configuration from xml
	 * @throws \Exception
	 */
    public function loadConfig()
    {
        $xmlParser = new XmlLoader();
        $xml = $xmlParser->loadXml('etc/config.xml')->parseXml();
        $this->username = $xml['database']['user'];
        $this->password = empty($xml['database']['password']) ? '' : $xml['database']['password'];
        $this->database = $xml['database']['db'];
        $this->host = $xml['database']['host'];
    }

    /**
     * Get Singleton instance of DbConn
     * @return DbConn
     */
	public static function getInstance(){
		if (self::$conn == null) {
			self::$conn = new DbConn();
			return self::$conn;
		}
		return self::$conn;
	}

    /**
     * Get table columns
     * @param $table
     * @return array
     */
    public function getColumns($table)
    {
		$this->query = "DESCRIBE ".$table;
		$sele = $this->pdoClient->query($this->query);

		$rec = $sele->fetchAll(\PDO::FETCH_ASSOC);
		return $rec;
	}

    /**
     * Execute select query
     * @param $from
     * @param null $what
     * @param null $where
     * @return array
     * @throws \Exception
     */
	public function select($from, $what = null, $where = null){
		$this->query = "SELECT ";
		$field = '*';
		$condition = "";
		if (is_array($where)){
			$condition = "WHERE ";
			foreach($where as $key => $value){
				$condition .= "`$key` = '$value' AND ";
			}
			$condition = rtrim($condition, "AND ");
		}
		elseif(!is_null($where)){
			throw new \Exception("Conditions where need to be an array, example: array(what => value)");
		}
		if (!is_null($what)){
			if (is_array($what)){
				$field = implode(',', $what);
			}
			else{
				$field = $what;
			}
		}
		$this->query = $this->query . $field . ' FROM ' . $from . ' ' . $condition;
		$sele = $this->pdoClient->query($this->query);
		$rec = $sele->fetchAll(\PDO::FETCH_ASSOC);
		return $rec;
	}

    /**
     * Execute insert query
     * @param $where
     * @param $what
     * @param $values
     * @return int
     * @throws \Exception
     */
	public function insert($where, $what, $values){
		$this->query = "INSERT INTO ";
		if (is_null($where)){
			throw new \Exception("No table selected");
		}
		if (is_array($what)){
			$what = implode(',', $what);
		}
		if (is_array($values)){
			foreach ($values as $key => $value) {
				$values[$key] = "'$value'";
			}
			$values = implode(',', $values);
		}
		else
			$values = "'$values'";
		if (count($what) != count($values)){
			throw new \Exception("Attribute quantity isn't equal to the quantity of values");

        }
		$this->query .= $where." (".$what.") VALUES ( $values )";
		$exec = $this->pdoClient->exec($this->query);
		return $exec;
	}

    /**
     * Get Database connection [Debug]
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
		return $this->pdoClient;
	}
}