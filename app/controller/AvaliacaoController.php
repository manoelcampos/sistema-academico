<?php
/**
 * Sample framework controller
 * @package SampleApp
 * @subpackage Controller
 */
class AvaliacaoController extends Controller{
  private function loadTables() {
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
      if(isset($o->id_modulo) && $o->id_modulo > 0) { 
        if($this->turma = Turma::get($o->id_polo, $id_curso, $o->id_modulo, $o->semestre))
          $this->disciplinas = DisciplinaTurma::getDisciplinasByTurma($this->turma->id, Usuario::isTeacher());
      }
    }
  }

  public function index() {
    $this->loadTables();
    if(post) {
      $o=Post::toObject();
      if(isset($o->id_disciplina) && $o->id_disciplina > 0) 
         $this->itens = Avaliacao::getByDisciplina($this->turma->id, $o->id_disciplina);
    } 
  }

	public function adicionar(){
    $this->turma = Turma::getById(p("id_turma"));
    $this->disciplina = Disciplina::getById(p("id_disciplina"));

		if (post)
		{
			$erros = array();

			$o = Post::toObject();

			if ($o->descricao == '') $erros[] = "Digite a descrição do item";
			if (!count($erros))
			{
				$o->insert('id_turma, id_disciplina, descricao');
        if(p("popup")) 
            windowClose(true);
				else Post::success("Item adicionado com sucesso!", new Link("avaliacao"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
	}

	public function alterar(){
		$id = p("id");
		if (post)
		{
			$erros = array();

			$o = Post::toObject();
			
			if ($o->descricao == '') $erros[] = "Digite a descrição do item";
			
			if (!count($erros))
			{
				$o->save('descricao');
        if(p("popup")) 
            windowClose(true);
				else Post::success("Item alterado com sucesso!", new Link("avaliacao"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
		
		Vortice::setVar('area', 'Alterar Item');
		Post::forceLoad(Avaliacao::load($id));

    $this->turma = Turma::getById(Post::getVal("id_turma"));
    $this->disciplina = Disciplina::getById(Post::getVal("id_disciplina"));

		$this->_view = "adicionar";	
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
			Post::success("Item excluido com sucesso!", new Link("avaliacao"));
		} catch (Exception $e) {
			Post::error($e->getMessage());
		}
	}
}
