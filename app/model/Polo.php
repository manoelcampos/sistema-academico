<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class Polo extends DTO{
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
    return PoloDAO::get($id);
  }
}
