<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class FrequenciaDAO extends DAO {
	
	public static function frequenciaExists($id_dia_letivo, $id_aluno) {
	  $sql = "select id from frequencia where id_dia_letivo=$id_dia_letivo and id_aluno=$id_aluno ";
	  $o = Database::getInstance()->queryOne($sql);
	  return (isset($o) && $o != "" && $o->id > 0);
	}
	
	public static function insertFrequencia($id_dia_letivo, $id_aluno, $presencas){
		$sql = "insert into frequencia (id_dia_letivo, id_aluno ";
		for($i=1; $i <= count($presencas); $i++)
 		   $sql .= ", aula$i";
	  $sql .= ") values($id_dia_letivo, $id_aluno ";
		for($i=0; $i < count($presencas); $i++)	  
		  $sql .= ", ". $presencas[$i];
    $sql .= ");";
		return Database::getInstance()->exec($sql);
	}

	public static function updateFrequencia($id_dia_letivo, $id_aluno, $presencas){
	  if(FrequenciaDAO::frequenciaExists($id_dia_letivo, $id_aluno)) {
		  $sql = "update frequencia set id=id ";
		  for($i=1; $i <= count($presencas); $i++)	  
   		   $sql .= ", aula$i=". $presencas[$i-1];
   		$sql .= " where id_dia_letivo=$id_dia_letivo and id_aluno=$id_aluno ";
   		return Database::getInstance()->exec($sql) > 0;
	  }	
	  else return FrequenciaDAO::insertFrequencia($id_dia_letivo, $id_aluno, $presencas) > 0;
	}

	public static function batchUpdateFrequencia($id_dia_letivo, $presencas_alunos){
	  foreach($presencas_alunos as $a)
  	  FrequenciaDAO::updateFrequencia($id_dia_letivo, $a->id_aluno, $a->presencas);
	}
	
	public static function batchInsertFrequencia($id_dia_letivo, $presencas_alunos){
	  foreach($presencas_alunos as $a)
  	  FrequenciaDAO::insertFrequencia($id_dia_letivo, $a->id_aluno, $a->presencas);
	}
	
	public static function getByDiaLetivo($id_dia_letivo){
	  $sql = "select * from frequencia where id_dia_letivo = $id_dia_letivo ";
	  $array = array();
	  $db = Database::getInstance();
	  $pdo = $db->getPDO();
	  $db->connect();
	  $rs = $pdo->query($sql);
    while($o = $rs->fetchObject('DTO'))
       $array[$o->id_aluno] = $o;
    $rs->closeCursor();	  
    return $array;
    
		//return Database::getInstance()->query($sql);
	}
	
	
}
