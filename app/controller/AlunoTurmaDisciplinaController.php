<?php
/**
 * Sample framework controller
 * @package SampleApp
 * @subpackage Controller
 */
class AlunoTurmaDisciplinaController extends Controller{
    /**
    * Execute the action /aluno-turma-disciplina/index/
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
    if(Usuario::isTeacher() || (post && isset($o->id_curso) && $o->id_curso > 0)) {
       $this->modulos = ModuloCurso::getBySemestre(Turma::getSemestrePadrao(), $id_curso, Usuario::isTeacher());
    }
    
    if(post) {
      if(isset($o->id_modulo) && $o->id_modulo > 0) 
         $this->turma = Turma::get($o->id_polo, $id_curso, $o->id_modulo, $o->semestre);
      else return;
      
      if($this->turma && $this->turma->id > 0) 
         $this->disciplinas = DisciplinaTurma::getDisciplinasByTurma($this->turma->id, Usuario::isTeacher());
      else return;

      if(isset($o->id_disciplina) && $o->id_disciplina > 0) {
         $this->getDisciplina($o->id_disciplina);
         $this->alunos_turma = 
           AlunoTurmaDisciplina::getByDisciplina($this->turma->id, $o->id_disciplina);
      }
    } 
	}

  function getDisciplina($id_disciplina) {
      if(!($this->disciplina = Disciplina::getById($id_disciplina)))
         $this->disciplina = new Disciplina();
  }

	/**
  * Action para exibir as notas de disciplina para um determinado aluno
  */
	public function aluno(){
    $this->turma = Turma::getById(p("id_turma"));
    $this->getAlunosTurma($this->turma->id);

    if(post) {
      $o = Post::toObject();
      $o->id_aluno = (isset($o->id_aluno) ? $o->id_aluno : 0); 
      if($this->turma) {
     		$this->itens = AlunoTurmaDisciplina::getByTurma($o->id_aluno, $this->turma->id);
        return;
      }
    }

    $this->itens = array();
    $this->alunos_turma =  array();
	}


  private function getAlunosTurma($id_turma) {
    $this->alunos_turma = AlunoTurma::getByTurma($id_turma);
  }
	
	/**
	* Execute the action /exemplo/adicionar
	*
	* @return	void
	*/
	public function adicionar(){
		if (post)
		{
			$erros = array();

			$o = Post::toObject();

			if ($o->media_final == '') $erros['media_final'] = "Digite a média final da disciplina para o aluno";
			if ($o->id_disciplina == '') $erros['id_disciplina'] = "Escolha a disciplina";
			if (!count($erros))
			{
				$o->insert('id_turma, id_disciplina, id_aluno, media_final');
				Post::success("Item adicionado com sucesso!", new Link("aluno-turma-disciplina"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
    else  {
      $this->getDisciplinasTurma(p("id_turma"));
      $this->aluno = new Aluno(p("id_aluno"));
      $this->getTurma(p('id_turma'));
      $this->getAlunosTurma(p('id_turma')); 
    }
	}

	/**
	* Execute the action /exemplo/alterar/id:$id
	*
	* @param	int	$id
	* @return	void
	*/
	public function alterar(){
		$id = p("id");
		if (post)
		{
			$erros = array();

			$o = Post::toObject();
			
			if ($o->media_final == '') $erros['media_final'] = "Digite a média final da disciplina para o aluno";
			
			if (!count($erros))
			{
				$o->save('media_final', "aluno_turma_disciplina");
        if(Post::getVal("popup")!="")  {
            windowClose(true, "submit1");
        }
	      else Post::success("Item alterado com sucesso!", new Link("aluno-turma-disciplina"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
		
		Vortice::setVar('area', 'Alterar Item');
    //O Post::load é pra ser usado somente em requisições post.
    //Assim, usa-se Post::forceLoad, pois os dados da classe tem que
    //ser carregados (nesta ação de alterar) com GET (quando o usuário abre a página para edição) 
    //ou POST (quando ele altera e envia o form).
		Post::forceLoad(AlunoTurmaDisciplina::load($id));

    if(!post) {
			$id_turma = Post::getVal('id_turma');
      $this->getDisciplinasTurma($id_turma);
      $this->getTurma($id_turma);

      $this->getAluno(Post::getVal('id_aluno'));
    }
		$this->_view = "adicionar";
	}

  private function getDisciplinasTurma($id_turma) {
     $this->disciplinas = DisciplinaTurma::getDisciplinasByTurma($id_turma);
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
			Post::success("Item excluido com sucesso!", new Link("aluno-turma-disciplina"));
		} catch (Exception $e) {
			Post::error($e->getMessage());
		}
	}
}
