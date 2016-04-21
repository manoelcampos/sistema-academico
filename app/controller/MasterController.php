<?php
/**
 * Sample of a framework template controller
 * @package SampleApp
 * @subpackage Controller
 */
class MasterController{
	/** 
  * Quando o usuário tenta acessa uma página do sistema, antes de logar,
  * ele é redirecionado para a página de login, a qual recebe por parâmetro,
  * a página que o usuário estava tentando acessar.
  * Como a URL da página (view) pode conter barras (/),
  * a passagem de um parâmetro com barra causa erro no Vortice (pois barra separa as páginas e actions das mesmas).
  * Assim, antes de passar o parâmetro, troca-se a barra pela string definida aqui.
  * Quando o usuário loga no sistema, ele é redirecionado para a página que estava tentando
  * acessar antes de ter logado, e então a barra é incluída de volta na URL da página.
  */
  const actionSeparator = ".";

  const displayDateFormat = "d/m/Y";
	
	/**
	* Front controller.... everytime executed
	*
	* @return	void
	*/
	function __construct(){
		Vortice::setVar('title', "Sistema Acadêmico EaD");
		// se a variável de session "u" não existir, criar uma com um usuario vazio
		if (!Session::get("u")) 
			Session::set("u", new Usuario());
		$view = Vortice::getView();
		// Se a session u tiver um objeto vazio..
		// e o controller/action forem diferentes dos de login
		if (Session::get("u")->id == 0 && controller != 'usuario' && action != 'login'){
		  $url = "";
		  if($view != "index/index")
		     $url = "url=".str_replace("/", static::actionSeparator, $view); 
		  // redireciona para a tela de login
		  redirect(new Link("usuario:login", $url));
		  return;
		}

		if($view != 'index/index' && $view != 'usuario/login' && $view != 'usuario/logout') {
			if(!AccessControl::valid()) {
				 Post::success("Você não tem permissão para acessar a página ".Vortice::getView(), new Link("index:index"));
				 return;
			}
		}

		$isDevMode = (!isset($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST'] == 'localhost');
		//Database::getInstance()->init("10.211.55.2", "academicoeaduser", "DEXLyzcjbLZLSfqn", "academicoead");
		//Database::getInstance()->init("10.211.55.2", "root", "root", "academicoead");
		Database::getInstance()->init("127.0.0.1", "root", "root", "academicoead");
		// if you want to conect in another Database...
		//Database::getInstance('another_one')->init("database2_ip", "database2_user", "database2_pass", "database2_name", BD_PGSQL);
		Post::autoRender();
		//Vortice::setClean(); // Clean the whitespaces before sending the page.. 
	}
}
