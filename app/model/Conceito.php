<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class Conceito extends DTO{
  const ID_APTO = 1;
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $descricao=''){
		if (isset($this->id)) return; // PDO BUG	
		$this->id 		= $id;
		$this->descricao 	= $descricao;
	}

	public static function get($id) {
		return ConceitoDAO::get($id);
	}
}
