<?php

/**
 * @package AcademicoEad
 * @subpackage model
*/
class TurmaDAO extends DAO {
    const ORDERBY = " order by c.descricao, m.ordem, p.descricao ";
    const SQL_SEMESTRES = "select distinct semestre from turma order by semestre desc";
    const SQL_ULTIMO_SEMESTRE = "select distinct semestre from turma order by semestre desc limit 0, 1 ";

    /**
    * Select a object in the database
    *
    * @param	Exemplo	$dto	Record object
    * @return	Exemplo
    */
    public function getById($id){
       $sql = " SELECT t.*, p.descricao as polo, c.descricao as curso, ".
       " m.descricao as modulo, ap.descricao as area " .
       " FROM turma t " .
       " inner join polo p on p.id = t.id_polo " .
       " inner join curso c on c.id = t.id_curso " .
       " inner join area_profissional ap on ap.id = c.id_area_profissional " .
   " left outer join modulo_curso m on m.id = t.id_modulo " .
       " where t.id = $id ";
       return Database::getInstance()->queryOne($sql);
    }
    
    public static function getListaModulosTurma($id_curso, $id_polo, $semestre_inicio) {
       $sql = 
        "select t.*, 
        (select count(*) from disciplina_turma dt where dt.id_turma = t.id) 
        as total_disciplinas from turma t
        inner join modulo_curso m on m.id = t.id_modulo
        where t.id_curso = $id_curso and t.id_polo = $id_polo 
        and t.semestre >= '$semestre_inicio'
        order by t.semestre, m.ordem
        limit 0, " . ModuloCurso::totalModulosCurso($id_curso);
       return Database::getInstance()->query($sql);
    }
    

    public static function get($id_polo, $id_curso=0, $id_modulo=null, $semestre=null){
        $sql = " SELECT t.*, p.descricao as polo, c.descricao as curso, ".
        " m.descricao as modulo, m.ordem as ordem_modulo, ap.descricao as area " .
        " FROM turma t " .
        " inner join polo p on p.id = t.id_polo " .
        " inner join curso c on c.id = t.id_curso " .
        " inner join area_profissional ap on ap.id = c.id_area_profissional " .
        " left outer join modulo_curso m on m.id = t.id_modulo " .
        " where t.id_polo = $id_polo " . Usuario::filtroCursoUsuario("t.id_curso");
        if($id_curso > 0) 
            $sql .= " and t.id_curso = $id_curso ";
        if(isset($id_modulo))
           $sql .= " and t.id_modulo = $id_modulo ";
        if(isset($semestre))
           $sql .= " and t.semestre = '$semestre' ";
        return Database::getInstance()->queryOne($sql);
    }

    public static function getModulo1($id_polo, $id_curso, $semestre_inicio){
        $sql = "select m.id from turma t 
            inner join modulo_curso m on m.id = t.id_modulo
            where t.id_polo = $id_polo
            and t.id_curso = $id_curso and t.semestre = '$semestre_inicio'
            and m.ordem = 1";
        $modulo = Database::getInstance()->queryOne($sql);
        return static::get($id_polo, $id_curso, $modulo->id, $semestre_inicio);
    }
    
    
    public static function getDescriptionsById($id_turma){
       $sql = " SELECT t.*, p.descricao as polo, c.descricao as curso, ".
       " m.descricao as modulo, ap.descricao as area " .
       " FROM turma t " .
       " inner join polo p on p.id = t.id_polo " .
       " inner join curso c on c.id = t.id_curso " .
       " inner join area_profissional ap on ap.id = c.id_area_profissional " .
       " left outer join modulo_curso m on m.id = t.id_modulo " .
       " where t.id = $id_turma ";
       return Database::getInstance()->queryOne($sql);
    }

    /*** Obtém a lista de semestres distintos de todas as turmas cadastradas.
    * @return array Retorna uma lista de objetos com os semestres cadastrados.
    */
    public static function getSemestres() {
      return Database::getInstance()->query(TurmaDAO::SQL_SEMESTRES);
    }

    /*** Obtém o último semestre cadastrado em todas as turmas cadastradas.
    * @return string Retorna o último semestre cadastrado.
    */
    public static function getUltimoSemestre() {
      $o = Database::getInstance()->queryOne(TurmaDAO::SQL_ULTIMO_SEMESTRE);
      if(isset($o))
         return $o->semestre;
    }

    public static function all($semestre=null, $id_curso=0){
        $sql = " SELECT t.*, p.descricao as polo, c.descricao as curso, 
            m.ordem as num_modulo,
            m.descricao as modulo, ap.descricao as area 
            FROM turma t 
            inner join polo p on p.id = t.id_polo 
            inner join curso c on c.id = t.id_curso 
            inner join area_profissional ap on ap.id = c.id_area_profissional 
            left outer join modulo_curso m on m.id = t.id_modulo 
            where 1=1 ". Usuario::filtroCursoUsuario("t.id_curso");
        if($semestre)
           $sql .= " and t.semestre = '$semestre'";
        if($id_curso>0)
            $sql .= " and t.id_curso = $id_curso";
        $sql .= static::ORDERBY;
        return Database::getInstance()->query($sql);
    }
    
    public static function insertTurmas($semestre, $id_polos, $id_curso, $id_modulo) {
        if(!isset($id_polos) || !count($id_polos) || !is_array($id_polos))
            return 0;
        $criadas = 0;
        $db = Database::getInstance();
        $db->begin();
        try {
            foreach($id_polos as $id_polo) {
                $sql = " select id from turma 
                        where semestre = '$semestre'
                        and id_polo = $id_polo 
                        and id_curso = $id_curso 
                        and id_modulo = $id_modulo ";
                //echo "$sql<br/>";
                if(!$db->queryOne($sql)) {
                    $sql = "insert into turma (id_polo, id_curso, id_modulo, semestre)
                            values ($id_polo, $id_curso, $id_modulo, '$semestre')";
                    //echo "$sql<br/>";
                    $id_turma = $db->exec($sql);
                    
                    //Seleciona as disciplinas para serem inseridas na turma 
                    //de um módulo e pólo do curso
                    $id_professor_a_definir = 60;
                    $sql = " insert into disciplina_turma
                    (id_turma, id_disciplina, id_professor)
                    SELECT t.id as id_turma,  d.id as id_disciplina, $id_professor_a_definir as id_professor
                    FROM disciplina d 
                    inner join modulo_curso m on m.id = d.id_modulo
                    inner join turma t on t.id_curso = m.id_curso and t.id_modulo = d.id_modulo\n
                    ##necessário filtrar pelo semestre para não pegar turmas antigas\n
                    where d.id_curso = $id_curso and d.id_modulo = $id_modulo
                    and t.id = $id_turma 
                    order by m.ordem, d.descricao, t.id_polo;";
                    //echo "$sql<br/><br/>";
                    echo "Turma $id_turma criada</br>";
                    $db->exec($sql);
                    $criadas++;
                }
            }
            $db->commit();
        } catch(Exception $e) {
          $db->rollBack();
          throw $e;
        } 
        return $criadas;
    }

}
