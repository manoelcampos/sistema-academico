<?php $width = 'width="714px"'; ?>
<style type="text/css">
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

<table id="pg_frente" class="borderless"  border="0" CELLPADDING="0" CELLSPACING="0" height="920px">
<tr>
  <td colspan="2"  style="vertical-align: top">
    <table class="borderless" <?php echo $width?>>
      <tr>
        <td align="center" width="180px">
          <img src="<?php echo virtualroot.'images/brasao.png'?>" />
        </td>
        <td>
        <h3>MINISTÉRIO DA EDUCAÇÃO<br/>
        SECRETARIA DE EDUCAÇÃO PROFISSIONAL E TECNOLÓGICA<br/>
        INSTITUTO FEDERAL DE EDUCAĆÃO, CIÊNCIA E TECNOLOGIA DO TOCANTINS<br/>
        CAMPUS PALMAS<br/>
        COORDENAÇÃO DE REGISTROS ESCOLARES</h3><br/>
        </td>
        <tr>
        <td colspan="2" align="center"><h1>HISTÓRICO ESCOLAR / ACADÊMICO</h1></td>
        </tr>
      </tr>
    </table>
    <br/>
    <TABLE class="borderless" <?php echo $width?> CELLPADDING="5px" CELLSPACING="0">
	    <COL WIDTH="200px">
	    <COL WIDTH="100px">
	    <COL WIDTH="140px">
	    <COL WIDTH="260px">
      <caption>DADOS PESSOAIS</caption>
	    <TR>
		    <TD COLSPAN="3" HEIGHT="13">
			    <B>Nome:</B> <?php echo $aluno->nome?>
		    </TD>
		    <TD>
			    <B>Matrícula:</B> <?php echo $aluno->matricula?>
		    </TD>
	    </TR>
	    <TR>
		    <TD>
			    <B>Identidade:</B> <?php echo $aluno->identidade?>
		    </TD>
		    <TD COLSPAN="2">
			    <B>Órgão Expedidor:</B>  <?php echo $aluno->orgao_expedidor_rg?>
		    </TD>
		    <TD>
			    <B>Data de Expedição:</B>   <?php echo $aluno->data_expedidor_rg?>
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="4" WIDTH="251px">
			    <B>CPF:</B> <?php echo $aluno->cpf?>
		    </TD>
      </TR>
      <TR>
		    <TD >
			    <B>Data de Nascimento:</B> <?php echo $aluno->data_nascimento?>
		    </TD>
		    <TD COLSPAN="2" >
			    <B>Naturalidade:</B> <?php echo $aluno->naturalidade?>-<?php echo $aluno->uf_naturalidade?>
		    </TD>
		    <TD>
			    <B>Nacionalidade:</B> <?php echo $aluno->nacionalidade?>
		    </TD>
      </TR>
      <TR>
		    <TD colspan="4">
			    <B>Nome da Mãe:</B>
		    </TD>
      </TR>
      <TR>
		    <TD colspan="4">
			    <B>Nome do Pai:</B>
		    </TD>
      </TR>
      </table>

      <table class="borderless">
      <caption>DADOS DO CURSO</caption>
      <TR>
		    <TD COLSPAN="4" >
			    <B>Nome do Curso:</B> <?php echo $curso->descricao?>
		    </TD>
	    </TR>
      <TR>
		    <TD COLSPAN="4" >
			    <B>Nível do Curso:</B> <?php echo $curso->nivel?>
		    </TD>
	    </TR>
      <TR>
		    <TD COLSPAN="4" >
			    <B>Modalidades(s):</B> Educação Profissional / Educação à Distância
		    </TD>
	    </TR>
      <TR>
		    <TD COLSPAN="4" >
			    <B>Forma de Articulação:</B> Subsequente ao Ensino Médio
		    </TD>
	    </TR>
      <TR>
		    <TD COLSPAN="4" >
			    <B>Ato lega de autorização do curso:</B> 
		    </TD>
	    </TR>
      <TR>
		    <TD COLSPAN="4" >
			    <B>Ato lega de reconhecimento do curso:</B> 
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="8" WIDTH="701px" >
          <B>Tipo	de processo seletivo e ano/sem:</B> <?php echo $aluno_curso->tipo_ingresso?>
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="8" WIDTH="701px" >
			    <B>Carga horária total do curso:</B>  <?php echo $curso->carga_horaria_total?> horas
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="8" WIDTH="701px" >
          <B>Enade/ENEM/SAEB/outro sistema de avaliação quando aplicado:</B> 
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="8" WIDTH="701px" >
          <B>Data de  colação de grau:</B> 
		    </TD>
	    </TR>
    </TABLE>
  </td>
