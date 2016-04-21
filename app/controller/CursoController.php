<?php
/**
 * Sample framework controller
 * @package AcademicoEad
 * @subpackage Controller
 */
class CursoController extends Controller{

	/**
	* Execute the action /exemplo
	*
	* @return	void
	*/
	public function index(){
		$this->itens = Curso::all();
	}

  /**Carrega as tabelas auxiliares como um vetor de objetos em atributos
  da classe, para tais vetores serem utilizados na view para exibir um ComboBox
  com os dados de tais tabelas.*/
  private function loadTables() {
     $this->areas = AreaProfissional::all();
     $this->regimes = RegimeCurso::all();
     $this->niveis = NivelCurso::all();
  }
	
	/**
	* Execute the action /exemplo/adicionar
	*
	* @return	void
	*/
	public function adicionar(){
		if (post) {
			$erros = array();

			$o = Post::toObject();

			if ($o->descricao == '') $erros[] = "Digite a descrição do curso";
      if ($o->id_area_profissional == '') $erros[] = "Escolha a área profissional do curso";
      if ($o->id_regime_curso == '') $erros[] = "Escolha o regime do curso";
      if ($o->id_nivel_curso == '') $erros[] = "Escolha o nível do curso";
			if (!count($erros))
			{
				$o->insert('descricao, id_area_profissional, id_regime_curso, id_nivel_curso, perfil');
				Post::success("Item adicionado com sucesso!", new Link("curso"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
    else $this->loadTables();
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
			
			if ($o->descricao == '') $erros[] = "Digite a descrição do curso";
      if ($o->id_area_profissional == '') $erros[] = "Escolha a área profissional do curso";
      if ($o->id_regime_curso == '') $erros[] = "Escolha o regime do curso";
      if ($o->id_nivel_curso == '') $erros[] = "Escolha o nível do curso";
			
			if (!count($erros))
			{
				$o->save('descricao, id_area_profissional, id_regime_curso, id_nivel_curso, perfil');
				Post::success("Item alterado com sucesso!", new Link("curso"));
			}
			else
				Post::error("Ocorreram os seguintes erros:", $erros);
		}
    else $this->loadTables();
		
		Vortice::setVar('area', 'Alterar Item');
		Post::forceLoad(Curso::load($id));
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
			Post::success("Item excluido com sucesso!", new Link("curso"));
		} catch (Exception $e) {
			Post::error($e->getMessage());
		}
	}
}
