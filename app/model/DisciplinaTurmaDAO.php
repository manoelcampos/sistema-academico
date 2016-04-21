<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class DisciplinaTurmaDAO extends DAO {
	
    /**
    * Seleciona a lista de disciplinas de uma determinada turma.
    * @param integer $id_turma Código da turma desejada
    * @param string $id_professor Código do professor logado no sistema, para
    * retornar apenas os módulos em que o professor leciona. O parâmetro é opcional.
    * @param string $orderby Campo de ordenação do resultado. Opcional.
    * @return	array
    */
    public static function getDisciplinasByTurma($id_turma, $id_professor=0, $orderby="descricao"){
       $sql = " SELECT dt.*, d.descricao, d.carga_horaria, " .
       " d.sigla, p.nome as professor " .
       " FROM disciplina_turma dt " .
       " inner join disciplina d on d.id = dt.id_disciplina " .
       " inner join vwprofessor p on p.id = dt.id_professor " .
       " where dt.id_turma = $id_turma ";
        if($id_professor > 0)
          $sql .= " and id_professor = $id_professor ";
        $sql .= " order by d.$orderby " ;
        //echo "<h4>disciplinas: $sql</h4>";
        return Database::getInstance()->query($sql);
    }

    public static function getDisciplinasByCurso($id_curso, $orderby="descricao"){
       $sql = " SELECT d.* 
       FROM disciplina d
       inner join modulo_curso m on m.id = d.id_modulo
       where d.id_curso = $id_curso 
       order by m.ordem, $orderby ";
       return Database::getInstance()->query($sql);
    }
    
    public static function getDisciplinas($id_polo, $id_modulo, $semestre, $id_curso=0, $orderby="descricao"){
       $filtro_curso = "";
       if($id_curso > 0)
          $filtro_curso = " t.id_curso = $id_curso and ";
       
       $sql = " SELECT dt.*, d.descricao, d.carga_horaria, " .
        " d.sigla, p.nome as professor " .
        " FROM disciplina_turma dt " .
        " inner join turma t on t.id = dt.id_turma ".
        " inner join disciplina d on d.id = dt.id_disciplina " .
        " inner join vwprofessor p on p.id = dt.id_professor " .
        " where t.id_polo = $id_polo and $filtro_curso t.id_modulo = $id_modulo ". 
        " and t.semestre = '$semestre' order by d.$orderby " ;
        return Database::getInstance()->query($sql);
    }
}
