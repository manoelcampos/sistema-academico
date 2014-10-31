<?php

class Usuario extends DTO{
	public function __construct($id=0, $nome='', $email='', $senha='', $ativo = 1){
		if (isset($this->id)) return; // PDO BUG			
		$this->id = $id;
		$this->nome = $nome;
		$this->email = $email;
		$this->senha = $senha;
		$this->ativo = $ativo;
	}
	
	/** Criptografa a senha do usuário
	*/
	public function criptografaSenha() {
	   if($this->senha != "")
   	   $this->senha = sha1($this->senha);
	}

  
  /**Registra a data/hora do acesso do usuário ao sistema.
  * @param int $id Id do usuário cujo registro será feito.
  * Se omitido, é usado o atributo id no lugar
  */
  public static function registraDataHoraAcesso ($id=0) {
     return UsuarioDAO::registraDataHoraAcesso($id);
  }


  /***Verifica se o usuário logado é uum professor
  * @return integer Se o usuário logado for professor, retorna o código do mesmo,
  * senão, retorna 0
  */
  static public function isTeacher() {
    if (Session::get("u")->tipo=="P")
      return Session::get("u")->id;
    else return 0;
  }

  /***Se o usuário está vinculado a algum curso (como no caso do coordenador de curso)
  * ele só pode ver os dados do curso ao qual ele está vinculado.
  * Assim, tal função retorna um filtro para ser incluído no
  * where das SQL's que buscarem dados relacionados a um curso.
  * @param $idCursoFieldName Nome do campo na tabela que contém o id do curso
  * @return Retorna o filtro SQL para o curso do usuário ou uma string vazia
  * caso o mesmo não esteja vinculado a um curso.
  */  
  static public function filtroCursoUsuario($idCursoFieldName) {
    if(!empty(Session::get("u")->id_curso))
      return " and ($idCursoFieldName = ".Session::get("u")->id_curso . ") ";
    return "";
  }

  public static function all($tipo="", $status="") {
     return UsuarioDAO::all($tipo, $status); 
  }
}

?>
