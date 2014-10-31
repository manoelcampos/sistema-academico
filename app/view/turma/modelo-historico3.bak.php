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

<table id="pg_frente" class="borderless"  border="0" cellpadding="0" cellspacing="0" height="920px">
<tr>
  <td colspan="3"  style="vertical-align: top" border="0" cellpadding="0" cellspacing="0" >
    <table class="borderless" <?php echo $width?> border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" width="180px">
          <img src="<?php echo virtualroot.'images/brasao.png'?>" />
        </td>
        <td>
          <span style="font-size: 12px; font-weight: bold">MINISTÉRIO DA EDUCAÇÃO<br/>
          SECRETARIA DE EDUCAÇÃO PROFISSIONAL E TECNOLÓGICA<br/>
          INSTITUTO FEDERAL DE EDUCAĆÃO, CIÊNCIA E TECNOLOGIA DO TOCANTINS<br/>
          CAMPUS PALMAS<br/>
          COORDENAÇÃO DE REGISTROS ESCOLARES</span>
        </td>
        <tr>
          <td colspan="2" align="center"><span style="font-size: 28px">HISTÓRICO ESCOLAR / ACADÊMICO</span></td>
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
			    <B>Data de Expedição:</B>   <?php echo formatDateStr($aluno->data_expedicao_rg)?>
		    </TD>
	    </TR>
	    <TR>
		    <TD>
			    <B>CPF:</B> <?php echo $aluno->cpf?>
		    </TD>
		    <TD colspan="2">
			    <B>Data de Nascimento:</B> <?php echo $aluno->data_nascimento?>
		    </TD>
        <td></td>
      </TR>
      <TR>
		    <TD COLSPAN="3" >
			    <B>Naturalidade:</B> <?php echo $aluno->naturalidade?>-<?php echo $aluno->uf_naturalidade?>
		    </TD>
		    <TD>
			    <B>Nacionalidade:</B> <?php echo $aluno->nacionalidade?>
		    </TD>
      </TR>
      <TR>
		    <TD colspan="4">
			    <B>Nome da Mãe:</B> <?php echo $aluno->nome_mae?>
		    </TD>
     </tr>
     <tr>
		    <TD colspan="4">
			    <B>Nome do Pai:</B> <?php echo $aluno->nome_pai?>
		    </TD>
      </TR>
      </table>

      <table class="borderless">
      <caption>DADOS DO CURSO</caption>
      <TR>
		    <TD COLSPAN="2" >
			    <B>Nome do Curso:</B> <?php echo $curso->descricao?>
		    </TD>
		    <TD COLSPAN="2" >
			    <B>Nível do Curso:</B> <?php echo $curso->nivel?>
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
          <B>Tipo	de processo seletivo e ano/sem:</B> <?php echo $aluno_curso->tipo_ingresso?> 2009/1
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="8" WIDTH="701px" >
			    <B>Carga horária total do curso:</B>  <?php echo $curso->carga_horaria_total?> horas
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="8" WIDTH="701px" >
          <B>Enade/ENEM/SAEB/outro sistema de avaliação quando aplicado:</B> Não se aplica
		    </TD>
	    </TR>
	    <TR>
		    <TD COLSPAN="8" WIDTH="701px" >
          <!--<B>Local e data de colação de grau:</B> Araguacema/TO, 27 de novembro de 2010 -->
					<B>Local e data de colação de grau:</B> Palmas/TO, 1o. de março de 2013
		    </TD>
	    </TR>
    </TABLE>
  </td>
</tr>
<tr>
<td colspan="3" style="border: 1px solid; 	padding-left: 3px;	padding-right: 3px;">
<b>PERFIL DO EGRESSO</b>:<br/>
<!--
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
O Técnico em Secretariado está habilitado para atuar em assistência e assessoria junto às chefias, 
às diretorias e às gerências de organizações públicas ou privadas, auxiliando-os nos serviços e atividades 
inerentes à sua função no processo decisório e na ação organizacional.<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;É um profissional capaz de:
<ul>
  <li>atuar de forma participativa com o todo empresarial, colaborando no alcance dos objetivos da organização;</li>
  <li>planejar e administrar o seu tempo e tarefas, buscando qualidade no desenvolvimento do trabalho com sua chefia ou departamento;</li>
  <li>atender e recepcionar pessoas, inclusive utilizando o idioma da língua inglesa;</li>
  <li>selecionar, direcionar e acompanhar o fluxo de correspondências e agilizar informações;</li>
  <li>redigir textos e documentos administrativos de forma qualitativa e funcional, usando processadores de textos, agendas, planilhas eletrônicas e bancos de dados em microcomputadores;</li>
  <li>organizar arquivos e informações departamentais;</li>
  <li>preparar e assessorar viagens e reuniões empresariais;</li>
  <li>assessorar na organização de eventos institucionais de pequeno e médio porte;</li>
  <li>mediar conflitos nas relações interpessoais no ambiente de trabalho;</li>
  <li>aprender a atualizar-se constantemente de acordo com as exigências do mercado de trabalho, buscando o aperfeiçoamento;</li>
  <li>atuar segundo os princípios do código de ética da categoria.</li>
