<?php

/**
 * FileSystem Utility Class
 *
 * @package    peewee.util
 * @author     rds <tk@rasign.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.0.1
 * @link       http://rasign.jp/peewee/
 */
class FileUtility{
    /**
     * output PHP source file .
     *
     * @param  String $fileName filename
     * @param  String $fileString text
     * @param  String $destination filepath
     * @access public
     */
    function writePhpFile($fileName, $fileString, $destination = './') {
        $fp = fopen($destination . $fileName . '.class.php', 'w');
        fwrite($fp, "<?php\n");
        fwrite($fp, $fileString);
        fwrite($fp, "?>\n");
        fclose($fp);
    }
}
?>