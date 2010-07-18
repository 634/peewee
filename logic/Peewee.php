<?php
require_once ROOT_DIR . "logic/TableDefinitionDao.php";
require_once ROOT_DIR . "logic/BaseDaoGenerator.php";
require_once ROOT_DIR . "logic/DtoGenerator.php";
require_once ROOT_DIR . "logic/DaoGenerator.php";
require_once ROOT_DIR . "util/FileUtility.php";
require_once ROOT_DIR . "util/StringUtility.php";
require_once ROOT_DIR . ADODB_INC_PATH;

// facade

/**
 * main class of Peewee
 *
 * Here is an example:
 *
 * <code>
 * <?php
 * require_once 'Peewee.php';
 * 
 * $peewee = new Peewee();
 * $peewee->autoCreate();
 * ?>
 * </code>
 *
 * @package    peewee
 * @author     rds <tk@rasign.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.0.1
 * @link       http://rasign.jp/peewee/
 */
class Peewee{

    /**
     * default constructor
     *
     * @param $adodbIncPath Adodb Include Path
     * @param $dsn DataSourceName
     * @access public
     */
    function PeeWee(){
    }

    /**
     * create all table's dto and dao
     *
     * @access public
     */
    function autoCreate(){

        $fileUtility = new FileUtility();
        $stringUtility = new StringUtility();
        $tableDefinitionDao = new TableDefinitionDao();

        $tableNameArray = $tableDefinitionDao->getTableNameList();
        $fileNameArray = array();
        $generationGapSuffix = GENERATIONGAP_SUFFIX;

        $baseDaoGenerator = new BaseDaoGenerator();
        $baseDao = $baseDaoGenerator->createBaseDaoClass();
        $fileUtility->writePhpFile(OUTPUT_DIR . "BaseDao", $baseDao);
        $fileNameArray[] = "BaseDao";

        $dtoGenerator = new DtoGenerator();
        $dto = $dtoGenerator->createDto();
        $fileUtility->writePhpFile(OUTPUT_DIR . $className . "TableDto", $dto);
        $fileNameArray[] = $className . "TableDto";

        foreach($tableNameArray as $tableName){
            $className = $stringUtility->getClassName($tableName);
            $columnList = $tableDefinitionDao->getColumnList($tableName);
            $primaryKeyList = $tableDefinitionDao->getPrimaryKeyList($tableName);

            $daoGenerator = new DaoGenerator();
            if(USE_BASE_CLASS){
                $dao = $daoGenerator->createDao($tableName, $columnList, $primaryKeyList[0], "BaseDao");
            }else{
                $dao = $daoGenerator->createDao($tableName, $columnList, $primaryKeyList[0]);
            }
            $fileUtility->writePhpFile(OUTPUT_DIR . $className . "Dao", $dao);
            $fileNameArray[] = $className . "Dao";
        }
        return $fileNameArray;
    }
}
?>