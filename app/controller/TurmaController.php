<?php
//???? Era pra fazer o require automaticamente
require(root."app/model/Polo.php");

/**
 * @package AcademicoEad
 * @subpackage Controller
*/
class TurmaController extends Controller{

    private $key;

    private function validarInsert($o) {
        $erros = array();
        if($o->semestre_inserir == "") 
          $erros[]="Informe o semestre";
            
        if(count($erros)) {
            Post::error("Ocorreram os seguintes erros", $erros);
            return false;
        }
        return true;
    }
    
    public function adicionar() {
        $this->polos = Polo::all();
        $this->cursos = Curso::all();
        
        if(post) {
            $o = Post::toObject();
            if(isset($o->id_curso) && ($o->id_curso > 0)) {
                $this->modulos = ModuloCurso::getByCurso($o->id_curso);
                if(isset($o->id_modulo) && ($o->id_modulo > 0)) {
                    if(isset($o->enviar)) {
                        if(!$this->validarInsert($o))
                            return;
                        
                        if($o->enviar==0)
                            return;

                        $criadas = Turma::insertTurmas(
                          $o->semestre_inserir, $o->id_polo, $o->id_curso, $o->id_modulo);
                        if($criadas>0)
                            Post::success("$criadas turma(s) criada(s) com sucesso!");
                        else Post::success("Não foi necessário criar nenhuma turma!");
                    }
                }
            }
        }
        
    }
    
    public function index() {
        $id_curso = 0;
        if(post)
            $id_curso = p("id_curso");
        $this->itens = Turma::all(Turma::getSemestrePadrao(), $id_curso);
        $this->cursos = Curso::all();
    }  

    /** Inicializa as variáveis a serem retornadas pela action histórico,
    quando o usuário ainda não tiver localizado o aluno para o qual
    deseja imprimir o relatório */
    private function initHistorico() {
        $this->alunos = array();
        $this->cursos = array();
        $this->curso = new Curso();
        $this->aluno = new Aluno();
        $this->aluno_curso = new AlunoCurso();
        $this->modulos_aluno = array();
    }
    
    
    /**
     * Indica se o histórico gerado será definitivo ou não.
     * Só é definitivo se o aluno está apto em todas
     * as disciplinas listadas.
     * Caso contrário, não serve como documento oficial.
     * @param array<AlunoTurma> $modulos_aluno Array com os objetos
     * que indicam as matrículas de um determinado aluno em uma turma,
     * onde cada item deve ter um campo notas_disciplina
     * sendo um array de AlunoTurmaDisciplina contendo
     * as notas de todas as disciplinas do aluno para o módulo.
     * @return boolean Retorna true se o aluno está apto 
     * em todas as disciplinas listadas.
     */
    public function isHistoricoDefinitivo($modulos_aluno) {
        foreach($modulos_aluno as $m) {
              foreach($m->notas_disciplina as $nd) {
                if($nd->id_conceito != Conceito::ID_APTO) {
                        return false;
                }
              }
        }
        return true;
    }

    /**
     * Retorna um vetor associativo contendo os campos com as chaves abaixo:
     * aluno_curso
     * aluno
     * curso
     * modulos_aluno
     * config
     * isHistoricoDefinitivo
     */
    private function obtem_dados_historico($id_aluno_curso, $id_curso, $id_polo, $numero=0) {
        $dados = array();
        
        $dados["aluno_curso"] = 
                AlunoCurso::getByIdAlunoCurso(
                        $id_aluno_curso, $id_curso, $id_polo);
        $ac = $dados["aluno_curso"];
        $dados["aluno"] = Aluno::get($ac->id_aluno);
        $aluno = $dados["aluno"];

        $titulo = stripAccents($aluno->nome);
        if (intval($numero) > 0) {
            $titulo = "$numero - $titulo";
        }
        Vortice::setVar('title', $titulo);

        $dados["curso"] = Curso::getWithCargaHorariaTotalAndQuantModulos($ac->id_curso);
        $dados["modulos_aluno"] = 
                AlunoTurma::getByAlunoAndCurso($aluno->id, $ac->id_curso, $ac->id_polo);
        $modulos_aluno = $dados["modulos_aluno"];
        if($modulos_aluno) {
          for($i = 0; $i < count($modulos_aluno); $i++) {
             $modulos_aluno[$i]->notas_disciplina = 
               AlunoTurmaDisciplina::getByTurma(
                  $aluno->id, $modulos_aluno[$i]->id_turma);
          }
          $dados["isHistoricoDefinitivo"] = $this->isHistoricoDefinitivo($modulos_aluno);
        }
        $dados["config"] = Config::get();
        return $dados;
    }
    
