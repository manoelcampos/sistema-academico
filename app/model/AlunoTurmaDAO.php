<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class AlunoTurmaDAO extends DAO {
	
	/**
	* Select a object in the database
	*
	* @param	Exemplo	$dto	Record object
	* @return	Exemplo
	*/
	public static function getByTurma($id_turma){
		$sql = " SELECT at.*, a.nome as aluno, a.matricula, concat(a.nome, ' / ', coalesce(a.matricula, '')) as aluno_matricula  ".
           " FROM aluno_turma at " .
           " inner join turma t on t.id = at.id_turma ".
           " inner join vwaluno a on a.id = at.id_aluno and a.id_curso = t.id_curso  " .
           " where at.id_turma = $id_turma ".
					 " order by a.nome ";

		//die ($sql);
		return Database::getInstance()->query($sql);
	}

	/** Obtém a lista de alunos que estejam aprovados em todas as disciplinas do módulo
	*/
	public static function getAprovadosByTurma($id_turma){
            $sql = 
                    " SELECT at.*, a.nome as aluno, a.matricula, " .
                    " concat(a.nome, ' / ', coalesce(a.matricula, '')) as aluno_matricula  ".
                    " FROM vwAlunoTurma at " .
                    " inner join turma t on t.id = at.id_turma ".
                    " inner join vwaluno a on a.id = at.id_aluno and a.id_curso = t.id_curso  " .
                    " where at.id_turma = $id_turma ".
                    " and at.disciplinas_aprovadas = at.disciplinas_turma" .
                    " order by a.nome ";
            //echo "<h4>$sql</h4>";
            return Database::getInstance()->query($sql);
	}
        
	public static function getReprovadosByTurma($id_turma){
            $sql = " SELECT at.*, a.nome as aluno, a.matricula, concat(a.nome, ' / ', coalesce(a.matricula, '')) as aluno_matricula  ".
                " FROM aluno_turma at " .
                " inner join turma t on t.id = at.id_turma ".
                " inner join vwaluno a on a.id = at.id_aluno and a.id_curso = t.id_curso  " .
                " where at.id_turma = $id_turma ".
                " and exists( " . 
                "		select atd.id from aluno_turma_disciplina atd " .
                "		where atd.id_aluno = at.id_aluno and atd.id_turma = at.id_turma ".
                "		and (atd.id_conceito = 2 or coalesce(atd.media_final,0) = 0) " .
                "	) " .
                " order by a.nome ";
            return Database::getInstance()->query($sql);
	}

	public static function getByAlunoAndCurso($id_aluno, $id_curso, $id_polo, $somente_aptos=false){
		$sql = 
			" SELECT at.*, t.id_curso, t.id_modulo, m.descricao as modulo, 
			m.qualificacao, t.semestre,  conc.descricao as conceito, 
			m.ordem as num_modulo FROM vwAlunoTurma at 
			inner join turma t on t.id = at.id_turma 
			inner join conceito conc on conc.id = at.id_conceito
			inner join vwaluno a on a.id = at.id_aluno 
                           and a.id_curso = t.id_curso
                           and a.id_polo = t.id_polo
			inner join modulo_curso m on m.id = t.id_modulo
			where t.id_curso = $id_curso and a.id = $id_aluno 
                        and a.id_curso = $id_curso and t.id_polo = $id_polo 
                        and t.semestre >= '" .  Turma::getSemestrePadrao() . "'";
                if($somente_aptos) {
                    $sql .= " and at.id_conceito = " . Conceito::ID_APTO;
			    " and at.disciplinas_aprovadas = at.disciplinas_turma ";
                }
		$sql .= " order by m.ordem ";
                //die "$sql>";
		return Database::getInstance()->query($sql);
	}

}
