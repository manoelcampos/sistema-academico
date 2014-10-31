<?php

/** sClasse cujos objetos são utilizados em campos
* que possuem apenas as opções Sim e Não. 
* O uso de uma classe para tais opções
* é feito para facilitar a criação
* de campos Sim/Não por meio de funções,
* sem ter que manualmente
* escrever código HTML para
* incluir, por exemplo, um select com
* estas opções.
* @package SistemaReservas
* @subpackage Model
*/
class SimNao extends DTO {
  /** Construtor padrão da classe
  */
	public function __construct($id=0, $descricao=''){
		if (isset($this->id)) return; // PDO BUG		
		$this->id = $id;
		$this->descricao = $descricao;
	}
	
  /** Obtém a lista de todos os objetos da classe
  * @return array<SimNao> Retorna a lista de objetos da classe
  */
	public static function all(){
		return SimNaoDAO::all();
	}		
}

?>