    /**
     * Pega os valores do vetor associativo $vetor_associativo
     * e criar propriedades no objeto $this
     * com o nome de cada chave de tal vetor,
     * atribuindo o valor da chave para a propriedade criada.
     * Todas as propriedades criadas no objto $this 
     * são automaticamente publicadas para a view associada
     * ao controller pelo Vortice.
     */
    private function publicar_dados_vetor($vetor_associativo){
        foreach($vetor_associativo as $key=>$value):
            $this->$key = $value;
        endforeach;        
    }
    
    public function historico() {
      $this->polos = Polo::all();
      $this->cursos = Curso::all();
      $erros = array();
      $ok = false;
      //O form pode ser postado para buscar o aluno
      //só quando algum é encontrado é que o botão gerar é criado.
      if(post || p("gerar")!="") {
            if (p("aluno")) {
                $this->alunos = AlunoCurso::getByNomeMatriculaCPF(
                                p("aluno"), p("id_curso"), p("id_polo"));
            } else {
                $this->alunos = array();
            }

            if(p("id_aluno_curso")) {
                $dados = $this->obtem_dados_historico(
                      p("id_aluno_curso"), p("id_curso"), p("id_polo"), p("numero"));
                $this->dados = $this->convertArrayToObject($dados);
                $ok = true;
            }
      }

      if (!$ok) {
            $this->initHistorico();
      }

      if (count($erros)) {
            Post::error("Ocorreram os seguintes erros:", $erros);
      }
    }

    public function conselho(){
        $this->polos = Polo::all();
        $this->cursos = Curso::all();

        $erros = array();
        if(post) {  
           if(p("id_curso") > 0)
                 $this->modulos = 
                    ModuloCurso::getBySemestre(
                            Turma::getSemestrePadrao(), p("id_curso"));

           if(p("id_modulo") > 0) {
                 $orderby_disciplina = "sigla";
                 $this->turma = 
                         Turma::get(
                                 p("id_polo"), p("id_curso"), 
                                 p("id_modulo"), Turma::getSemestrePadrao());
                 if($this->turma) {
                   $this->itens = AlunoTurma::getByTurma($this->turma->id);  
                   for($i = 0; $i < count($this->itens); $i++) {
                          $this->itens[$i]->num = $i+1;
                          $this->itens[$i]->notas = 
                                AlunoTurmaDisciplina::getByTurma(
                                  $this->itens[$i]->id_aluno, 
                                        $this->itens[$i]->id_turma, $orderby_disciplina);
                   }
                   $this->disciplinas_turma = 
                           DisciplinaTurma::getDisciplinasByTurma(
                                   $this->turma->id, $orderby_disciplina);
                 }
                 else $erros["turma_nao_encontrada"] = "Não existe nenhuma turma com os dados informados.";
           }
        }

        if(count($erros))
          Post::error("Ocorreram os seguintes erros:", $erros);
    }  

    /**
     * Obtém os dados para exibir o relatório de aprovados
     * quando a action aprovados for chamada
     * @param string $caption Título inicial para o relatório (que será
     * concatenado com mais dados dentro do método)
     * @return int Retorna o código da turma 
     * referente aos dados que o usuário selecionou no formulário, ou zero
     * caso a turma não seja localizada.
     */
    private function dadosAprovadosModulo($id_polo, $id_curso, $id_modulo, $caption) {
        $orderby_disciplina = "sigla";
        $this->turma = 
           Turma::get(
             $id_polo, $id_curso, 
             $id_modulo, Turma::getSemestrePadrao());

         if($this->turma && $this->turma->id > 0) {
                $caption .= $this->turma->curso . " - " . $this->turma->polo . "<br/>";
                $caption .= $this->turma->semestre . " - Módulo " . $this->turma->ordem_modulo;
                $title = str_replace("<br/>", " - ", $caption);
                Vortice::setVar("title", $title);
                Vortice::setVar("caption", $caption);

                $this->itens = AlunoTurma::getAprovadosByTurma($this->turma->id);  
                for($i = 0; $i < count($this->itens); $i++) {
                  $this->itens[$i]->num = $i+1;
                  $this->itens[$i]->notas = 
                        AlunoTurmaDisciplina::getByTurma(
                          $this->itens[$i]->id_aluno, 
                          $this->itens[$i]->id_turma, $orderby_disciplina);
                }
                $this->disciplinas_turma = 
                        DisciplinaTurma::getDisciplinasByTurma(
                                $this->turma->id, $orderby_disciplina);
                return $this->turma->id;
         }
         return 0;
    }

