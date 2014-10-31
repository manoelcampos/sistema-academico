<?php $width = 'width="714px"'; ?>

<!--Cabeçalho-->
<table <?php echo $width?>>
  <tr>
    <td align="center" width="180px">
      <img src='<?php echo virtualroot.'images/logo-ifto.png'?>' />
    </td>
    <td align="center">
    <b>MINISTÉRIO DA EDUCAÇÃO</b><br/>
    <b>Secretaria de Educação Profissional e Tecnológica</b><br/>
    <b>Diretoria de Ensino</b><br/>
    <b>Gerência de Planejamento e Desenvolvimento Educacional</b><br/>
    <b>Coordenação de Registro Escolar</b><br/><br/>
    </td>
    <tr>
    <td colspan="2" align="center"><b>HISTÓRICO ESCOLAR</b></td>
    </tr>
  </tr>
</table>

<br/>

<!--Dados do aluno-->
<TABLE <?php echo $width?> CELLPADDING="5px" CELLSPACING="0" border="1px">
	<COL WIDTH="210px">
	<COL WIDTH="170px">
	<COL WIDTH="2px">
	<COL WIDTH="28px">
	<COL WIDTH="76px">
	<COL WIDTH="105px">
	<COL WIDTH="1px">
	<COL WIDTH="39px">
	<TR>
		<TD COLSPAN="4" WIDTH="440px" HEIGHT="12px">
			<B>CURSO:</B> <?php echo $curso->descricao?>
		</TD>
		<TD COLSPAN="4" WIDTH="251px" >
			<B>Matrícula:</B> <?php echo $aluno->matricula?>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="4" WIDTH="440px" HEIGHT="13">
			<B>Nome:</B> <?php echo $aluno->nome?>
		</TD>
		<TD COLSPAN="4" WIDTH="251px">
			<B>Identidade:</B> <?php echo $aluno->identidade?>
		</TD>
	</TR>
	<TR>
		<TD WIDTH="210" HEIGHT="13px">
			<B>Data de Nascimento:</B> <?php echo $aluno->data_nascimento?>
		</TD>
		<TD COLSPAN="2" WIDTH="182px">
			<B>Nacionalidade:</B> <?php echo $aluno->nacionalidade?>
		</TD>
		<TD COLSPAN="3" WIDTH="230px">
			<B>Naturalidade:</B> <?php echo $aluno->naturalidade?>
		</TD>
		<TD COLSPAN="2" WIDTH="60px">
			<B>UF:</B> <?php echo $aluno->uf_naturalidade?>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="8" WIDTH="701px" HEIGHT="13px">
      <B>Tipo	de Ingresso:</B> <?php echo $aluno_curso->tipo_ingresso?>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="2" WIDTH="390px" HEIGHT="13px" >
      <B>Curso Anterior:</B> <?php echo $aluno_curso->curso_anterior?>
		</TD>
		<TD COLSPAN="3" WIDTH="127px">
			<B>Ano:</B>  <?php echo $aluno_curso->ano_conclusao_curso_anterior?>
		</TD>
		<TD COLSPAN="3" WIDTH="165px">
			<B>Grau:</B>  <?php echo $aluno_curso->grau_curso_anterior?>º
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="8" WIDTH="701px" HEIGHT="13px">
			<B>Instituição:</B>  <?php echo $aluno_curso->instituicao_curso_anterior?>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="7" WIDTH="652px" HEIGHT="12px">
			<B>Cidade:</B>  <?php echo $aluno_curso->cidade_curso_anterior?>
		</TD>
		<TD WIDTH="60">
			<B>UF:</B> <?php echo $aluno_curso->uf_curso_anterior?>
		</TD>
	</TR>
</TABLE>

<br/>
<!--Dados do curso-->
<table <?php echo $width?> cellpadding="5px" cellspacing="0" border="1px">
	<tr>
		<td align="center"  BGCOLOR="#e6e6e6">
			<b>PERFIL PROFISSIONAL DE CONCLUSÃO DE CURSO</b>
		</td>
	</tr>
	<tr>
		<td>
			<div align="justify"><?php echo str_replace("\n", "<br/>", $curso->perfil)?></div>
		</td>
	</tr>
	<tr>
		<td>
			<b>Área Profissional: <?php echo $curso->area_profissional?></b>
		</td>
	</tr>
</table>

<br/>

<!--Módulos e suas disciplinas-->
<?php
$i=0;
foreach($modulos_aluno as $m): 
  $i++;
  $style=($i==1 ? "style='page-break-after: always;'" : "");
