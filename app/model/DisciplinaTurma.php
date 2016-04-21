<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class DisciplinaTurma extends DTO{
  var $polo;
    /**
    * Contruct a Exemplo object
    *
    * @return	void
    */
    public function __construct($id=0, $id_turma=0, $id_disciplina=0, $id_professor=0){
        if (isset($this->id)) return; // PDO BUG	
        $this->id 		= $id;
        $this->id_turma 	= $id_turma;
        $this->id_disciplina = $id_disciplina;
        $this->id_professor = $id_professor;
    }

    public static function getDisciplinasByTurma($id_turma, $id_professor=0, $orderby="descricao"){
        return DisciplinaTurmaDAO::getDisciplinasByTurma($id_turma, $id_professor, $orderby);
    }

    public static function getDisciplinasByCurso($id_curso, $orderby="descricao"){
        return DisciplinaTurmaDAO::getDisciplinasByCurso($id_curso, $orderby);
    }
    
    public static function getDisciplinas($id_polo, $id_modulo, $semestre, $id_curso=0, $orderby="descricao"){
        return DisciplinaTurmaDAO::getDisciplinas($id_polo, $id_modulo, $semestre, $id_curso, $orderby);
    }
}
