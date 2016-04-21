<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class AvaliacaoDAO extends DAO {

	public function getByDisciplina($id_turma, $id_disciplina){
		$sql = " SELECT id, id_turma, id_disciplina, descricao ".
           " from avaliacao where id_turma = $id_turma and id_disciplina = $id_disciplina order by id ";
		return Database::getInstance()->query($sql);
  }

  /*public static function getByTurma($id_turma, $id_disciplina) { 
		$sql = " SELECT av.id, av.id_turma, av.id_disciplina, av.descricao, ".
           " d.descricao as disciplina, p.descricao as polo, c.descricao as curso, ".
           " t.semestre, m.descricao as modulo ".
           " from avaliacao av ".
           " inner join turma t on t.id = av.id_turma ".
           " inner join modulo_curso m on m.id = t.id_modulo ".
           " inner join polo p on p.id = t.id_polo ".
           " inner join curso c on c.id = t.id_curso ".
           " inner join disciplina d on d.id = av.id_disciplina  ".
           " where av.id_turma = $id_turma and av.id_disciplina = $id_disciplina order by av.id ";
		return Database::getInstance()->query($sql);
  }*/
}
