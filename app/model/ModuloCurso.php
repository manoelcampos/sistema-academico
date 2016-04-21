<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class ModuloCurso extends DTO {
    /**
    * Contruct a Exemplo object
    *
    * @return	void
    */
    public function __construct($id=0, $descricao='', $qualificacao="", $ordem=0){
            if (isset($this->id)) return; // PDO BUG	
            $this->id 		= $id;
            $this->descricao 	= $descricao;
            $this->ordem 	= $ordem;
            $this->qualificacao 	= $qualificacao;
    }

    public static function totalModulosCurso($id_curso) {
       return ModuloCursoDAO::totalModulosCurso($id_curso);
    }
    
    public static function getByCurso($id_curso) {
        return ModuloCursoDAO::getByCurso($id_curso);
    }

    public static function getBySemestre($semestre, $id_curso=0, $id_professor=0) {
        return ModuloCursoDAO::getBySemestre($semestre, $id_curso, $id_professor);
    }

    public static function all() {
        return ModuloCursoDAO::all();
    }
}