?>
<TABLE <?php echo $width?> CELLPADDING="5px" CELLSPACING="0" border="1px" <?php echo $style?>>
	<COL WIDTH="15px">
	<COL WIDTH="16px">
	<COL WIDTH="337px">
	<COL WIDTH="60px">
	<COL WIDTH="84px">
	<COL WIDTH="139px">
	<TR>
		<TD COLSPAN="6" WIDTH="701px" VALIGN="top" align="center">
			<b><?php echo (is_numeric(stripos($m->modulo, "módulo")) ? $m->modulo : "Módulo $m->modulo")?></b>
		</TD>
	</TR>
	<TR>
		<TD ROWSPAN="2" WIDTH="15px" HEIGHT="11px" VALIGN="middle" align="center"  BGCOLOR="#e6e6e6">
			<B>Ano / Período:</B>
		</TD>
		<TD ROWSPAN="2" WIDTH="16px" VALIGN="middle">
			<?php echo $m->semestre?>
		</TD>
		<TD WIDTH="337px"  BGCOLOR="#e6e6e6">
			<H3>Componentes Curriculares</H3>
		</TD>
		<TD WIDTH="60px" VALIGN="top"  BGCOLOR="#e6e6e6" align="center">
			<B>Carga Horária</B>
		</TD>
		<TD WIDTH="84px" BGCOLOR="#e6e6e6" align="center">
			<H3>Freqüência</H3>
		</TD>
		<TD WIDTH="139px" BGCOLOR="#e6e6e6" align="center">
			<H3>Conceito</H3>
		</TD>
	</TR>
	<TR>
		<TD WIDTH="337px">
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
		<TD WIDTH="84px"  align="center">
			99%
		</TD>
		<TD WIDTH="139px" align="center">
			"<?php echo $m->conceito?>"
		</TD>
	</TR>
	<TR>
		<TD COLSPAN="5">
			<b> <?php echo (!empty($m->qualificacao) ? "QUALIFICAÇÃO: $m->qualificacao" : "")?></b>
		</TD>
		<TD WIDTH="139px" VALIGN="top" BGCOLOR="#e6e6e6">
			<b>Carga Horária Total:</b> <?php echo $carga_horaria_modulo?>h
		</TD>
	</TR>
</TABLE>
<br/><br/>
<? endforeach; ?> <!--Módulos e suas disciplinas-->

<br/>

<!--Estágio supervisionado-->
<!--
<TABLE  <?php echo $width?> CELLPADDING="5" CELLSPACING="0" border="1px" style="page-break-before: always">
	<COL WIDTH="90px">
	<COL WIDTH="374px">
	<COL WIDTH="56px">
	<COL WIDTH="164px">
	<TR>
		<TD WIDTH="90px" BGCOLOR="#e6e6e6" align="center">
			<b>Ano / Período</b>
		</TD>
		<TD WIDTH="374px" BGCOLOR="#e6e6e6" align="center">
			<b>Estágio Supervisionado</b>
		</TD>
		<TD WIDTH="56px" VALIGN="top" BGCOLOR="#e6e6e6" align="center">
			<b>Carga Horária</b>
		</TD>
		<TD WIDTH="164px" BGCOLOR="#e6e6e6" align="center">
			<b>Conceito</b>
		</TD>
	</TR>
	<TR>
		<TD ROWSPAN="2" WIDTH="90px" align="center">
			XX/XX/XXXX<br/>a<br/>XX/XX/XXXX
		</TD>
		<TD WIDTH="374px" VALIGN="top" BGCOLOR="#e6e6e6" align="center">
			<b>Local</b>
		</TD>
		<TD ROWSPAN="2" WIDTH="56px" VALIGN="middle" align="center">
			XXX
		</TD>
		<TD ROWSPAN="2" WIDTH="164px"  VALIGN="middle" align="center">
			"APTO"
		</TD>
	</TR>
	<TR>
		<TD WIDTH="374" VALIGN="top" align="center">
			XXXXXXXXXXXXXXXXXXXXX<br/>
			XXXXXXXXX-XX
		</TD>
	</TR>
</TABLE>
-->

<br/><br/>

<!--Rodapé-->
<b>Observações:</b> <br/>
<B>Regime do Curso:</B>  <?php echo $curso->regime?><br/>
<B>Duração do Curso:</B> <?php echo $curso->quant_modulos?> semestres.<br/>
<B>Carga horária total:</B> <?php echo $curso->carga_horaria_total?> horas.<br/>
<table border="0" CELLPADDING="0" CELLSPACING="0"  <?php echo $width?>>
<tr>
  <td><b>Menção:</b></td> 
  <td>APTO – O aluno desenvolveu as competências previstas para o módulo</td>
</tr>
<tr>
  <td></td>
  <td>EM CONSTRUÇÃO – O aluno está em processo de desenvolvimento das competências requeridas para o módulo.</td>
</tr>
</table>
<B>Hora/Aula:</B> <?php echo $curso->hora_aula?> minutos<br/>
<br/><br/>
<p>Palmas, <?php echo getTranslatedDate()?>.</p>
<br/><br/>


<TABLE <?php echo $width?>>
	<TR VALIGN=TOP>
		<TD WIDTH="45%" align="center">
      ______________________________________<br/>
			Coordenação de Registros Escolares
		</TD>
		<TD WIDTH="10%" >
		</TD>
		<TD WIDTH="45%" align="center">
      ______________________________________<br/>
			Diretoria de Ensino
		</TD>
	</TR>
</TABLE>

<br/><br/>
<DIV>
	NOME: <?php echo $aluno->nome?><br/>
	Documento sem emendas ou rasuras.
</DIV>
<br/><br/><br/>

