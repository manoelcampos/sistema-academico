<?php
/**
 * 
 * @package AcademicoEad
 * @subpackage Controller
 */
class ModuloController extends Controller{

	/**
	* Execute the action /exemplo
	*
	* @return	void
	*/
	public function index(){
		$this->itens = ModuloCurso::all();
	}
	
	private function loadCursos() {
   		$this->cursos = Curso::all();
	}
	
	/**
	* Execute the action /exemplo/adicionar
	*
	* @return	void
	*/
	public function adicionar(){
    		$this->loadCursos();	  
		if (post)
		{
			$erros = array();

			$o = Post::toObject();

			if ($o->descricao == '') $erros[] = "Digite a descrição do módulo";
			if ($o->ordem == '') $erros[] = "Digite a ordem do módulo";
			if (!count($erros))
			{
				$o->insert('id_curso, descricao, qualificacao, ordem', 'modulo_curso');
				Post::success("Item adicionado com sucesso!", new Link("modulo"));
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
	  $this->loadCursos();
		$id = p("id");
		if (post)
		{
			$erros = array();
			$o = Post::toObject();
			
			if ($o->descricao == '') $erros[] = "Digite a descrição do módulo";
			if ($o->ordem == '') $erros[] = "Digite a ordem do módulo";
			
			if (!count($erros))
			{
				$o->save('id_curso, descricao, qualificacao, ordem', 'modulo_curso');
				Post::success("Item alterado com sucesso!", new Link("modulo"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
		
		Vortice::setVar('area', 'Alterar Item');
		Post::load(ModuloCurso::load($id));
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
			Post::success("Item excluido com sucesso!", new Link("modulo"));
		} catch (Exception $e) {
			Post::error($e->getMessage());
		}
	}
}
