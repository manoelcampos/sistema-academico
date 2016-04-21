<?php
/**
 * @package AcademicoEad
 * @subpackage model
*/
class AlunoCurso extends DTO{
    /**
    * Contruct a Exemplo object
    *
    * @return	void
    */
    public function __construct($id=0, $id_aluno=0, $id_curso=0, $id_polo=0){
            if (isset($this->id)) return; // PDO BUG	
            $this->id 		= $id;
            $this->id_aluno 	= $id_aluno;
            $this->id_curso = $id_curso;
            $this->id_polo = $id_polo;
    }

    /** Obtém a lista de alunos que estejam aprovados em todas as disciplinas de todos
     * os módulos a partir do semestre de início indicado,
     * para as turmas (módulos) especificados em $turmas,
     * representando todos os módulos de uma turma inicial.
     * @param array<Turma> $turmas  Lista de todas as turmas par ao curso e polo, a partir 
     * de um determinado semestre de início (representando 
     * todas os módulos de uma determinada turma)
    */
    public static function getAprovados($turmas) {
        return AlunoCursoDAO::getAprovados($turmas);
    }

    /**
    * Obtém a lista de alunos matriculados em um determinado curso,
    * buscando pelo nome ou pela matrícula do aluno
    * @return	Retorna um vetor contendo uma lista de objetos AlunoCurso
    * @param string $nome_matricula Nome ou matrícula (completo(a) ou parcial) do aluno.
    */
    public static function getByNomeMatriculaCPF($nome_matricula_cpf, $id_curso=0, $id_polo=0){
       return AlunoCursoDAO::getByNomeMatriculaCPF($nome_matricula_cpf, $id_curso, $id_polo);
    }

    public static function getByIdAlunoCurso($id_aluno_curso, $id_curso=0, $id_polo=0){
      return AlunoCursoDAO::getByIdAlunoCurso($id_aluno_curso, $id_curso, $id_polo);
    }
    
    /**
     * Registra a data de colação de grau para a relação
     * de alunos indicados no vetor $ids_alunos,
     * para o curso e polo informado
     * @param array<int> $ids_aluno_curso Array com os id_aluno_curso
     * dos alunos para atualizar a data de colação de grau.
     * @param int $id_curso Código do curso
     * @param int $id_polo Código do polo
     * @param string $data Data de colação de grau 
     */
    public static function registrarDataColacaoGrau($ids_aluno_curso, $id_curso, $id_polo, $data) {
        return AlunoCursoDAO::registrarDataColacaoGrau($ids_aluno_curso, $id_curso, $id_polo, $data);
    }
}
