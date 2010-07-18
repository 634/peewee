<?php
require_once ROOT_DIR . "util/StringUtility.php";
require_once "./peewee.config.php";

class DtoGenerator{
    function createDto(){
$dto= <<< DTO_END
class TableDto{
	private \$data = array();

	public function __set(\$name, \$value) {
        \$this->data[\$name] = \$value;
    }

    public function __get(\$name) {
        if (array_key_exists(\$name, \$this->data)) {
            return \$this->data[\$name];
        }
    }

	public function __toString(){
		\$str = "TableDto";
		if(count(\$this->data) > 0){
			foreach(\$this->data as \$key=>\$value){
				\$str .= "(" . \$key . ":" . \$value . ")";
			}
		}
		return \$str;
	}

}
DTO_END;
        return $dto;
    }
}
?>