<?php
$url = "http://".$_SERVER['HTTP_HOST'].virtualroot;
$width = 'width="688px"';
//$width = 'width="714px"';
$salvar = (p("salvar")!="");
if($salvar):
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo request_lang?>" lang="<?php echo request_lang?>">
<head>
	<title>
	<?php echo $dados->aluno->nome; ?>
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<link href="/templates/my_template/css/estilos.css" rel="stylesheet" media="screen" />-->
        <link href="<?php echo $url;?>/templates/my_template/css/print.css" rel="stylesheet" />
<?php
endif;
?>
    <style type="text/css">
    /*@page {margin-right: 1.5em;}
    html{ margin: 1.5em; }
    */
    body {
      font-size: 80%;
    }
    h1 {
      font-size: 16px;
    }

    h3 {
      font-size: 13px;
      font-weight: normal;
    }

    table caption {
      text-align:left;	
      font-size:14px;
    }

    .borderless, .borderless tr, .borderless tr td{
      border:0px none;
    }

    .tab, .tab tr td {
      border: 1px solid;
    }

    .vert {
      -moz-transform: rotate(-90deg); /* Para Firefox */
      -webkit-transform: rotate(-90deg); /* Para Chrome */
      filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); /* Para IE */
    }

    #parent { height: 940px; }
    #child { position: relative; top: 100%; height: 80px; margin-top:-80px;  }
    </style>

 <?php
 if($salvar):
    echo "</head><body>";
 endif;
 ?>
    <table id="pg_frente" <?php echo $width?> class="borderless"  border="0" cellpadding="0" cellspacing="0"> <!-- 1000px -->
        <tr>
          <td colspan="3"  style="vertical-align: top" border="0" cellpadding="0" cellspacing="0" >
            <table class="borderless" <?php echo $width?> border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" width="140px">
                  <img src="<?php echo $url.'images/brasao.png' ?>" />
                </td>
                <td>
                  <span style="font-size: 12px; font-weight: bold">MINISTÉRIO DA EDUCAÇÃO<br/>
                  SECRETARIA DE EDUCAÇÃO PROFISSIONAL E TECNOLÓGICA<br/>
                  INSTITUTO FEDERAL DE EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DO TOCANTINS<br/>
                  CAMPUS PALMAS<br/>
                  COORDENAÇÃO DE REGISTROS ESCOLARES</span>
                </td>
                <tr>
                  <td colspan="2" align="center">
                      <?php if($dados->isHistoricoDefinitivo):?>
                      <span style="font-size: 28px">HISTÓRICO ESCOLAR / ACADÊMICO</span>
                      <?php else :?>
                      <span style="font-size: 28px">HISTÓRICO PARCIAL<br/>(NÃO É VÁLIDO COMO DOCUMENTO DEFINITIVO)</span>
                      <?php endif;?>
                  </td>
                </tr>
              </tr>
            </table>
            <br/>
            <TABLE class="borderless" <?php echo $width?> CELLPADDING="0px" CELLSPACING="0">
                    <COL WIDTH="230px">
                    <COL WIDTH="90px">
                    <COL WIDTH="140px">
                    <COL WIDTH="240px">
                    <caption>DADOS PESSOAIS</caption>
                    <TR>
                            <TD COLSPAN="3" HEIGHT="13">
                                    <B>Nome:</B> <?php echo $dados->aluno->nome?>
                            </TD>
                            <TD>
                                    <B>Matrícula:</B> <?php echo $dados->aluno_curso->matricula?>
                            </TD>
                    </TR>
                    <TR>
                            <TD>
                                    <B>Identidade:</B> <?php echo $dados->aluno->identidade?>
                            </TD>
                            <TD COLSPAN="2">
                                    <B>Órgão Expedidor:</B>  <?php echo $dados->aluno->orgao_expedidor_rg?>
                            </TD>
                            <TD>
                                    <B>Data de Expedição:</B>   <?php echo formatDateStr($dados->aluno->data_expedicao_rg)?>
                            </TD>
                    </TR>
                    <TR>
                            <TD>
                                    <B>CPF:</B> <?php echo $dados->aluno->cpf?>
                            </TD>
                            <TD colspan="3">
                                    <B>Data de Nascimento:</B> <?php echo $dados->aluno->data_nascimento?>
                            </TD>
                <td></td>
              </TR>
              <TR>
                            <TD COLSPAN="3" >
                                    <B>Naturalidade:</B> <?php echo $dados->aluno->naturalidade?>-<?php echo $dados->aluno->uf_naturalidade?>
                            </TD>
                            <TD>
                                    <B>Nacionalidade:</B> <?php echo $dados->aluno->nacionalidade?>
                            </TD>
              </TR>
              <TR>
                            <TD colspan="4">
                                    <B>Nome da Mãe:</B> <?php echo $dados->aluno->nome_mae?>
                            </TD>
             </tr>
             <tr>
                            <TD colspan="4">
                                    <B>Nome do Pai:</B> <?php echo $dados->aluno->nome_pai?>
                            </TD>
              </TR>
              </table>

              <table class="borderless" <?php echo $width?>>
              <caption>DADOS DO CURSO</caption>
              <TR>
                            <TD COLSPAN="2" >
                                    <B>Nome do Curso:</B> <?php echo $dados->curso->descricao?>
                            </TD>
                            <TD COLSPAN="2" >
                                    <B>Nível do Curso:</B> <?php echo $dados->curso->nivel?>
                            </TD>
                    </TR>
              <TR>
                            <TD COLSPAN="4" >
                                    <B>Modalidades(s)/Tipo(s):</B> Subsequente à distância
                            </TD>
                    </TR>
              <TR>
                            <TD COLSPAN="4" >
                                    <B>Ato legal de autorização do curso:</B> Resolução n&ordm; 31, de 09 de setembro de 2008, Conselho Diretor ETF-Palmas
                            </TD>
                    </TR>
              <TR>
                            <TD COLSPAN="4" >
                                    <B>Ato legal de reconhecimento do curso:</B> Não se aplica
                            </TD>
                    </TR>
                    <TR>
                            <TD COLSPAN="8" WIDTH="701px" >
                                <B>Tipo de processo seletivo e ano/sem:</B> 
                                <?php echo $dados->aluno_curso->tipo_ingresso . "&nbsp;". $dados->modulos_aluno[0]->semestre?> 
                            </TD>
                    </TR>
                    <TR>
                            <TD COLSPAN="8" WIDTH="701px" >
                                    <B>Carga horária total do curso:</B>  <?php echo $dados->curso->carga_horaria_total?> horas
                            </TD>
                    </TR>
                    <TR>
                            <TD COLSPAN="8" WIDTH="701px" >
                                    <B>Enade/ENEM/SAEB/outro sistema de avaliação quando aplicado:</B> Não se aplica
                            </TD>
                    </TR>
                    <TR>
                            <TD COLSPAN="8" WIDTH="701px" >
                                        <?php 
                                        if($dados->aluno_curso->data_colacao_grau!="") {
                                                echo "<B>Local e data de colação de grau:</B>&nbsp;";
                                                $dados->dt = $dados->aluno_curso->data_colacao_grau;
                                                $dados->dt=getTranslatedDate($dados->dt); 
                                                $dados->aluno_curso->data_colacao_grau = $dados->dt;
                                                echo $dados->aluno_curso->polo . ", $dados->dt."; 
                                        }
                                        ?>
                            </TD>
                    </TR>
            </TABLE>
          </td>
        </tr>
        <tr>
            <td colspan="3"  style="border: 1px solid; padding-left: 3px; padding-right: 3px;">
                <b>PERFIL DO EGRESSO</b>:<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $dados->curso->perfil; ?>
            </td>
        </tr>
    </table>
    
    <table class="borderless" CELLPADDING="0" CELLSPACING="0" style="position: relative; bottom: -80px; width: 100%">
        <tr>
          <td align="center">
            ________________________________<br/>
            <?php echo $dados->config->assinatura1; ?>
          </td>
          <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td align="center">
            ________________________________<br/>
            <?php echo $dados->config->assinatura2; ?>
          </td>
        </tr>
    </table>
    <br />
    
    <table id="pg_verso" class="borderless" CELLPADDING="0" CELLSPACING="0" style="page-break-before: always"> <!-- 915-->
    <!--<table id="pg_verso" class="borderless" CELLPADDING="0" CELLSPACING="0" height="750px">-->
        <tr>
        <td colspan="2" style="vertical-align: top" >
        <TABLE class="tab" width="688px" CELLPADDING="1px" CELLSPACING="0" border="1px">
            <caption>MATRIZ CURRICULAR / FREQUÊNCIA / APROVEITAMENTO</caption>
            <tr>
              <TD width="30px" align="center">P*</TD>
              <TD width="20px" align="center">A*</TD>
              <TD >Componentes Curriculares	</TD>
              <TD width="30px" align="center">CH*</TD>
              <TD width="40px" align="center">Nota Final</TD>
              <TD width="40px" align="center">Frequência %</TD>
              <TD width="40px" align="center">Aproveitamento</TD>
            </tr>
            <?php
            $dados->i=0;
            foreach($dados->modulos_aluno as $dados->m): 
                $dados->i++;
                $dados->style=($dados->i==1 ? "style='page-break-after: no;'" : "");
            ?>
                <?php
                $dados->carga_horaria_modulo = 0;
                foreach($dados->m->notas_disciplina as $dados->j=>$dados->nd):     
                    if($dados->j==0)
                        $dados->rowspan =  "rowspan='" . count($dados->m->notas_disciplina) . "'";
                    else $dados->rowspan = "";
                ?>
                    <TR>
                        <?php if($dados->rowspan!=""):?>
                        <TD VALIGN="middle" align="center" <?php echo $dados->rowspan;?>>
                                <div class="vert"><?php echo arabicToRoman($dados->m->num_modulo)?>&nbsp;Módulo</div>
                        </TD>
                        <TD VALIGN="middle" align="center" <?php echo $dados->rowspan;?>>
                                <div class="vert"><?php echo $dados->m->semestre?></div>
                        </TD>
                            <?php endif;?>
                        <td>
                        <?php 
                        $dados->carga_horaria_modulo += $dados->nd->carga_horaria;
                        echo $dados->nd->disciplina;
                        ?>
                        </td>
                        <TD align="center">
                            <?php echo $dados->nd->carga_horaria."h"; ?>
                        </TD>
                        <td align="right">
                          <?php echo $dados->nd->media_final; ?>
                        </td>

                            <?php if($dados->rowspan!=""):?>
                        <TD  align="center" <?php echo $dados->rowspan;?>>
                            100%
                        </TD>
                        <TD align="center" <?php echo $dados->rowspan;?>>
                             <?php echo  $dados->m->conceito;?>    
                        </TD>
                            <?php endif;?>
                    </tr>
                <?php  
                endforeach; 
                ?>
            <?php endforeach; ?> <!--Módulos e suas disciplinas-->
            <tr>
                <TD colspan="7">
                OBSERVAÇÕES: P* = Período; A* = Ano; CH* = Carga Horária. Média mínima para aprovação: 6.0.<br/>
                        <?php if($dados->aluno_curso->data_colacao_grau=="") : ?>
                                &nbsp;Histórico parcial.
                                O documento definitivo só é emitido após a colação
                                de grau do aluno.
                <?php endif; ?>
                <br/><br/><br/>
                <?php if($dados->curso->carga_horaria_estagio > 0):?>
                O estudante concluiu as <?php echo $dados->curso->carga_horaria_estagio; ?> horas de atividades complementares.
                <?php endif; ?>
                </TD>
            </TR>
            <tr>
                    <td colspan="7" align="right" >Palmas/TO, 
                    <?php echo strtolower(getTranslatedDate())?>
                    <?php /*echo $dados->aluno_curso->data_colacao_grau*/?>.
                    </td>
            </tr>
          </TABLE>
        </td>
        </tr>
    </table>

    <table class="borderless" CELLPADDING="0" CELLSPACING="0" style="position: absolute; bottom: -440px">
    <tr>
      <td style="position: relative; vertical-align:text-top; border: 0; padding: 0">
          <img style="border: 0; vertical-align:text-top" 
          src="<?php echo $url.'images/logo-ifto.png'?>" width="140px" height="57px"/>
      </td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td style="position: relative; vertical-align:text-top; border: 0; padding: 0">
      AE 310 Sul, Av. NS 10, Esquina com LO 05, Centro<br/>
      CEP: 77.021-090, Palmas-TO.<br/>
      Fone: (63) 3236-4070<br/>
      Home Page: http://palmas.ifto.edu.br
      </td>
    </tr>
    </table>
 <?php   
if($salvar):
?>
</body>
</html>
 <?php   
 endif;