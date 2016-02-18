<?php
namespace TinyBoard\Objects\Utils;
use TinyBoard\Objects\Utils\DbConn\Query;
use TinyBoard\TinyBoard;

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
     * @var Query
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
		$this->query = new Query();
	}

	/**
	 * Loads Db connection configuration from xml
	 * @throws \Exception
	 */
    public function loadConfig()
    {
        if ( file_exists('etc/config.xml') ){
			$xmlParser = new \TinyBoard\Objects\Utils\XmlLoader();
			$xml = $xmlParser->loadXml('etc/config.xml')->parseXml();
			$this->username = $xml['database']['user'];
			$this->password = empty($xml['database']['password']) ? '' : $xml['database']['password'];
			$this->database = $xml['database']['db'];
			$this->host = $xml['database']['host'];
		}
		else {
			TinyBoard::throwException("config.xml doesn't exist, presumably isn`t installed, redirecting to installer");
		}

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
	 * prepares query to be executed
	 * @param Query $query
	 * @return \PDOStatement
	 */
	public function prepare(Query $query){
		return $this->pdoClient->prepare((string)$query);
	}
	private function bind(\PDOStatement $statement, $values) {
		$count = 1;
		foreach ($values as $value){
			$statement->bindColumn($count, $value, \PDO::PARAM_STR, strlen($value));
		}
		return $statement;
	}

    /**
     * Prepares current query and fetches it
     * @return array
     */
    public function prepareAndFetchAll(){
        $statement = $this->pdoClient->query((string)$this->query);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
	/**
	 * @param \PDOStatement $statement
	 * @return array
	 */
	public function execute(\PDOStatement $statement) {
		return $statement->execute();
	}
    /**
     * Get table columns
     * @param $table
     * @return array
     */
    public function getColumns($table)
    {
		$this->query->describe($table);
        return $this->prepareAndFetchAll();
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
        $this->query->select($from, $what);

        if (!is_null($where)){
            $this->query->where($where);
        }

		return $this->prepareAndFetchAll();
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