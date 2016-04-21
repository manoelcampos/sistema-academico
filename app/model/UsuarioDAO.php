<?php

/**
 * @package AcademicoEad
 * @subpackage model
*/
class UsuarioDAO extends DAO{
	public static function getByMatricula($matricula){
	  //Como o usuário pode ter um login de professor e um de funcionário,
	  //um dos dois pode estar inativo. Assim, ordena em ordem descrescente
	  //pelo campo ativo para trazer o registro que estiver ativo
		$sql = "SELECT * FROM vwusuario WHERE matricula='$matricula' order by login_ativo desc";
		return Database::getInstance()->queryOne($sql);
	}

	/** Obtém a lista dos usuários cadastrados
	* @return array<Usuario> Retorna um vetor de todos os usuários cadastrados.
	*/
  public static function all($tipo="", $status="") {
    $sql =  " select * from vwusuario where 1=1 ";
    if($tipo != "")
       $sql .= " and tipo='$tipo'";
    if($status != "")
       $sql .= " and login_ativo=$status";

    $sql .= " order by nome, login_ativo desc ";
    return Database::getInstance()->query($sql);
  }	

  public static function get($id) {
    $sql = " select * from vwusuario ".
           " where id=$id ";
    return Database::getInstance()->queryOne($sql);
  }

  public static function registraDataHoraAcesso ($id=0) {
     if($id == 0)
       $id = $this->id;
     $sql = "update pessoa set ultimo_acesso = current_timestamp where id = $id;";
     return Database::getInstance()->exec($sql);
  }
}
?>
