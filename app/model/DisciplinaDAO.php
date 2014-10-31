<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class DisciplinaDAO extends DAO {
  const ORDERBY = " order by c.descricao, m.ordem, d.descricao "; 
  const SELECT =
     " SELECT d.*, c.descricao as curso, m.ordem as ordem_modulo  
     FROM disciplina d inner join curso c on c.id = d.id_curso 
     left outer join modulo_curso m on m.id = d.id_modulo ";
	public static function all() {
		$sql = static::SELECT . 
           static::ORDERBY;
		return Database::getInstance()->query($sql);
	}
	
	public static function getByCurso($id_curso){
		$sql = static::SELECT . 
           " where d.id_curso = $id_curso ".
           static::ORDERBY;
		return Database::getInstance()->query($sql);
	}

	public static function getById($id){
		$sql = static::SELECT . " where d.id = $id ";
		return Database::getInstance()->queryOne($sql);
	}

}
