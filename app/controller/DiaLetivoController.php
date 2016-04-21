<?php
/**
 * @package AcademicoEad
 * @subpackage Controller
 */
class DiaLetivoController extends Controller {
  function getDisciplina($id_disciplina) {
      if(!($this->disciplina = Disciplina::getById($id_disciplina)))
         $this->disciplina = new Disciplina();
  }
  
  public function index() {
    $this->polos = Polo::all();
    //Se o usuário logado é professor, o ComboBox de cursos não aparece,
    //apenas o de módulos, já mostrando a sigla do curso
    if(!Usuario::isTeacher()) 
       $this->cursos = Curso::all();

    if(post) {
      $o=Post::toObject();
      $o->semestre = Turma::getSemestrePadrao();
    }
    $id_curso = (isset($o) && isset($o->id_curso) ? $o->id_curso : 0);

    //Se o usuário é professor, não existe o ComboBox curso, pois
    //os módulos são carregados mostrando a sigla do curso. Assim
    //não tem que filtrar a lista de módulos por um curso
    if(Usuario::isTeacher() || (post && isset($o->id_curso) && $o->id_curso > 0))
       $this->modulos = ModuloCurso::getBySemestre(Turma::getSemestrePadrao(), $id_curso, Usuario::isTeacher());
    
    if(post) {
      if(isset($o->id_modulo) && $o->id_modulo > 0) {
         if($this->turma = Turma::get($o->id_polo, $id_curso, $o->id_modulo, $o->semestre)) 
            $this->disciplinas = DisciplinaTurma::getDisciplinasByTurma($this->turma->id, Usuario::isTeacher());
      }

      if(isset($o->id_disciplina) && $o->id_disciplina > 0) {
          $this->dias_letivos = DiaLetivo::getByTurmaDisciplina($this->turma->id, $o->id_disciplina);
          $this->getDisciplina($o->id_disciplina);
      }      
    }   
  }
  
  private function getAlunosTurma($id_turma, $id_disciplina) {
     $this->alunos_turma = 
       AlunoTurmaDisciplina::getByDisciplina($id_turma, $id_disciplina);  
  }
  
  private function getTurma($id_turma) {
     if($this->turma = Turma::getById($id_turma))
        return true;
    else return false;
  }

	public function adicionar(){
    if($this->getTurma(p("id_turma")))
       $this->getDisciplina(p("id_disciplina"));

    if(post) {
      $o=Post::toObject();
      //print_r($o);

      $erros = array();
      $salvar = (isset($o->salvar) && $o->salvar!="");
      if($salvar) {
          if(p("id_turma") == "")
            $erros[] = "Turma não identificada";
          if(p("id_disciplina") == "")
            $erros[] = "Disciplina não identificada";
          if(!isset($o->data) || $o->data == "")
            $erros[] = "Informe a Data da Aula";
          if(!isset($o->quant_aulas) || $o->quant_aulas == "" || $o->quant_aulas == "0")
            $erros[] = "Informe a Quantidade de Aulas";
          if(!isset($o->conteudo) || $o->conteudo == "")
            $erros[] = "Informe o Conteúdo Lecionado na aula";
      }
      
      if(p("id_turma")!= "" && p("id_disciplina")!="")
         $this->getAlunosTurma(p("id_turma"), p("id_disciplina"));
         
      if(count($erros))
         Post::error("Ocorreram os seguintes erros:", $erros);
         
      
      if(isset($o->data) && $o->data != "" && isset($o->quant_aulas) && $o->quant_aulas > 0) {
         if($salvar && !count($erros)) {
            $o->data = explode("/", $o->data);
            $o->data = $o->data[2]."/".$o->data[1]."/".$o->data[0];
            $db=Database::getInstance();
            $db->begin();
            try {
              //Crie um vetor para armazenar objetos alunos (que contém um campo vetor com informações sobre as presenças
              //dele em um determinado dia letivo)
              $presencas_alunos = array();
              foreach($this->alunos_turma as $a) {
                //Cria um vetor para armazenar as presenças do aluno atualmente sendo analisado
                $a->presencas = array();
                for($i=1; $i<=$o->quant_aulas; $i++) {
                   //Formato dos checkbox das aulas: "aula$NUMAULA_alunoIDALUNO"
                   $campo_presenca = "aula".$i."_aluno".$a->id_aluno;
                   //Adiciona no vetor a presença do aluno para a aula $i (0 - Ausente, 1 - Presente)
                   $a->presencas[] = (isset($o->$campo_presenca) && $o->$campo_presenca != "" ? $o->$campo_presenca : 0);
                }
                //Adiciona um novo aluno ao vetor
                $presencas_alunos[] = $a;
              }
				      $id_dia_letivo=$o->insert('id_turma, id_disciplina, data, quant_aulas, conteudo', 'dia_letivo');
				      //print_r($presencas_alunos);
				      Frequencia::batchInsertFrequencia($id_dia_letivo, $presencas_alunos);				      
              if(p("popup")) 
                  windowClose(true);
				      else Post::success("Aula adicionada com sucesso!");
				      $db->commit();
				    } catch(Exception $e) {
				      $db->rollBack();
				      Post::error("Erro: ".$e->getMessage());
				    }
         }
      }      
    } 
	}
	
