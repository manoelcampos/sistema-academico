<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class Avaliacao extends DTO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $id_disciplina=0, $id_turma=0, $descricao=""){
		if (isset($this->id)) return; // PDO BUG	
		$this->id 		= $id;
		$this->descricao 		= $descricao;
		$this->id_disciplina 	= $id_disciplina;
		$this->id_turma 	= $id_turma;
	}

	public function getByDisciplina($id_turma, $id_disciplina){
    	return AvaliacaoDAO::getByDisciplina($id_turma, $id_disciplina);
  }

}