    private function dadosAprovadosCurso($id_polo, $id_curso, $caption) {
        $orderby_disciplina = "sigla";
        $semestre_inicio = Turma::getSemestrePadrao();
        $this->turma = 
           Turma::getModulo1($id_polo, $id_curso, $semestre_inicio);

         if($this->turma && $this->turma->id > 0) {
                $caption = 
                  str_replace("Técnico em ", "", $this->turma->curso) . "  " . $this->turma->polo . " - " .
                  "Turma " . str_replace("/", "-", $this->turma->semestre) . "<br/>" .
                  $caption;
                $title = str_replace("<br/>", " - ", $caption);
                Vortice::setVar("title", $title);
                Vortice::setVar("caption", $caption);
                
                /*lista de todas as turmas para o curso e polo, a partir
                de um determinado semestre de início (representando
                todas os módulos de uma determinada turma)*/
                $this->turmas = Turma::getListaModulosTurma($id_curso, $id_polo, $semestre_inicio);
                //lista de alunos aprovados para as turmas indicadas
                $this->itens = AlunoCurso::getAprovados($this->turmas);  
                for($i = 0; $i < count($this->itens); $i++) {
                  $this->itens[$i]->num = $i+1;
                  $notas_curso = array();
                  /* @var $turmas Turma */
                  foreach($this->turmas as $t) {
                      //todas as notas do aluno para o módulo
                      $notas_modulo =
                        AlunoTurmaDisciplina::getByTurma(
                          $this->itens[$i]->id_aluno, 
                          $t->id, $orderby_disciplina);
                      $notas_curso = array_merge($notas_curso, $notas_modulo);                      
                  }
                  $this->itens[$i]->notas = $notas_curso;
                }
                $this->disciplinas_turma = 
                        DisciplinaTurma::getDisciplinasByCurso(
                                $id_curso, $orderby_disciplina);
         }
    }
    
    private function exibirListaAprovados(&$erros) {
        //Agroecologia - Cristalândia - Semestre de Início 2011-2
        $caption = "Alunos Aprovados";

        if(p("id_curso") > 0)
               $this->modulos = 
                  ModuloCurso::getBySemestre(
                          Turma::getSemestrePadrao(), p("id_curso"));

        if(p("id_modulo") > 0) {
             $id_turma = 
              $this->dadosAprovadosModulo(
                      p("id_polo"), p("id_curso"), p("id_modulo"), $caption);
             if($id_turma == 0)
                $erros["turma_nao_encontrada"] = "Não existe nenhuma turma com os dados informados.";
        }
        else {
              $this->dadosAprovadosCurso(
                      p("id_polo"), p("id_curso"), $caption);
        }
    }
    
    public function aprovados(){
        $this->polos = Polo::all();
        $this->cursos = Curso::all();
        $this->conceito = Conceito::get(1);
        $erros = array();
        if(post) :
            if (intval(p("salvar")) > 0) {
                $this->salvarHistoricos($erros);
            } else if (p("alterar_data_colacao") != "") {
                $this->registrarDataColacaoGrau($erros);
            }
            $this->exibirListaAprovados($erros);
        endif;

        if (count($erros)) :
            Post::error("Ocorreram os seguintes erros:", $erros);
        endif;
    }
    
