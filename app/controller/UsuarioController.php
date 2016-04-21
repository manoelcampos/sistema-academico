<?php
class UsuarioController extends Controller{

  /** Carrega os dados auxiliares que serão disponibilizados às views
  * para montagem da interface gráfica.
  * Cada propriedade do controller setada é
  * disponibilizada como uma variável global 
  * (com o mesmo nome) para as views.
  * @package AcademicoEad
  * @subpackage Controller
  */
  private function loadTables() {
    /*O método all um método 
    da classe base de uma classe model ou DAO.
    Assim, os mesmos só precisam ser reescritos
    se desejar-se mudar, por exemplo,
    a ordem em que os dados são retornados*/
    $this->simNao = SimNao::all();  
  }

  /** Valida os campos do formulário, verificando,
  * por exemplo, quais campos obrigatórios não foram preenchidos.
  * @param Usuario $o Objeto contendo os dados a serem validados  
  * @return boolean Retorna true se nenhum erro ocorreu e false caso contário
  */
  private function validar($o) {
     //indica se o usuário está fazendo uma inclusão
     $inclusao = strstr(Vortice::getView(), "/adicionar")!=null;
 		 $erros = array();
	   if ($o->nome == '') $erros[] = "Digite o nome";
	   if ($o->email == '')   $erros[] = "Digite o e-mail";
	   if ($inclusao && $o->senha == '') $erros[] = "Digite a senha";
   
		 if (count($erros)) {
			 Post::error("Ocorreram os seguintes erros:", $erros);  
			 return false;
		 }
		 return true;
  } 

  /** Action executada quando a view index é chamada*/
  public function index() {
     /*O método all um método 
     da classe base de uma classe model ou DAO.
     Assim, os mesmos só precisam ser reescritos
     se desejar-se mudar, por exemplo,
     a ordem em que os dados são retornados*/
     $class = static::getModelClass();
     $this->itens = $class::all(p("tipo"), p("login_ativo"));
  }


  /** Action executada quando a view adicionar é chamada
  * para incluir um novo registro*/  
  public function adicionar() {
 		 /*Converte os dados enviados por post
 		 para um objeto da classe modelo
 		 correspondente ao controller atual.*/
		 $o = Post::toObject();
		   
		 //Se a requisição foi enviada pela método HTTP POST
     if(post) {
			 if ($this->validar($o))
			 {
			   $o->criptografaSenha();
			   //lista de campos que serão incluídos na instrução sql INSERT
				 $o->insert('nome, email, senha, login_ativo');
				 //Mostra uma mensagem e redireciona
				 Post::success("Item adicionado com sucesso!", new Link(getIndexView()));
			 }
 			 
     }
     else $this->loadTables();
  }

  /** Action executada quando a view adicionar é chamada
  * para alterar um registro.
  * Não há uma view específica para alteração, justamente
  * porque a interface é a mesma da exclusão.*/    
  public function alterar() {
     /*pega o valor do campo id recebido por parâmetro na view
     adicionar (que também é usada para alterar registros)*/
     $id = p("id");
 		 /*Converte os dados enviados por post
 		 para um objeto da classe modelo
 		 correspondente ao controller atual.*/ 		 
		 $o = Post::toObject();
  
 		 //Se a requisição foi enviada pela método HTTP POST
     if(post) {
	 		 if($this->validar($o)) {
			    //lista de campos que serão incluídos na instrução sql UPDATE	 		 
	 		    $campos = 'nome, email, login_ativo';
	 		    if ($o->senha != '') {
	 		       $campos .= ', senha';
	 		       $o->criptografaSenha();
	 		    }
		 		  $o->save($campos);

          $link = new Link(getIndexView());

 				  //Mostra uma mensagem e redireciona		 	
   			 	Post::success("Item alterado com sucesso!", $link);
			 }
     }
     else $this->loadTables();

 		 Vortice::setVar('area', 'Alterar Item');
 		 /*Obtém a classe model correspondente ao controller
 		 para assim chamar seu método load
 		 que carrega os dados a partir do banco de dados.
 		 O método load retorna um objeto da classe modelo
 		 correspondente ao controller atual.
 		 Usando o método forceLoad da classe Post,
 		 os dados do objeto retornando
 		 são carregados para poderem ser usados na view adicionar
 		 para preencher os campos do form quando
 		 o usuário solicitar uma alteração de um registro.*/
 		 $class = static::getModelClass();
		 Post::forceLoad($class::load($id));
		 
		 //Como não existe uma view "editar", indica que a action "editar" usa a view "adicionar"
		 $this->_view = "adicionar";  
  }  
  
	/** Action executada quando o usuário solicita uma exclusão.
	* Neste caso, não há uma view específica para exclusão.
	* A interface para exclusão é criada pela framework.
	*/
	public function excluir(){
 		 $o = Post::toObject();
		 try {
       if(!isset($o->id) || $o->id == 0)
          $o->id = p("id");
			 $o->delete();
			 Post::success("Item excluido com sucesso!", new Link(getIndexView()));
		 } catch (Exception $e) {
			 Post::error($e->getMessage());
	 	 }
	}  


  public function logout() {
    Session::clear();
    redirect(new Link("/usuario/login"));
  }

	public function login(){
		// se um formulario foi postado
		if (post){
			// pega as variáveis do post
			$matricula = addslashes(p('matricula'));
			$senha = p('senha');

      $erros = array();
			if ($matricula == '') $erros[] = "Digite a matrícula";
			if ($senha == '') $erros[] = "Digite a senha";
			if (count($erros))
 				 Post::error("Ocorreram os seguintes erros:", $erros);

      $senha=md5($senha);
			// seleciona o usuario, armazena na variavel $u
			// e ainda verifica se o usuario existe
			if ($u = UsuarioDAO::getByMatricula($matricula)){
				// verifica se a senha digitada combina com a que está no BD
				if ($u->senha == $senha){
				  if (!$u->login_ativo){
             Post::error("O usuário indicado não está habilitado a acessar o sistema!");
             return; 
          }

					// remove a senha do objeto
					$u->senha = null;
					// grava a session
					Session::set("u", $u);
					// Cria mensagem de sucesso e redireciona para o index
          $url = str_replace(MasterController::actionSeparator, "/", p("url"));
					Post::success("Olá {$u->nome}, você está logado(a)", new Link($url));
				} else Post::error("Senha incorreta!");
			} else Post::error("Matrícula não encontrada!");
		}
	}
}
?>
