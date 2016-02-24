<?php

namespace TinyBoard\Objects\Utils\DbConn;

/**
 * Creates the queries to be executed by DbConn
 * Class Query
 * @package TinyBoard\Objects\Utils\DbConn
 */
class Query {
    /**
     * The query itself
     * @var string
     */
    private $_query = '';

    /**
     * @param $into /string
     * @param $what /string
     * @param $value /string
     */
    public function insert($into, $what, $value) {

    }

    public function update($table, $colAndValues) {

    }

    public function delete($table){

    }

    public function replace(){

    }

    public function select($table, $fields) {
        $this->_query = "SELECT ";
        $field = '*';
        if (!is_null($fields)){
            if (is_array($fields)){
                $field = implode(',', $fields);
            }
            else{
                $field = $fields;
            }
        }
        $this->_query = $this->_query . $field . ' FROM ' . $table;
        return $this;
    }
    private function insertOrReplace($whatTodo){

    }

    public function where($where) {
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
        $this->_query = $this->_query. " ". $condition;
    }

    /**
     * @param $table \string
     * @return $this
     */
    public function describe($table) {
        $this->_query = "DESCRIBE $table";
        return $this;
    }
    public function __toString() : \string
    {
        return $this->_query;
    }


}