</tr>
<tr height="80px">
  <td align="center">
    <b>Liliane Flávia Guimarães da Silva</b><br/>
    Diretora de Ensino<br/>
    Portaria: 48/2010-IFTO/Campus Palmas</td>
  <td align="center">
    <b>Ronaldo Vasconcelos da Silva</b><br/>
    Coordenador de Certificacão<br/>
    Portaria: 152/2011/IFTO/Campus Palmas
  </td>
</tr>
</table>
<br />

<table id="pg_verso" class="borderless" 
CELLPADDING="0" CELLSPACING="0" height="920px">
<tr>
<td colspan="2" style="vertical-align: top" >
<TABLE class="tab" <?php echo $width?> CELLPADDING="5px" CELLSPACING="0" border="1px" <?php echo $style?>>
<caption>MATRIZ CURRICULAR / FREQUÊNCIA / APROVEITAMENTO</caption>
<tr>
	<TD align="center">P*	</TD>
  <TD align="center">A*	</TD>
	<TD WIDTH="337px">Componentes Curriculares	</TD>
  <TD align="center">CH*</TD>
  <TD align="center">Nota Final</TD>
  <TD align="center">Frequência %</TD>
  <TD align="center">Aproveitamento</TD>
</tr>
<?php 
$i=0;
foreach($modulos_aluno as $m): 
  $i++;
  $style=($i==1 ? "style='page-break-after: always;'" : "");
?>
	<TR>
		<TD VALIGN="middle" align="center" >
			<div class="vert">Módulo <?php echo $i?></div>
		</TD>
		<TD VALIGN="middle" align="center">
			<div class="vert"><?php echo $m->semestre?></div>
		</TD>
		<TD>
      <?php
      $carga_horaria_modulo = 0;
      foreach($m->notas_disciplina as $nd) {
        $carga_horaria_modulo += $nd->carga_horaria;
        echo "$nd->disciplina<br/>";
      }
      ?>

		</TD>
		<TD WIDTH="60px"  align="center">
      <?php
      foreach($m->notas_disciplina as $nd)
			  echo "$nd->carga_horaria<br/>";
      ?>
		</TD>
    <td></td>
		<TD WIDTH="84px"  align="center">
			99%
		</TD>
		<TD WIDTH="139px" align="center">
			"<?php echo $m->conceito?>"
		</TD>
	</TR>
<? endforeach; ?> <!--Módulos e suas disciplinas-->
  <tr>
		<TD colspan="7">OBSERVACÕES: P* = Período; A* = Ano; CH* = Carga Horária<br/><br/><br/><br/></TD>
	</TR>
  <tr><td colspan="7" align="right">Palmas/TO, <?php echo strtolower(getTranslatedDate())?>.</td></tr>
</TABLE>
</td>
</tr>
<tr height="70px">
  <td valign="top"><img src="<?php echo virtualroot.'images/logo-ifto.png'?>" /></td>
  <td  valign="top" style="border-left: 1px">
  Avenida LO 05<br/>
  AE 310 Sul<br/>
  Palmas - Tocantins<br/>
  CEP: 77021-090<br/>
  Telefone: (63) 3233-1370
  </td>
</tr>
</table>

