<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class ConfigDAO extends DAO {	
    /**
    * Select a object in the database
    *
    * @param	Exemplo	$dto	Record object
    * @return	Exemplo
    */
    public static function get(){
        $sql = 
         " SELECT * from config WHERE id=1";
        return Database::getInstance()->queryOne($sql);
    }
}