</ul>
-->

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
O perfil do profissional Técnico em Agroecologia será de atuação de 
Assistência Técnica e Extensão Rural (ATER),
atuando em projetos de desenvolvimento rural sustentável com base na agroecologia, 
incentivando a incorporação de atividades florestais, de agroindústria, 
piscicultura, apicultura, turismo rural e  o uso e manejo sustentado dos recursos naturais. 
São atribuições do Técnico em Agroecologia:
<ul>
  <li>Identificar, caracterizar e correlacionar os sistemas e ecossistemas, os elementos que os compõem e suas respectivas funções;</li>
  <li>Elaborar o Planejamento e Projetos de Estudo da Vocação Regional;</li>
  <li>Elaborar e Gerenciar Projetos de Desenvolvimento Sócio Econômico e Ambiental na região;</li>
  <li>Classificar os recursos naturais (água, ar, florestas, animais e solo), segundo seus usos, correlacionando as características físicas, químicas e biologicas com sua produtividade;</li>
  <li>Identificar a capacidade de uso e manejo do solo e dos recursos hidricos;</li>
  <li>Identificar características básicas de atividades de exploração de recursos naturais renováveis e não renováveis que intervêm no meio ambiente;</li>
  <li>Desempenhar um papel educativo, atuando como animadores e facilitadores de processos de desenvolvimento sustentável;</li>
  <li>Privilegiar o potencial endógeno das comunidades tradicionais, resgatar e interagir com os conhecimentos dos agricultores familiares e demais povos que vivem e trabalham no campo em regime de economia familiar, e estimular o uso dos recursos locais;</li>
</ul>
</td>
</tr>
<tr height="140px">
  <td align="center" >
    ________________________________<br/>
    <b>Liliane Flávia Guimarães da Silva</b><br/>
    Diretora de Ensino<br/>
  </td>
  <td>&nbsp;&nbsp;&nbsp;</td>
  <td align="center">
    ________________________________<br/>
    <b>Ronaldo Vasconcelos da Silva</b><br/>
    Coordenador de Certificacão<br/>
  </td>
</tr>
</table>
<br />

<table id="pg_verso" class="borderless" CELLPADDING="0" CELLSPACING="0" height="910px">
<!--<table id="pg_verso" class="borderless" CELLPADDING="0" CELLSPACING="0" height="750px">-->
<tr>
<td colspan="2" style="vertical-align: top" >
<TABLE class="tab" <?php echo $width?> CELLPADDING="1px" CELLSPACING="0" border="1px" <?php echo $style?>>
<caption>MATRIZ CURRICULAR / FREQUÊNCIA / APROVEITAMENTO</caption>
<tr>
	<TD align="center">P*</TD>
  <TD align="center">A*</TD>
	<TD WIDTH="400px">Componentes Curriculares	</TD>
  <TD align="center">CH*</TD>
  <TD align="center">Nota Final</TD>
  <TD align="center">Frequência %</TD>
  <TD align="center">Aproveitamento</TD>
</tr>
<? 
$i=0;
foreach($modulos_aluno as $m): 
  $i++;
  $style=($i==1 ? "style='page-break-after: no;'" : "");
?>
	<TR>
		<TD VALIGN="middle" align="center" >
			<div class="vert"><?php echo arabicToRoman($i)?>&nbsp;Módulo</div>
		</TD>
		<TD VALIGN="middle" align="center">
			<div class="vert"><?php echo $m->semestre?></div>
		</TD>
		<TD>
      <?
      $carga_horaria_modulo = 0;
      foreach($m->notas_disciplina as $nd) {
        $carga_horaria_modulo += $nd->carga_horaria;
        echo "$nd->disciplina<br/>";
      }
      ?><br/>
		</TD>
		<TD WIDTH="60px"  align="center">
      <?
      foreach($m->notas_disciplina as $nd)
			  echo "$nd->carga_horaria<br/>";
      ?><br/>
		</TD>
    <td align="right">
      <?
      foreach($m->notas_disciplina as $nd) 
        echo "$nd->media_final<br/>";
      ?><br/>
    </td>
		<TD WIDTH="84px"  align="center">
			100%
		</TD>
		<TD WIDTH="139px" align="center">
			"<?php echo $m->conceito?>"
		</TD>
	</TR>
<? endforeach; ?> <!--Módulos e suas disciplinas-->
  <tr>
		<TD colspan="7">
		OBSERVACÕES: P* = Período; A* = Ano; CH* = Carga Horária<br/><br/><br/><br/>
		O estudante concluiu as 200 horas de atividades complementares.
		</TD>
	</TR>
  <tr><td colspan="7" align="right" >Palmas/TO, <?php echo strtolower(getTranslatedDate())?>.</td></tr>
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
