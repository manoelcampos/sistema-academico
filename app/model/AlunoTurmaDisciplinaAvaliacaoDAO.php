<?php
/**
 * Sample of a framework data access object
 * @package SampleApp
 * @subpackage Model
 * @subpackage DTO
 */
class AlunoTurmaDisciplinaAvaliacaoDAO extends DAO {
	

	/**
	* Obtém a lista com as notas de uma avaliação dos alunos.
  * Mesmo os alunos que não tem nota na disciplina são retornados para que seja possível
  * atribuir uma nota a eles na respectiva página.
	*/
	public static function getByAvaliacao($id_avaliacao, $orderby="a.nome") {
		$sql = " SELECT atda.id, at.id_aluno, at.id_turma,  ".
           " dt.id_disciplina, a.matricula, " .
           " atda.nota, a.nome as aluno " .
           " FROM  aluno_turma at " .
           " inner join vwaluno a on a.id = at.id_aluno " .
           " inner join disciplina_turma dt on dt.id_turma = at.id_turma " .
           " inner join disciplina d on d.id = dt.id_disciplina " .
           " inner join avaliacao av on av.id_turma = dt.id_turma and av.id_disciplina = dt.id_disciplina " .
           " left outer join aluno_turma_disciplina_avaliacao atda ".
           " on atda.id_avaliacao = av.id and atda.id_aluno = a.id " .
           " where av.id = $id_avaliacao ".
           " order by $orderby; "; 
    //echo $sql;
		return Database::getInstance()->query($sql);
	}

  /*** Salva um conjunto de notas de alunos em uma avaliação de uma turma em uma determinada disciplina.
  * @param integer $id_avaliacao Id da avaliacao onde devem ser salvas as notas
  * @param integer $id_turma Id da turma onde devem ser salvas as notas
  * @param object $notas Objeto contendo as notas dos alunos de uma determinada turma em uma disciplina específica.
  * Tal objeto deve conter campos com nome no formato notaID_ALUNO,
  * onde ID_ALUNO é o valor do campo id_aluno que identifica de quem é a nota.
  * @return integer Retorna o número de registros afetados.
  */
  public static function salvarNotas($id_avaliacao, $id_turma, $notas) {
    $db = Database::getInstance();
    $aux = " select id_aluno from aluno_turma_disciplina_avaliacao atda " .
           " inner join avaliacao av on av.id = atda.id_avaliacao ".
           " where av.id = $id_avaliacao ";
    $alunosComNota = $db->query($aux);
    $sql = "";
    //percorre o vetor de objetos $alunosComNota para obter o id dos alunos que já possuem
    //uma nota, assim, será feito um update para atualizar tais notas
    foreach($alunosComNota as $a) {
      $campo = "nota$a->id_aluno";
      $nota = AlunoTurmaDisciplinaAvaliacao::validarNota($notas->$campo);
		  $sql .= " update aluno_turma_disciplina_avaliacao set nota = $nota ".
              " where id_aluno = $a->id_aluno and id_avaliacao = $id_avaliacao; \n";
    }
    unset($alunosComNota);
    $sql .= "\n";


    $aux = " select a.id_aluno from aluno_turma a where a.id_turma = $id_turma " .
           " and not exists(select atda.id_aluno from aluno_turma_disciplina_avaliacao atda " .
           " inner join avaliacao av on av.id = atda.id_avaliacao " .
           " where av.id = $id_avaliacao) ";
    $alunosSemNota = $db->query($aux);
    //percorre o vetor de objetos $alunosSemNota para obter o id dos alunos que NÃO possuem
    //uma nota, assim, será feito um INSERT para inserir as notas de tais alunos
    foreach($alunosSemNota as $a) {
      $campo = "nota$a->id_aluno";
      $nota = AlunoTurmaDisciplinaAvaliacao::validarNota($notas->$campo);
		  $sql .= " insert into aluno_turma_disciplina_avaliacao (id_aluno, id_avaliacao, nota)" .
              " values ($a->id_aluno, $id_avaliacao, $nota); \n";
    }
    unset($alunosSemNota);
    //echo str_replace("\n", "<br />", $sql);
		return $db->exec($sql);
  }
}
