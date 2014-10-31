<?php
/**
 * Sample framework controller
 * @package SampleApp
 * @subpackage Controller
 */
class AlunoTurmaDisciplinaAvaliacaoController extends Controller{
	/**
	* Execute the action /aluno-turma-disciplina-avaliacao/index/
	*
	* @return	void
	*/
	public function index(){
    $this->polos = Polo::all();
    //Se o usuário logado é professor, o ComboBox de cursos não aparece,
    //apenas o de módulos, já mostrando a sigla do curso
    if(!Usuario::isTeacher()) 
       $this->cursos = Curso::all();

    if(post) {
      $o=Post::toObject();
      $o->semestre = Turma::getSemestrePadrao();
    }
    $id_curso = (isset($o) && isset($o->id_curso) ? $o->id_curso : 0);

    //Se o usuário é professor, não existe o ComboBox curso, pois
    //os módulos são carregados mostrando a sigla do curso. Assim
    //não tem que filtrar a lista de módulos por um curso
    if(Usuario::isTeacher() || (post && isset($o->id_curso) && $o->id_curso > 0))
       $this->modulos = ModuloCurso::getBySemestre(Turma::getSemestrePadrao(), $id_curso, Usuario::isTeacher());       

    if(post) {
      if(isset($o->id_modulo) && $o->id_modulo > 0)
         if($this->turma = Turma::get($o->id_polo, $id_curso, $o->id_modulo, $o->semestre)) 
            $this->disciplinas = DisciplinaTurma::getDisciplinasByTurma($this->turma->id, Usuario::isTeacher());

      if(isset($o->id_disciplina) && $o->id_disciplina > 0) {
         $this->getDisciplina($o->id_disciplina);
         $this->avaliacoes = Avaliacao::getByDisciplina($this->turma->id, $o->id_disciplina);
      }

      if(isset($o->id_avaliacao) && $o->id_avaliacao>0)
         $this->getAlunosTurmaDisciplinaAvaliacao($o->id_avaliacao);


      //Quando o usuário clica no botão salvar, os dados enviados via post
      //são convertidos aqui no controller para um objeto contendo as
      //notas dos alunos. Tal objeto contém campos com nome no formato notaID_ALUNO,
      //onde ID_ALUNO é o valor do campo id_aluno que identifica de quem é a nota.
      if(p("salvar") && isset($o->id_avaliacao)) {
        AlunoTurmaDisciplinaAvaliacao::salvarNotas($o->id_avaliacao, $this->turma->id, $o);
        Post::success("Notas registradas com sucesso!", new Link("aluno-turma-disciplina-avaliacao"));
      }
    }
	}

  function getDisciplina($id_disciplina) {
      if(!($this->disciplina = Disciplina::getById($id_disciplina)))
         $this->disciplina = new Disciplina();
  }

  private function getAlunosTurmaDisciplinaAvaliacao($id_avaliacao) {
    $this->alunos_turma_disciplina_avaliacao = AlunoTurmaDisciplinaAvaliacao::getByAvaliacao($id_avaliacao);
  }

  private function getDisciplinasTurma($id_turma) {
     $this->disciplinas = DisciplinaTurma::getByTurma($id_turma);
  }

  private function getAluno($id_aluno) {
     $this->aluno = Aluno::get($id_aluno);
  }
  
  private function getTurma($id_turma) {
     $this->turma = Turma::getDescriptionsById($id_turma);
  }
	
	/**
	* Execute the action /exemplo/excluir/id:$id
	*
	* @param	int	$id
	* @return	void
	*/
	public function excluir(){
		$o = Post::toObject();
		try {
      if(!isset($o->id) || $o->id == 0)
         $o->id = p("id");

			$o->delete();
			Post::success("Item excluido com sucesso!", new Link("aluno-turma-disciplina-avaliacao"));
		} catch (Exception $e) {
			Post::error($e->getMessage());
		}
	}
}
