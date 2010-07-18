<?php
/**
 * BaseDaoGenerator
 *
 * <code>
 * $a = new TableDefinitionDao("your dsn definition");
 * </code>
 *
 * @package    peewee.dao
 * @author     rds <tk@rasign.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.0.1
 * @link       http://rasign.jp/peewee/
 */
class TableDefinitionDao{
    /**
     * @var    ADOConnection
     * @access private
     */
    var $connection = null;

    /**
     * default constructor
     *
     * @access public
     */
    function TableDefinitionDao(){
		$dsn = "mysql://" . PEEWEE_DSN_USER . ":" . PEEWEE_DSN_PASSWORD . "@" . PEEWEE_DSN_SERVER . "/" . PEEWEE_DSN_DATABASE;
        $this->connection = ADONewConnection($dsn);
    }

    /**
     * get column name list by teblename
     *
     * @param  String $tableName tablename
     * @return array columnname
     * @access public
     */
    function getColumnList($tableName){
        return  $columnArray = $this->connection->MetaColumnNames($tableName);
    }

    /**
     * get table name list
     *
     * @return array tablename
     * @access public
     */
    function getTableNameList(){
        return $tableArray = $this->connection->MetaTables("TABLES");
    }

    /**
     * get primary key list
     *
     * @return array tablename
     * @access public
     */
    function getPrimaryKeyList($tableName){
        return $this->connection->MetaPrimaryKeys($tableName);
    }
}
?>