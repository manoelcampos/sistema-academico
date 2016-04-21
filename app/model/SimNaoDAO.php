<?php
/** Classe no padrão de projeto DAO (Data Access Objects)
 * que obtém objetos da classe SimNao a partir do banco de dados
 * @package AcademicoEad
 * @subpackage model
*/
class SimNaoDAO extends DAO {
	public static function all(){
		$sql = "SELECT * FROM ".static::getTableName()." order by id desc ";
		return Database::getInstance()->query($sql);
	}	
	
}

?>
