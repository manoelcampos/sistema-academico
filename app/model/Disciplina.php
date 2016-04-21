<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class Disciplina extends DTO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $descricao="", $sigla="", $id_curso=0, $id_modulo=0, $carga_horaria=0){
		if (isset($this->id)) return; // PDO BUG	
		$this->id 		= $id;
		$this->descricao 		= $descricao;
		$this->sigla 		= $sigla;
		$this->id_curso 	= $id_curso;
    $this->id_modulo = $id_modulo;
    $this->carga_horaria = $carga_horaria;
	}

  public static function all() {
    return DisciplinaDAO::all();
  }

	public static function getByCurso($id_curso){
    	return DisciplinaDAO::getByCurso($id_curso);
  }

	public static function getById($id){
    	return DisciplinaDAO::getById($id);
  }
}
