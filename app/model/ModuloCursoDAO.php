<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class ModuloCursoDAO extends DAO {
    const ORDERBY = " order by m.curso, m.ordem ";
	
    /**
    * Select a object in the database
    *
    * @param	Exemplo	$dto	Record object
    * @return	Exemplo
    */
    public static function totalModulosCurso($id_curso){
        $sql = "SELECT count(*) as total FROM modulo_curso WHERE id_curso=$id_curso";
        $o =  Database::getInstance()->queryOne($sql);
        return $o->total;
    }

    public function get($id){
        $sql = "SELECT m.* FROM vwmodulo_curso m WHERE m.id=$id ". ModuloCursoDAO::ORDERBY;
        return Database::getInstance()->queryOne($sql);
    }
    
    /**
    * Load all objects from the database
    *
    * @return	array
    */
    public static function getByCurso($id_curso){
        $sql = " SELECT * from vwmodulo_curso m where m.id_curso = $id_curso ". static::ORDERBY;
        return Database::getInstance()->query($sql);
    }

    /**
    * Seleciona apenas os módulos de um curso que têm turmas em um determinado semestre.
    * @param $id_curso integer Código do curso a ser selecionado.
    * @param $id_professor integer Código do professor logado no sistema, para
    * retornar apenas os módulos em que o professor leciona. O parâmetro é opcional.
    * @return	array<ModuloCurso>
    */
    public static function getBySemestre($semestre, $id_curso=0, $id_professor=0){
        $filtro_curso1 = "";
        $filtro_curso2 = "";
        if($id_curso > 0) {
           $filtro_curso1 = " m.id_curso = $id_curso and ";
           $filtro_curso2 = " t.id_curso = $id_curso and ";
        }

        if($id_professor == 0) {
          $sql = 
            " SELECT m.* from vwmodulo_curso m ".
            " where $filtro_curso1 exists(".
            " select distinct t.id_modulo from turma t " .
            " where $filtro_curso2 t.semestre = '$semestre' and t.id_modulo = m.id) ";
        }
        else {
          $sql = 
            " SELECT distinct m.* FROM vwmodulo_curso m " .
            " inner join turma t on t.id_curso = m.id_curso and t.id_modulo = m.id " .     
            " inner join `disciplina_turma` dt on dt.id_turma = t.id " .
            " WHERE $filtro_curso1 t.semestre = '$semestre' and dt.id_professor = $id_professor ";
        }

        return Database::getInstance()->query($sql);
    }

    public static function all() {
        $sql = " SELECT m.* from vwmodulo_curso m where 1=1 " . 
                Usuario::filtroCursoUsuario("m.id_curso") .
               static::ORDERBY;
        return Database::getInstance()->query($sql);
    }
}
