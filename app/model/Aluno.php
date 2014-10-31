<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class Aluno extends DTO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
    public function __construct($id=0, $nome=""){
	if (isset($this->id)) return; // PDO BUG	
	$this->id 		= $id;
	$this->nome 	= $nome;
    }
    
    public static function get($id){
        $aluno = AlunoDAO::get($id);
        $aluno->data_nascimento = formatDateStr($aluno->data_nascimento, MasterController::displayDateFormat);      
        return $aluno;
    }

  public static function all() {
		return AlunoDAO::all();
  }

  public static function getByNome($nome) {
    return AlunoDAO::getByNome($nome);
  }
}
