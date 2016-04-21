<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class AreaProfissionalDAO extends DAO {
	
	/**
	* Select a object in the database
	*
	* @param	Exemplo	$dto	Record object
	* @return	Exemplo
	*/
	public function get($id){
		$sql = "SELECT * FROM area_profissional WHERE id=$id";
		return Database::getInstance()->queryOne($sql);
	}
}
