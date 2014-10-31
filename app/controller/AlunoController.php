<?php
/**
 * Sample framework controller
 * @package SampleApp
 * @subpackage Controller
 */
class AlunoController extends Controller{

	/**
	* Execute the action /exemplo
	*
	* @return	void
	*/
	public function index(){
		$this->itens = Aluno::all();
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

			if ($o->nome == '') $erros['nome'] = "Digite o nome do aluno";
			if (!count($erros))
			{
				$o->insert('nome');
				Post::success("Item adicionado com sucesso!", new Link("aluno"));
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
		if (post)
		{
			$erros = array();

			$o = Post::toObject();
			
			if ($o->nome == '') $erros['nome'] = "Digite o nome do aluno";
			
			if (!count($erros))
			{
				$o->save('nome');
				Post::success("Item alterado com sucesso!", new Link("aluno"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
		
		Vortice::setVar('area', 'Alterar Item');
		Post::load(Aluno::load($id));
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
			Post::success("Item excluido com sucesso!", new Link("aluno"));
		} catch (Exception $e) {
			Post::error($e->getMessage());
		}
	}
}
