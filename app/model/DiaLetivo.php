<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class DiaLetivo extends DTO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $id_turma=0, $id_disciplina=0, $data="", $quant_aulas=0, $conteudo=""){
		if (isset($this->id)) return; // PDO BUG	
		$this->id 		= $id;
    $this->id_turma 		= $id_turma;
    $this->id_disciplina 		= $id_disciplina;
    $this->data 		= $data;
    $this->quant_aulas 		= $quant_aulas;
    $this->conteudo 		= $conteudo;
	}

  public static function get($id) {
    return DiaLetivoDAO::get($id);
  }

	public static function getByTurmaDisciplina($id_turma, $id_disciplina){
	   return DiaLetivoDAO::getByTurmaDisciplina($id_turma, $id_disciplina);
  }

}
