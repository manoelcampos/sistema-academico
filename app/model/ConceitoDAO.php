<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class ConceitoDAO extends DAO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/

	public static function get($id){
		$sql = "SELECT * FROM conceito WHERE id=$id";
		return Database::getInstance()->queryOne($sql);
	}
}
