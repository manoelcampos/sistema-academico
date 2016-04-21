<?php

/**
 * @package AcademicoEad
 * @subpackage model
*/
class Turma extends DTO{
    /**
    * Contruct a Exemplo object
    *
    * @return	void
    */
    public function __construct($id=0, $id_polo=0, $id_curso=0, $id_modulo=0, $semestre=""){
            if (isset($this->id)) return; // PDO BUG	
            $this->id 	  	 = $id;
            $this->id_polo 	 = $id_polo;
            $this->id_curso  = $id_curso;
            $this->id_modulo = $id_modulo;
            $this->semestre  = $semestre;
    }


    
    /**
     * Obtém o valor do campo semestre padrão selecionado
     * pelo usuário para a sessão, ou o valor
     * de um campo semestre (caso exista na página atual).
     */
    public static function getSemestrePadrao() {
      $semestre = "";
      if(post && p("semestre")!="") 
          $semestre = p("semestre");
      else $semestre=Session::get("semestre");

      if(empty($semestre)) {
          $semestre = Turma::getUltimoSemestre();
      }
      Session::set("semestre", $semestre);
      return $semestre;
    }

    public function getById($id){
          return TurmaDAO::getById($id);
    }

    /**
     * A partir do primeiro semestre de uma determinada
     * turma no curso, retorna a lista das turmas de todos os módulos
     * seguintes. Com isto, tem-se todas as turmas 
     * para fechar um ciclo do curso.
     * Por exemplo, se uma turma inicia o 1o módulo de um curso de 4
     * módulos, o método retornará as turmas para
     * representar estes 4 módulos deste ciclo.
     * @param string $semestre_inicio Semestre do 1o módulo do curso
     * para a turma da qual deseja-se obter a relação de semestres
     */
    public static function getListaModulosTurma($id_curso, $id_polo, $semestre_inicio) {
       return TurmaDAO::getListaModulosTurma($id_curso, $id_polo, $semestre_inicio);
    }
    
    public static function getSemestres() {
       return TurmaDAO::getSemestres();
    }

    public static function getUltimoSemestre() {
        return TurmaDAO::getUltimoSemestre();
    }

    public static function get($id_polo, $id_curso=0, $id_modulo=null, $semestre=null){
        return TurmaDAO::get($id_polo, $id_curso, $id_modulo, $semestre);
    }

    /**
     * Obtém a turma do 1o módulo de um determinado curso,
     * a partir do semestre indicado.
     */
    public static function getModulo1($id_polo, $id_curso, $semestre_inicio){
        return TurmaDAO::getModulo1($id_polo, $id_curso, $semestre_inicio);
    }
    
    public static function getDescriptionsById($id_turma){ 
       return TurmaDAO::getDescriptionsById($id_turma);
    }

    public static function all($semestre=null, $id_curso=0){
       return TurmaDAO::all($semestre, $id_curso);
    }
    
    public static function insertTurmas($semestre, $id_polos, $id_curso, $id_modulo) {
        return TurmaDAO::insertTurmas($semestre, $id_polos, $id_curso, $id_modulo);
    }

}
