<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class RegimeCurso extends DTO{
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
}
