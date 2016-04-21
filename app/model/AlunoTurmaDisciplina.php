<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class AlunoTurmaDisciplina extends DTO{
    /**
    * Contruct a Exemplo object
    *
    * @return	void
    */
    public function __construct($id=0, $id_aluno=0, $id_turma=0, $id_disciplina=0, $id_conceito=0, $media_geral=0){
        if (isset($this->id)) return; // PDO BUG	
            $this->id 		= $id;
            $this->id_aluno 	= $id_aluno;
            $this->id_turma = $id_turma;
            $this->id_disciplina = $id_disciplina;
            $this->id_conceito = $id_conceito;
            $this->media_geral = $media_geral;
	}

    public static function getByTurma($id_aluno, $id_turma, $orderby="descricao"){
    	return AlunoTurmaDisciplinaDAO::getByTurma($id_aluno, $id_turma, $orderby);
    }

    public static function getByDisciplina($id_turma, $id_disciplina, $orderby="nome") {
        return AlunoTurmaDisciplinaDAO::getByDisciplina($id_turma, $id_disciplina, $orderby);
    }

}
