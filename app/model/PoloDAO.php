<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class PoloDAO extends DAO {
	
	/**
	* Select a object in the database
	*
	* @param	Exemplo	$dto	Record object
	* @return	Exemplo
	*/
	public function get($id){
		$sql = "SELECT * FROM polo WHERE id=$id";
		return Database::getInstance()->queryOne($sql);
	}
}
