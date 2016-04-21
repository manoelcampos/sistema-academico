<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class AlunoTurma extends DTO{
    /**
    * Contruct a Exemplo object
    *
    * @return	void
    */
    public function __construct($id=0, $id_aluno=0, $id_turma=0){
        if (isset($this->id)) return; // PDO BUG	
        $this->id 		= $id;
        $this->id_aluno 	= $id_aluno;
        $this->id_turma = $id_turma;
    }

    public static function getByTurma($id_turma){
        return AlunoTurmaDAO::getByTurma($id_turma);
    }

    public static function getReprovadosByTurma($id_turma){
        return AlunoTurmaDAO::getReprovadosByTurma($id_turma);
    }
    
    public static function getAprovadosByTurma($id_turma){
        return AlunoTurmaDAO::getAprovadosByTurma($id_turma);
    }

  /**
  * Obtém os dados das turmas do aluno de um determinado curso em que 
  * o mesmo foi matriculado 
  * e aprovado em todas as disciplinas.
  * Assim, ter-se-á uma lista dos módulos/semestres
  * em que foi aprovado no curso.
  */
    public static function getByAlunoAndCurso($id_aluno, $id_curso, $id_polo, $somente_aptos=false){
       return AlunoTurmaDAO::getByAlunoAndCurso($id_aluno, $id_curso, $id_polo, $somente_aptos);
    }
}
