<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class DiaLetivoDAO extends DAO {
	
	/**
	* Select a object in the database
	*
	* @param	Exemplo	$dto	Record object
	* @return	Exemplo
	*/
	public static function get($id){
		$sql = "SELECT * FROM dia_letivo d WHERE id=$id";
		return Database::getInstance()->queryOne($sql);
	}

	public static function getByTurmaDisciplina($id_turma, $id_disciplina){
		$sql = "SELECT * FROM dia_letivo d " .
		       " WHERE id_turma=$id_turma and id_disciplina=$id_disciplina " .
		       " order by data ";
		return Database::getInstance()->query($sql);
	}

}