	public function alterar(){
	  if(p("id")!="")
   	  $this->dia = DiaLetivo::get(p("id"));
   	  
    if($this->getTurma($this->dia->id_turma)) 
       $this->getDisciplina($this->dia->id_disciplina);

    $this->getAlunosTurma($this->dia->id_turma, $this->dia->id_disciplina);
    
    if(post) {
      $o=Post::toObject();
      //print_r($o);

      $erros = array();
      $salvar = (isset($o->salvar) && $o->salvar!="");
      if($salvar) {
          if(p("id") == "")
            $erros[] = "Aula não identificada";
      
          if(!isset($o->conteudo) || $o->conteudo == "")
            $erros[] = "Informe o Conteúdo Lecionado na aula";
      }
      
      if(count($erros))
         Post::error("Ocorreram os seguintes erros:", $erros);

      if(isset($o->conteudo) && $o->conteudo != "") {
         if($salvar && !count($erros)) {
            $db=Database::getInstance();
            $db->begin();
            try {
              $this->dia->conteudo = $o->conteudo;
              $this->dia->save("conteudo", "dia_letivo");
              //Crie um vetor para armazenar objetos alunos (que contém um campo vetor com informações sobre as presenças
              //dele em um determinado dia letivo)
              $presencas_alunos = array();
              foreach($this->alunos_turma as $a) {
                //Cria um vetor para armazenar as presenças do aluno atualmente sendo analisado
                $a->presencas = array();
                for($i=1; $i<=$this->dia->quant_aulas; $i++) {
                   //Formato dos checkbox das aulas: "aula$NUMAULA_alunoIDALUNO"
                   $campo_presenca = "aula".$i."_aluno".$a->id_aluno;
                   //Adiciona no vetor a presença do aluno para a aula $i (0 - Ausente, 1 - Presente)
                   $a->presencas[] = (isset($o->$campo_presenca) && $o->$campo_presenca != "" ? $o->$campo_presenca : 0);
                }
                //Adiciona um novo aluno ao vetor
                $presencas_alunos[] = $a;
              }
				      //print_r($presencas_alunos);
				      Frequencia::batchUpdateFrequencia($this->dia->id, $presencas_alunos);				      
              if(p("popup")) 
                  windowClose(true);
				      else Post::success("Aula atualizada com sucesso!");
				      $db->commit();
				    } catch(Exception $e) {
				      $db->rollBack();
				      Post::error("Erro: ".$e->getMessage());
				    }
         }
      }      
    } 
    else $this->frequencia = Frequencia::getByDiaLetivo($this->dia->id);
    $this->view = "adicionar";
	}	
	
	/**
	* Execute the action /exemplo/excluir/id:$id
	*
	* @param	int	$id
	* @return	void
	*/
	public function excluir(){
		$o = Post::toObject();
		try {
      if(!isset($o->id) || $o->id == 0)
         $o->id = p("id");
			$o->delete();
			Post::success("Item excluido com sucesso!", new Link("dia-letivo"));
		} catch (Exception $e) {
			Post::error("Erro: ".$e->getMessage());
		}
	}
}
