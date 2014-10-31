<?php
/**
 * Sample of a framework data object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class Frequencia extends DTO{
	/**
	* Contruct a Exemplo object
	*
	* @return	void
	*/
	public function __construct($id=0, $id_dia_letivo=0, $id_aluno=0, $aula1=0, $aula2=0, $aula3=0, $aula4=0){
		if (isset($this->id)) return; // PDO BUG	
    $this->id=$id;
    $this->id_dia_letivo=$id_dia_letivo;
    $this->id_aluno=$id_aluno;
    $this->aula1=$aula;
    $this->aula2=$aula;
    $this->aula3=$aula;
    $this->aula4=$aula;
  }
  
  /***Verifica se existe registro de frequência para um determinado aluno em determinada data
  * @param int $id_dia_letivo Id da data letiva onde deve ser atualizada a frequência
  * @param int $id_aluno Id do aluno
  * @return boolean Retorna true caso exista registro de frequência para o aluno na data indicada
  * e false caso contrário.
  */
	public static function frequenciaExists($id_dia_letivo, $id_aluno) {
	  return FrequenciaDAO::frequenciaExists($id_dia_letivo, $id_aluno);
	}
  
  /***Atualize registro de frequência para um aluno em uma determinada data letiva
  * @param int $id_dia_letivo Id da data letiva onde deve ser atualizada a frequência
  * @param int $id_aluno Id do aluno
  * @param array<int> $presencas Vetor de inteiros contendo a frequência do aluno
  * nas aulas da data letiva informada. A quantidade de elementos do vetor
  * indica a quantidade de aulas existentes no dia. O valor zero em cada posição
  * indica falta na aula (assim 0 na primeira posição indica que o aluno faltou a primeira aula do dia)
  * e 1 indica presença.
  * @return boolean Retorna true se o registro foi atualizado com sucesso.
  */
	public static function updateFrequencia($id_dia_letivo, $id_aluno, $presencas){
	  return FrequenciaDAO::updateFrequencia($id_dia_letivo, $id_aluno, $presencas);
	}  
	
	/***Atualiza os registros de frequência de vários alunos em uma determinada data letiva.
	* Se um determinado aluno não possui registro de frequência para a data informada,
	* o registro é incluído.
  * @param int $id_dia_letivo Id da data letiva onde deve ser registrada a frequência
  * @param array<Object> Array contendo objetos que representem o aluno e sua frequência,
  * devendo cada objeto destes possuir os campos id_aluno (int) e presencas (array<int>).
  * Este campo presencas deve ser um vetor de inteiros contendo a frequência do aluno
  * nas aulas da data letiva informada. A quantidade de elementos do vetor
  * indica a quantidade de aulas existentes no dia. O valor zero em cada posição
  * indica falta na aula (assim 0 na primeira posição indica que o aluno faltou a primeira aula do dia)
  * e 1 indica presença.
	* @see updateFrequencia
	*/
	public static function batchUpdateFrequencia($id_dia_letivo, $presencas_alunos){
  	  FrequenciaDAO::batchUpdateFrequencia($id_dia_letivo, $presencas_alunos);
	}	
	

  /***Insere registro de frequência para um aluno em uma determinada data letiva
  * @param int $id_dia_letivo Id da data letiva onde deve ser registrada a frequência
  * @param int $id_aluno Id do aluno
  * @param array<int> $presencas Vetor de inteiros contendo a frequência do aluno
  * nas aulas da data letiva informada. A quantidade de elementos do vetor
  * indica a quantidade de aulas existentes no dia. O valor zero em cada posição
  * indica falta na aula (assim 0 na primeira posição indica que o aluno faltou a primeira aula do dia)
  * e 1 indica presença.
  * @return int Retorna o código autoincremento gerado para o registro inserido
  */
	public static function insertFrequencia($id_dia_letivo, $id_aluno, $presencas){
	  return FrequenciaDAO::insertFrequencia($id_dia_letivo, $id_aluno, $presencas);
	}
	
	/***Insere registros de frequência de vários alunos em uma determinada data letiva.
  * @param int $id_dia_letivo Id da data letiva onde deve ser registrada a frequência
  * @param array<Object> Array contendo objetos que representem o aluno e sua frequência,
  * devendo cada objeto destes possuir os campos id_aluno (int) e presencas (array<int>).
  * Este campo presencas deve ser um vetor de inteiros contendo a frequência do aluno
  * nas aulas da data letiva informada. A quantidade de elementos do vetor
  * indica a quantidade de aulas existentes no dia. O valor zero em cada posição
  * indica falta na aula (assim 0 na primeira posição indica que o aluno faltou a primeira aula do dia)
  * e 1 indica presença.
	* @see insertFrequencia
	*/
	public static function batchInsertFrequencia($id_dia_letivo, $presencas_alunos){
  	  FrequenciaDAO::batchInsertFrequencia($id_dia_letivo, $presencas_alunos);
	}	
	
	/**Obtém a lista de frequência dos alunos para uma determinada data letiva.
	* @param int $id_dia_letivo Id do dia letivo (data letiva) para serem
	* retornadas as presenças dos alunos 
	* @return array<Frequencia> Retorna um array associativo de objetos Frequencia
	* onde o índice do mesmo é o id_aluno. Assim, para obter a frequência do dia
	* para um determinado aluno, basta acessar o array utilizando o id_aluno como índice.*/
	public static function getByDiaLetivo($id_dia_letivo) {
	    return FrequenciaDAO::getByDiaLetivo($id_dia_letivo);
  }	
}
