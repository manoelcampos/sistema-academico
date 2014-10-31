<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class Config extends DTO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $assinatura1='', $assinatura2=''){
		if (isset($this->id)) return; // PDO BUG	
		$this->id 		= $id;
		$this->assinatura1 	= $assinatura1;
		$this->assinatura2 	= $assinatura2;
	}
        
    
    public static function get(){
        return ConfigDAO::get();
    }        
}
