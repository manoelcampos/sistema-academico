<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class Curso extends DTO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $descricao='', $id_area_profissional=0, $id_regime_curso=0){
		if (isset($this->id)) return; // PDO BUG	
		$this->id 		= $id;
		$this->descricao 	= $descricao;
		$this->id_area_profissional 	= $id_area_profissional;
		$this->id_regime_curso 	= $id_regime_curso;
	}
	
	public static function all() {
 	  return CursoDAO::all();
	}

  public function get($id) {
    return CursoDAO::get($id);
  }

	/**
	* Obtém os dados de um determinado curso, incluindo soma da carga horária de
  * todas as disciplinas de todos os módulos e o total de semestres do curso.
	*/
	public static function getWithCargaHorariaTotalAndQuantModulos($id){
     return 	CursoDAO::getWithCargaHorariaTotalAndQuantModulos($id);
  }

}
