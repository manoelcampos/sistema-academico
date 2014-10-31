<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class AlunoCursoDAO extends DAO {
    public static function getAprovados($turmas) {
        $id_turmas = "-1";
        foreach($turmas as $t)
            $id_turmas .= ", $t->id";
        
        $sql = "SELECT ac.id as id_aluno_curso, at.id_aluno, a.nome as aluno, 
        a.matricula, concat(a.nome, ' / ', coalesce(a.matricula, '')) as aluno_matricula,
        sum(at.disciplinas_aprovadas) as total_disciplinas_aprovadas_curso,
        sum(at.disciplinas_turma) as total_disciplinas_curso
        FROM vwAlunoTurma at
        inner join turma t on t.id = at.id_turma 
        inner join vwaluno a on 
           a.id = at.id_aluno and 
           a.id_curso = t.id_curso and
           a.id_polo = t.id_polo
        inner join aluno_curso ac on
           ac.id_aluno = at.id_aluno and 
           ac.id_curso = t.id_curso and
           ac.id_polo = t.id_polo
        where at.id_turma in ($id_turmas) 
        group by 1, 2, 3, 4, 5
        having sum(at.disciplinas_aprovadas) = sum(at.disciplinas_turma)";
                
        return Database::getInstance()->query($sql);
    }
   
    public static function getByNomeMatriculaCPF($nome_matricula_cpf, $id_curso=0, $id_polo=0){
        $matricula_ou_cpf = str_replace("-", "", str_replace(".", "", trim($nome_matricula_cpf)));
        $busca_por_matricula_ou_cpf = is_numeric($matricula_ou_cpf);
        $nome_matricula_cpf = str_replace(" ", "%", $nome_matricula_cpf);
        $sql = " SELECT ac.*, a.nome, a.matricula, 
                 concat(a.nome, ' / ', coalesce(a.matricula, ''), ' - ', c.descricao, ' / ',p.descricao) 
                 as nome_matricula  
                 FROM aluno_curso ac 
                 inner join vwaluno a on a.id = ac.id_aluno and a.id_curso = ac.id_curso 
                 inner join curso c on c.id = ac.id_curso
                 inner join polo p on p.id = ac.id_polo
                 where 1=1 ";
         if($id_curso != "" && $id_curso != 0)
            $sql .= " and ac.id_curso = $id_curso ";

         if($id_polo != "" && $id_polo != 0)
            $sql .= " and ac.id_polo = $id_polo ";

         if($busca_por_matricula_ou_cpf) 
            $sql .= " and (a.matricula = '$matricula_ou_cpf' or a.cpf = '$matricula_ou_cpf') ";
         else $sql .= " and a.nome like '$nome_matricula_cpf%' ";
         $sql .= " order by a.nome ";
         //echo $sql;
        return Database::getInstance()->query($sql);
    }

    public static function getByIdAlunoCurso($id_aluno_curso, $id_curso=0, $id_polo=0){
        $sql = " SELECT ac.*, a.nome, ti.descricao as tipo_ingresso, 
                curso.descricao as curso, p.descricao as polo,
                c.descricao as cidade_curso_anterior, e.uf as uf_curso_anterior 
                FROM aluno_curso ac 
                inner join curso on curso.id = ac.id_curso
                inner join polo p on p.id = ac.id_polo
                inner join vwaluno a on a.id = ac.id_aluno and ac.id_curso = a.id_curso
                inner join tipo_ingresso ti on ti.id = ac.id_tipo_ingresso 
                left outer join cidade c on c.id = ac.id_cidade_curso_anterior 
                left outer join estado e on e.id = c.id_estado 
                where ac.id = $id_aluno_curso ";
         if($id_curso != "" && $id_curso != 0)
            $sql .= " and ac.id_curso = $id_curso ";

         if($id_polo != "" && $id_polo != 0)
            $sql .= " and ac.id_polo = $id_polo ";

         //echo $sql;
        return Database::getInstance()->queryOne($sql);
    }
    
    public static function registrarDataColacaoGrau($ids_aluno_curso, $id_curso, $id_polo, $data) {
        $ids_str = "-1";
        foreach ($ids_aluno_curso as $id) {
            $ids_str .= ", $id";
        }
        $sql = "update aluno_curso set data_colacao_grau = '$data' 
                where id in ($ids_str)
                and id_curso = $id_curso and id_polo = $id_polo";
        //echo "<h3>$sql</h3>";
        Database::getInstance()->exec($sql);
    }
}
