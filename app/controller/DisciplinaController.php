<?php
/**
 * @package AcademicoEad
 * @subpackage Controller
 */
class DisciplinaController extends Controller{

	/**
	* Execute the action /exemplo
	*
	* @return	void
	*/
	public function index(){
	  if(post)
   	  $this->itens = Disciplina::getByCurso(Post::getVal("id_curso"));
   	else $this->itens = array();
		$this->loadTables();
	}
	
	private function loadTables($loadModulos=false) {
   	$this->cursos = Curso::all();
   	if($loadModulos) 
   	  $this->loadModulos();
	}
	
	private function loadModulos() {
	  $this->curso = Curso::get(p("id_curso"));
    $this->modulos = ModuloCurso::getByCurso(p("id_curso"));	
	}
	
	/**
	* Execute the action /exemplo/adicionar
	*
	* @return	void
	*/
	public function adicionar(){
	  $this->loadTables(true);
		if (post) {
			$erros = array();

			$o = Post::toObject();
			$o->id_curso = p("id_curso");

			if ($o->descricao == '') $erros['descricao'] = "Digite a descrição da disciplina";
			if (!count($erros))
			{
				$o->insert('id_curso, descricao, sigla, id_modulo, carga_horaria');
        if(p("popup")) 
            windowClose(true);
				else Post::success("Item adicionado com sucesso!", new Link("disciplina"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
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
		$this->loadTables(true);
		if (post) {
			$erros = array();

			$o = Post::toObject();
			
			if ($o->descricao == '') $erros['descricao'] = "Digite a descrição da disciplina";
			
			if (!count($erros))
			{
				$o->save('descricao, sigla, id_modulo, carga_horaria');
        if(p("popup")) 
            windowClose(true);
				else Post::success("Item alterado com sucesso!", new Link("disciplina"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
		
		Vortice::setVar('area', 'Alterar Item');
		Post::forceLoad(Disciplina::load($id));
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
			Post::success("Item excluido com sucesso!", new Link("disciplina"));
		} catch (Exception $e) {
			Post::error($e->getMessage());
		}
	}
}
