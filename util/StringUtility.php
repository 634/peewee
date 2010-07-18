<?php
/**
 * String Utility Class
 *
 * @package    peewee.util
 * @author     rds <tk@rasign.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.0.1
 * @link       http://rasign.jp/peewee/
 */
class StringUtility{

    /**
     * transration string to classname
     *
     * e.g.
     * name -> Name
     * user_name -> UserName
     *
     * @param  String $string string
     * @return String classname
     * @access public
     */
    function getClassName($string){
        $classUnderlineArray = explode(_, $string);
        $className = "";
        foreach($classUnderlineArray as $classNameParts){
            $className .= ucfirst($classNameParts);
        }
        return $className;
    }

    /**
     * transration string to variablename
     *
     * e.g.
     * name -> name
     * user_name -> userName
     *
     * @param  String $string string
     * @return String variablename
     * @access public
     */
    function getVariableName($string){
        $className = $this->getClassName($string);
        $variableName = strtolower($className[0]).substr($className, 1);
        return $variableName;
    }
}
?>