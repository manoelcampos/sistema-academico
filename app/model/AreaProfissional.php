<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class AreaProfissional extends DTO{
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

  public function get($id) {
    return AreaProfissionalDAO::get($id);
  }

}
