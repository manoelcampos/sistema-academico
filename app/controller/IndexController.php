<?php
/**
 * @package AcademicoEad
 * @subpackage Controller
 */
class IndexController{

	/**
	* Execute the action: /index/index or just /
	*
	* @return	void
	*/
	public function index(){
		Vortice::setVar('area', 'Selecione uma Opção');
		Vortice::setVar('desc', '');
    if(post && p("semestre")) {
      Turma::getSemestrePadrao();
      redirect(new Link(p("url")));
    }
	}
}
