<?php
/**
 * Notas de um aluno para um determinada disciplina
 * @package AcademicoEad
 * @subpackage model
 */
class AlunoTurmaDisciplinaDAO extends DAO {
	
	/**
	* Obtém a lista com as notas das disciplinas de um aluno em uma determinada turma.
	* Mesmo para as disciplinas da turma em que o aluno não estiver matriculado
    * será retornada um registro com os dados do aluno e da disciplina,
    * o que facilita a utilização dos dados da consulta em
    * relatórios como a "Ficha de Conselho Pedagógico", que mostra
    * as notas dos alunos de uma turma, de todas as disciplinas da turma.
	*/
	public static function getByTurma($id_aluno, $id_turma, $orderby="descricao") {
         $sql = " SELECT atd.id, at.id_aluno, at.id_turma,  ".
                " dt.id_disciplina, d.descricao as disciplina, d.carga_horaria, " .
                " atd.id_conceito, conc.descricao as conceito, atd.media_final, a.nome as aluno " .
                " FROM  aluno_turma at " .
                " inner join turma t on t.id = at.id_turma ".
                " inner join curso c on c.id = t.id_curso ".
                " inner join vwaluno a on a.id = at.id_aluno and a.id_curso = c.id " .
                " inner join disciplina_turma dt on dt.id_turma = at.id_turma " .
                " inner join disciplina d on d.id = dt.id_disciplina " .
                " left outer join aluno_turma_disciplina atd on ". 
                " dt.id_disciplina = atd.id_disciplina and at.id_aluno = atd.id_aluno and atd.id_turma = at.id_turma " .
                " left outer join conceito conc on conc.id = atd.id_conceito " .
                " where at.id_turma = $id_turma and at.id_aluno = $id_aluno ".
                " order by d.$orderby; ";
         //echo "<h4>notas: $sql</h4>";
         return Database::getInstance()->query($sql);
	}


	/**
	* Obtém a lista com as notas dos alunos de uma disciplina em uma determinada turma.
  * Mesmo os alunos que não tem nota na disciplina são retornados para que seja possível
  * atribuir uma nota a eles na respectiva página.
	*/
	public static function getByDisciplina($id_turma, $id_disciplina, $orderby="a.nome") {
		$sql = " SELECT atd.id, at.id_aluno, at.id_turma,  ".
           " dt.id_disciplina, a.matricula, " .
           " atd.id_conceito, conc.descricao as conceito, atd.media_final, a.nome as aluno " .
           " FROM  aluno_turma at " .
           " inner join turma t on t.id = at.id_turma ".
           " inner join curso c on c.id = t.id_curso ".
           " inner join vwaluno a on a.id = at.id_aluno and a.id_curso = c.id  " .
           " inner join disciplina_turma dt on dt.id_turma = at.id_turma " .
           " inner join disciplina d on d.id = dt.id_disciplina " .
           " left outer join aluno_turma_disciplina atd on ". 
           " dt.id_disciplina = atd.id_disciplina and at.id_aluno = atd.id_aluno and atd.id_turma = at.id_turma " .
           " left outer join conceito conc on conc.id = atd.id_conceito " .
           " where atd.id_turma = $id_turma and atd.id_disciplina = $id_disciplina ".
           " order by $orderby; ";
		return Database::getInstance()->query($sql);
	}
}
