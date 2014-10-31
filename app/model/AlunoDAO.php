<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class AlunoDAO extends DAO {
	
	/**
	* Select a object in the database
	*
	* @param	Exemplo	$dto	Record object
	* @return	Exemplo
	*/
    public static function get($id){
		$sql = 
		 " SELECT a.*, p.nome, p.identidade, p.orgao_expedidor_rg,
		 p.data_expedicao_rg, p.nome_mae, p.nome_pai,
		 p.cpf, p.data_nascimento,
		 nac.descricao as nacionalidade, 
		 nat.descricao as naturalidade, enat.uf as uf_naturalidade 
		 FROM pessoa p inner join aluno a
		 on a.id_pessoa = p.id
		 left join nacionalidade nac on nac.id = p.id_nacionalidade 
		 left outer join cidade nat on nat.id = p.id_naturalidade 
		 left outer join estado enat on enat.id = nat.id_estado 
		 WHERE a.id=$id";
		return Database::getInstance()->queryOne($sql);
	}

  public static function all() {
		$sql = "SELECT * FROM vwaluno order by nome";
		return Database::getInstance()->query($sql);
  }


	/**
	* Busca um aluno a partir do nome, não necessitando informar o nome completo.
	*
	* @param	string	$nome	Nome do aluno a ser procurado. Pode ser um nome parcial.
  * Se o nome de um aluno for Manoel Campos da Silva Filho, pode-se informar o nome completo,
  * apenas Manoel Campos, Manoel Filho e outras variações que a função localizará o aluno.
	* @return	Retorna um array contendo objetos Aluno
	*/  
  public static function getByNome($nome) {
    $nome = str_replace(" ", "%", $nome);
		$sql = "SELECT * FROM vwaluno where nome like '$nome%' order by nome";
    //echo $sql;
		return Database::getInstance()->query($sql);
  }
}
