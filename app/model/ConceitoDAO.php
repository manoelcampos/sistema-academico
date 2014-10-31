<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
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