    public function reprovados(){
        $this->polos = Polo::all();
        $this->cursos = Curso::all();
        $this->conceito = Conceito::get(2);
        $erros = array();
        if(post) {  
           $caption = "Alunos Reprovados";

           if(p("id_curso") > 0):
                 $this->modulos = 
                    ModuloCurso::getBySemestre(
                           Turma::getSemestrePadrao(), p("id_curso"));
           endif;

           if(p("id_modulo") > 0) {
                 $orderby_disciplina = "sigla";
                 $this->turma = 
                         Turma::get(
                                p("id_polo"), p("id_curso"), 
                                p("id_modulo"), Turma::getSemestrePadrao());
                 if($this->turma && $this->turma->id > 0) {
                        $caption .= $this->turma->curso . " - " . $this->turma->polo . "<br/>";
                        $caption .= $this->turma->semestre . " - Módulo " . $this->turma->ordem_modulo;
                        $title = str_replace("<br/>", " - ", $caption);
                        Vortice::setVar("title", $title);
                        Vortice::setVar("caption", $caption);

                        $this->itens = AlunoTurma::getReprovadosByTurma($this->turma->id);  
                        for($i = 0; $i < count($this->itens); $i++) {
                          $this->itens[$i]->num = $i+1;
                          $this->itens[$i]->notas = 
                                AlunoTurmaDisciplina::getByTurma(
                                  $this->itens[$i]->id_aluno, 
                                  $this->itens[$i]->id_turma, $orderby_disciplina);
                        }
                        $this->disciplinas_turma = 
                                DisciplinaTurma::getDisciplinasByTurma(
                                        $this->turma->id, 0, $orderby_disciplina);
                 }
                 else $erros["turma_nao_encontrada"] = "Não existe nenhuma turma com os dados informados.";
           }
        }
    
        if(count($erros)):
          Post::error("Ocorreram os seguintes erros:", $erros);
        endif;
    }
    
    private function registrarDataColacaoGrau(&$erros) {
        if(p("data_colacao_grau")=="") {
            $erros[]="Informe a data de colação de grau.";
            return;
        }    
        $ids_aluno_curso = p("id_aluno_curso");
        if($ids_aluno_curso=="" || count($ids_aluno_curso)==0) :
            $erros[]="Selecione algum aluno.";
            return;
        endif;
        
        AlunoCurso::registrarDataColacaoGrau($ids_aluno_curso, p("id_curso"), p("id_polo"), p("data_colacao_grau"));
    }
    
    /**
     * Converte um vetor para um objeto, permitindo
     * acessar os dados como propriedades e não como índices.
     * @param array $array Array que será convertido para um objeto
     * @param Object Retorna o objeto criado a partir do array.
     */
    private function convertArrayToObject($array){
        $obj = new DTO();
        foreach ($array as $k => $v) {
            $obj->$k = $v;
        }
        return $obj;
    }
    
    private function salvarHistoricos(&$erros) {
        $ids_aluno_curso = p("id_aluno_curso");
        if($ids_aluno_curso=="" || count($ids_aluno_curso)==0) {
            $erros[]="Selecione algum aluno.";
            return;
        }    
        
        $dados_historicos_alunos = array();
        foreach($ids_aluno_curso as $i=>$id_aluno_curso):
            $dados = $this->obtem_dados_historico(
                  $id_aluno_curso, p("id_curso"), p("id_polo"), $i+1);  
            $dados_historicos_alunos[] = $this->convertArrayToObject($dados);
        endforeach;

        //$html_form = ob_get_clean();    
        $dir = root."relatorios/";
        $total = count($dados_historicos_alunos);
        $tmpfile = $dir."0tmp";
        foreach($dados_historicos_alunos as $i=>$dados):
            $filename= ++$i." - " . $dados->aluno->nome;
            $filename=  $dir.str_replace(" ", "_", $filename);
            //$url = "http://".$_SERVER['HTTP_HOST'].virtualroot."gerarpdf.php?filename=$filename";

            ob_start();
            include(root."app/view/turma/modelo-historico3.php"); 
            $html = ob_get_clean(); 
            file_put_contents($filename.".html", $html);
            //echo getWebResource($url);
            /*require_once(root.'app/dompdf/dompdf_config.inc.php');
            $dompdf = new DOMPDF();
            $dompdf->set_paper("A4");
            $dompdf->load_html($html);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents($filename.".pdf", $output);*/
        endforeach;
        $script = "gerarpdf.sh";
        $cmd =  "#!/bin/bash\n";
        $cmd .= "clear; wkhtmltopdf *.html \"" . $dados->curso->descricao . 
                " - " . $dados->aluno_curso->polo . ".pdf\" && rm *.html\n" .
                "rm $script";
        file_put_contents($dir.$script, $cmd);
        ob_end_flush();
        Post::success("$total históricos gerados.");
    }    
    
}
