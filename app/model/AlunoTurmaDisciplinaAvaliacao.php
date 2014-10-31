<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class AlunoTurmaDisciplinaAvaliacao extends DTO{
  
  public static function validarNota($nota) {
      if(empty($nota))
        return 0.0;
      else {
         $nota = str_replace(",", ".", $nota);
         return $nota;
      }
  }

	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $id_avaliacao=0, $id_aluno=0, $nota=0){
		if (isset($this->id)) return; // PDO BUG	
		$this->id 		= $id;
		$this->id_avaliacao 	= $id_avaliacao;
		$this->id_aluno 	= $id_aluno;
		$this->nota 	= $nota;
	}

	public static function getByAvaliacao($id_avaliacao, $orderby="a.nome") {
      return AlunoTurmaDisciplinaAvaliacaoDAO::getByAvaliacao($id_avaliacao, $orderby);
  }

  public static function salvarNotas($id_avaliacao, $id_turma, $notas) {
      return AlunoTurmaDisciplinaAvaliacaoDAO::salvarNotas($id_avaliacao, $id_turma, $notas);
  }

}
