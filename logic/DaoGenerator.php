<?php
class DaoGenerator{
    function DaoGenerator(){
    }

    function createDao($tableName, $columnList, $primaryKey, $baseClassName = null){
        $stringUtility = new StringUtility();
        $tableClassName = $stringUtility->getClassName($tableName);
        $tableVariableName = $stringUtility->getVariableName($tableName);

        if(!empty($baseClassName)){
            $extends = "extends " . $baseClassName;
            $requireBase = "require_once \"./BaseDao.class.php\";";
        }

        $whereUnique = $primaryKey . " = {\$" . $primaryKey . "}";
        $whereDtoUnique = "\"" . $primaryKey . " = \" . \$tableDto->" . $primaryKey;
		$primaryKeyParameter = "\$" . $primaryKey;

        $selectBase = "select " . join(", ", $columnList) . " from {$tableName}";
        $select .= $selectBase . " where ";
        $select .= $whereUnique;
        $update = "update from $table set " . join(" =?,  ", $columnList) . " =? ";

        $dao = null;
		$adodb_inc_path = ADODB_INC_PATH;
$dao= <<< DAO_END

class {$tableClassName}Dao {$extends}{
    function getConnection(){
        return parent::getConnection();
    }

    function getNextId(){
        \$connection = \$this->getConnection();
        \$recordSet = \$connection->Execute("select max({$primaryKey}) as maxid from {$tableName}");
        if(\$recordSet){
            return (\$recordSet->fields{"maxid"} + 1);
        }else{
            return 1;
        }
	}

    function findByKey({$primaryKeyParameter}){
        \$connection = \$this->getConnection();
        \$recordSet = \$connection->Execute("{$select}");

        if(!\$recordSet){
            return null;
        }else{
            while(!\$recordSet->EOF){
				\$tableDto = new TableDto();
@recordset_to_dao@
                return \$tableDto;
            }
            return null;
        }
    }

    function find(){
        \$connection = \$this->getConnection();
        \$recordSet = \$connection->Execute("{$selectBase}");
        if(!\$recordSet){
            return null;
        }else{
            \$resultArray = array();
            while(!\$recordSet->EOF){
				\$tableDto = new TableDto();
@recordset_to_dao@
                \$recordSet->MoveNext();
                \$resultArray[] = \$tableDto;
            }
            return \$resultArray;
        }
    }

    function findByRand(\$limit=1){
        \$connection = \$this->getConnection();
        \$recordSet = \$connection->Execute("{$selectBase} order by rand() limit {\$limit}");
        if(!\$recordSet){
            return null;
        }else{
            \$resultArray = array();
            while(!\$recordSet->EOF){
				\$tableDto = new TableDto();
@recordset_to_dao@
                \$recordSet->MoveNext();
                \$resultArray[] = \$tableDto;
            }
            return \$resultArray;
        }
    }

    function insert(\$tableDto){
        \$connection = \$this->getConnection();
		\$record = array();
@insert_parameter@
        \$insertSQL = \$connection->AutoExecute({$tableName}, \$record, "INSERT"); 
        return \$insertSQL;
    }

    function update(\$tableDto){
        \$connection = \$this->getConnection();
		\$record = array();
@update_parameter@
        \$insertSQL = \$connection->AutoExecute({$tableName}, \$record, "UPDATE", {$whereDtoUnique});
        return \$insertSQL;
    }

    function delete({$primaryKeyParameter}){
        \$connection = \$this->getConnection();
        \$recordSet = \$connection->Execute("delete from {$tableName} where {$whereUnique}");
        return \$connection->Affected_Rows();
    }

    function trancate({$primaryKeyParameter}){
        \$connection = \$this->getConnection();
        \$recordSet = \$connection->Execute("trancate table {$tableName}");
        return \$connection->Affected_Rows();
    }

    function findCount(){
        \$connection = \$this->getConnection();

        \$recordSet = \$connection->Execute("select count(1) as cnt from {$tableName}");

        if(!\$recordSet){
            return 0;
        }else{
            if(!\$recordSet->EOF){
                return \$recordSet->fields{"cnt"};
            }else{
				return 0;
			}
        }
    }
}
DAO_END;

        $updateParameter = "";
        foreach($columnList as $column){
            $updateParameter .= "        \$record[\"{$column}\"] = \$tableDto->{$column};\n";
        }
        $insertParameter = "";
        foreach($columnList as $column){
			if($column == $primaryKey){
			}else{
	            $insertParameter .= "        \$record[\"{$column}\"] = \$tableDto->{$column};\n";
			}
        }

        $dao = str_replace("@insert_parameter@", $insertParameter, $dao);
        $dao = str_replace("@update_parameter@", $updateParameter, $dao);

        $set = null;
        foreach($columnList as $column){
            $set .= "                \$tableDto->{$column} = \$recordSet->fields{\"$column\"};\n";
        }
        $dao = str_replace("@recordset_to_dao@", $set, $dao);
        return $dao;
    }
}
?>