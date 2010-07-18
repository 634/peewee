<?php
class BaseDaoGenerator{
    function createBaseDaoClass(){
        $baseDao = null;

		$peewee_dsn_server = PEEWEE_DSN_SERVER;
		$peewee_dsn_user = PEEWEE_DSN_USER;
		$peewee_dsn_password = PEEWEE_DSN_PASSWORD;
		$peewee_dsn_database = PEEWEE_DSN_DATABASE;
		$peewee_dsn_encode = PEEWEE_DSN_ENCODE;

        $baseDao= <<< BASEDAO_END

class BaseDao{
    function getConnection(){
		\$conn = &ADONewConnection("mysql");
		\$server = "{$peewee_dsn_server}";
		\$user = "{$peewee_dsn_user}";
		\$password = "{$peewee_dsn_password}";
		\$database = "{$peewee_dsn_database}";

		\$conn->Connect(\$server, \$user, \$password, \$database);
		mysql_query("SET NAMES {$peewee_dsn_encode}")or die("can not SET NAMES {$peewee_dsn_encode}");
		return \$conn;
    }
}
BASEDAO_END;

        return $baseDao;
    }
}
?>