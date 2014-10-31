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
<h2>{{Notas de Aluno por Turma}}</h2>
<span class="desc"><!--desc--></span>

<form method="post">
 <fieldset>
  Pólo
  <?createComboBox($polos, "id", "descricao", "id_polo", Post::getVal('id_polo'));?>

  Curso
  <?createComboBox($cursos, "id", "descricao", "id_curso", Post::getVal('id_curso'));?>

  Módulo
  <?createComboBox($modulos, "id", "ordem_descricao", "id_modulo", Post::getVal('id_modulo'));?>
  <p/>
  <?if(post) {
    echo "Disciplina";
    createComboBox($disciplinas, "id_disciplina", "descricao", "id_disciplina", Post::getVal('id_disciplina'));
  }
  ?>
  <?
  if($turma and $turma->id)
      $titulo = "Selecionar Disciplina";
  else $titulo = "Localizar";
  ?>
  <input type="submit" name="localizar" id="localizar" value="<?=$titulo?>" />
  <?if(post and Post::getVal('id_disciplina')) :?>
     <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>
  <?endif;?>

 </fieldset>
</form>

<ul class="submenu">
  <?
  if(post and Post::getVal("id_disciplina")):
    $id_disciplina = Post::getVal("id_disciplina");
  ?>
	<li>
  [<a href="<?= new Link("aluno-turma-disciplina:adicionar", "id_turma={$turma->id}&id_disciplina={$id_disciplina}")?>">
  {{Registrar Nota de Aluno}}
  </a>]
  </li>

	<li>
  [<a href="<?= new Link("aluno-turma-disciplina:notas", "id_turma={$turma->id}&id_disciplina={$id_disciplina}")?>">
  {{Registrar Notas da Disciplina}}
  </a>]
  </li>
  <?endif;?> 
  <?if($turma and $turma->id):?>
	<li>
  [<a href="<?= new Link("aluno-turma-disciplina:aluno", "id_turma={$turma->id}")?>">
  {{Notas de Disciplinas por Aluno}}
  </a>]
  </li>
  <?endif;?>
</ul>

<?php if (count($alunos_turma)){ ?>
<h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> <?=$turma->semestre?></h3>
<br/>

<table width="100%">
<caption>Disciplina: <?=$disciplina->descricao?></caption>
<tr><th>Núm.</th><th>Matrícula</th><th>Aluno</th><th>Média Final</th></tr>
<?
$i=0;
foreach($alunos_turma as $a) : 
   $i++;
   $id=($i%2==0 ? "id=alternaterow" : "");
?>
<tr>
  <td align="center"><?=$i?></td>
  <td>
    <?=$a->matricula?>
  </td>
  <td><?=$a->aluno?></td>
  <td><?=$a->media_final?></td>
</tr>
<?endforeach;?>
</table>
<?php }else{ ?>
<h3>{{Nenhuma nota cadastrada na turma e disciplina informada}}</h3>
<?php } ?>
