<?php

//Link que dá acesso à página de alteração do usuário logado
//Usuários comuns só tem acesso à esta página do model Usuario
define("LINK_ALTERAR_USUARIO", "usuario/alterar/id:".Session::get("u")->id."/");

/***Classe que realiza o controle de acesso às páginas (view)
* de acordo com o tipo do usuário logado.
* Aqui são registradas as páginas que cada tipo de usuário pode acessar.
*/
class AccessControl{
  //As páginas que não tem um nome de chave (que representa o título da página)
  //é porque existe uma rota (alias) para a mesma.  
  //Funcionário que esteja vinculado a um determinado curso
  //é categorizado como C (Coordenador de curso),
  //senão, será F (Funcionário comum)
  /***Array contendo a lista de páginas que podem ser acessadas por cada tipo de usuário.
  */
  private static $pages = array(
      //Páginas de acesso dos funcionários
      'F' => array(
             'Usuários'=>'usuario',
             'Pólo'=>'polo', 'Curso'=>'curso', 'Área Profissional'=>'area-profissional', 
             'Módulo'=>'modulo', 'Disciplina'=>'disciplina', 'Turma'=>'turma', 'Aluno'=>'aluno', 
             'Cadastro de Avaliações' => 'avaliacao', 'aluno-turma-disciplina', 'aluno-turma-disciplina-avaliacao', 
             'Notas por Avaliação'=>'aluno-turma-disciplina-avaliacao', 
             'Resultado por Disciplina'=>'aluno-turma-disciplina', 'Presenças e Conteúdo'=>'dia-letivo'),
      //Páginas de acesso dos coordenadores de curso
      'C' => array(
             'Curso'=>'curso/index', 
             'Módulo'=>'modulo/index', 'Disciplina'=>'disciplina', 'Turma'=>'turma', 'Aluno'=>'aluno/index', 
             'Cadastro de Avaliações' => 'avaliacao', 'aluno-turma-disciplina', 
             'aluno-turma-disciplina-avaliacao', 'Notas por Avaliação'=>'aluno-turma-disciplina-avaliacao', 
             'Resultado por Disciplina'=>'aluno-turma-disciplina', 'Presenças e Conteúdo'=>'dia-letivo',
             LINK_ALTERAR_USUARIO),
      //Páginas de acesso dos professores
      'P' => array('Cadastro de Avaliações' => 'avaliacao', 'aluno-turma-disciplina', 'aluno-turma-disciplina-avaliacao', 
             'Notas por Avaliação'=>'aluno-turma-disciplina-avaliacao', 
             'Resultado por Disciplina'=>'aluno-turma-disciplina', 'Presenças e Conteúdo'=>'dia-letivo',
             LINK_ALTERAR_USUARIO),
      //Páginas de acesso dos alunos
      'A' => array(
             LINK_ALTERAR_USUARIO
             )
   );

  /***
  * Obtém a lista de páginas que um usuário de um determinado tipo tem acesso.
  * @param char $tipoUsuario Tipo do usuário logado no sistema (A - Aluno, F - Funcionário, P - Professor)
  * @return array Retorna um array associativo com a lista de páginas permitidas, onde
  * o valor de cada item é o nome das páginas (views) e a chave é o título das páginas.
  */
  public static function getPages($tipoUsuario) {
     return static::$pages[$tipoUsuario];
  }

  /** Verifica se o usuário tem acesso a view atual
  * ou a uma view específica
  * @param string $view Se for informada o endereço de uma view, verifica se o usuário
  * tem acesso a mesma. Caso não seja informado nada, verifica se o usuário
  * tem acesso à view atual.
  * @return boolean Retorna true se o usuário tem acesso à view, ou false caso contrário.
  */
  public static function valid($view=null) {
      /*Se não foi passado um nome de view, 
      é porque é pra verificar se o usuário tem acesso à view atual.*/
      if(!$view) {          
        $view = $_SERVER["REQUEST_URI"];

        /*Se estiver na view index mas a URI não incluir
        a action index, troca o nome da view sem a action index
        pelo seu próprio nome seguida da action index.
        Isto é necessário porque, se foi definido
        que o usuário só pode ter acesso à view index,
        a palavra index tem que constar na url*/
        if(action=="index" && !strstr($view, action))
            $view = str_replace($view, getIndexView(), Vortice::getView());
      }
      //echo "$view<br/>";
      //se tem uma barra no nome da view, então remove o nome da action da view, para pegar apenas o nome da página
      //if(strstr($view, "/"))
        // $view = substr($view, 0, strlen($view)-strlen(action)-1);
         
      $view = "/".str_replace(":", "/", $view);
      if($u = Session::get("u")) {
         /* 
         $pages = implode ('; ', static::$pages[$u->tipo]);
         echo "<b>tipo usuario:</b> $u->tipo<br/><b>pages:</b> $pages<br/><b>view:</b> $view<br/><b>action:</b> ". action."<br/><br/>";
         */
         $barra = "/";
         foreach(static::$pages[$u->tipo] as $page) {
           if(!endsWith($view, $barra))
              $view .= $barra;

           if(!endsWith($page, $barra))
              $page .= $barra;

           if($page != "" && substr($page, 1, 1)!=$barra)
              $page = $barra.$page;
           $page = str_replace(":", "/", $page);
           //echo "v $view - p $page<br/>"; 
           if(strstr($view, $page)) {
              return true;
           }
         }
      }

      return false;
  }
}

?>
