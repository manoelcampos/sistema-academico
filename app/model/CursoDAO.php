<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class CursoDAO extends DAO {
  const ORDERBY = " order by c.descricao ";

  public static function all() {
    $sql = "select c.* from curso c where 1=1 " . Usuario::filtroCursoUsuario("c.id");
    $sql .= static::ORDERBY;
    return Database::getInstance()->query($sql);
  }
	
	/**
	* Select a object in the database
	*
	* @param	Exemplo	$dto	Record object
	* @return	Exemplo
	*/
	public function get($id){
		$sql = " SELECT c.*, n.descricao as nivel ".
		       " FROM curso c inner join nivel_curso n on n.id = c.id_nivel_curso " .
		       " WHERE c.id=$id";
		return Database::getInstance()->queryOne($sql);
	}


	public static function getWithCargaHorariaTotalAndQuantModulos($id){
	  //QM = quantidade de módulos
    $sqlQM = "(select count(*) from modulo_curso m where m.id_curso = c.id)";
    //CH = carga horária
    $sqlCH = "(select sum(carga_horaria) from disciplina d where d.id_curso = c.id)";
		$sql = 
       " SELECT c.*, a.descricao as area_profissional, nc.hora_aula, nc.descricao as nivel,  " . 
       " coalesce($sqlCH, 0) as carga_horaria_total, " .
       " $sqlQM as quant_modulos, r.descricao as regime " .
       " FROM curso c ".
       " inner join nivel_curso nc on nc.id = c.id_nivel_curso " .
       " inner join area_profissional a on c.id_area_profissional = a.id ".
       " inner join regime_curso r on c.id_regime_curso = r.id " .
       " WHERE c.id=$id ";
    //echo $sql;
		return Database::getInstance()->queryOne($sql);
	}

}
