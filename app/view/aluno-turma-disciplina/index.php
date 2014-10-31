<?php
/* 
 * Copyright (c) 2008, Carlos André Ferrari <[carlos@]ferrari.eti.br>; Luan Almeida <[luan@]luan.eti.br>
 * All rights reserved. 
 */
 
/**
 * Sample of a framework view to List Exemplo objects
 * @package SampleApp
 * @subpackage View
 */
?>
<h2>{{Resultado por Disciplina}}</h2>
<span class="desc"><!--desc--></span>

<form method="post" name="frm" id="frm">
 <fieldset>
  <?php
  echo "Pólo";
  createComboBox($polos, "id", "descricao", "id_polo", p('id_polo'), true, false);

  if(!Usuario::isTeacher()) {
    echo "Curso";
    createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'), true, true, "", "onchange='frm.submit();'");
  }

  if(Usuario::isTeacher()) {
    echo "Curso/Módulo";
    createComboBox($modulos, "id", "curso_modulo", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
  }
  else if(post && p("id_curso")>0) {
    echo "Módulo";
    createComboBox($modulos, "id", "ordem_descricao", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
    echo "<p/>";
  }

  if(post) {
    if(p("id_modulo")>0) {
      echo "Disciplina";
      createComboBox($disciplinas, "id_disciplina", "descricao", "id_disciplina", p('id_disciplina'), true, true, "", "onchange='frm.submit();'");
    }

    if(p('id_disciplina') > 0) {?>
       <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>
    <?php }
  }
  ?>
	<input type="submit" name="submit1" id="submit1" value="Atualizar" />	
 </fieldset>
</form>

<?php if (post && p('id_disciplina') > 0 && $alunos_turma && count($alunos_turma)) { ?>
	<h3>Pólo: <?php echo $turma->polo;?> | Curso: <?php echo $turma->curso;?> | <?php echo $turma->modulo;?> <?php echo $turma->semestre;?></h3>
	<br/>

	<table width="100%">
	<caption>Disciplina: <?echo $disciplina->descricao;?></caption>
	<tr><th>Núm.</th><th>Matrícula</th><th>Aluno</th><th style="text-align: right">Média Final</th><th class="noprint">Ações</th></tr>
	<?php
	$i=0;
	foreach($alunos_turma as $a) : 
		 $i++;
		 $id=($i%2==0 ? "id=alternaterow" : "");
	?>
	<tr <?php echo $id;?>>
		<td align="center"><?php echo $i;?></td>
		<td>
		  <?php echo $a->matricula;?>
		</td>
		<td><?php echo $a->aluno;?></td>
		<td style="text-align: right"><?php echo $a->media_final;?></td>
		<td class="noprint">
			<?php
		  $params = "id={$a->id}&id_turma={$a->id_turma}&id_disciplina={$a->id_disciplina}&popup=1";
			$link = new Link(getIndexView().':alterar', $params);
			?>
			<a href="#" onclick="popup('<?php echo $link; ?>', '780px', '600px');">{{Alterar}}</a>
		</td>
	</tr>
	<?php endforeach;?>
	</table>
	<a href="#" onclick="window.scroolTo(0,0);" title="{{Topo da Página}}">{{Topo}}</a>
<?php } else { ?>
	<h3>{{Nenhuma resultado cadastrado na turma e disciplina informadas}}</h3>
<?php } ?>
