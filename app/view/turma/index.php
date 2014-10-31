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
<h2>{{Turmas}}</h2>
<span class="desc"><!--desc--></span>
<ul class="submenu">
	<li>[<a href="<?php echo new Link("turma:adicionar") ?>">{{Adicionar Turmas}}</a>]</li>
  <li>[<a href="<?php echo new Link("turma:conselho") ?>">{{Ficha do Conselho}}</a>]</li>
  <li>[<a href="<?php echo new Link("turma:historico") ?>">{{Histórico Escolar}}</a>]</li>
	<li>[<a href="<?php echo new Link("turma:reprovados") ?>">{{Alunos Reprovados}}</a>]</li>
	<li>[<a href="<?php echo new Link("turma:aprovados") ?>">{{Alunos Aprovados}}</a>]</li>
</ul>

<form id="frm" name="frm" method="post">
    <fieldset>
    Curso
    <?php createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'), true, true, "Todos", "onchange='frm.submit();'");?>
    </fieldset>
</form>

<?php if (count($itens)){ ?>
<table width="100%">
	<tr>
    <th width="200">{{Curso}}</th>
		<th>{{Pólo}}</th>
		<th>{{Módulo}}</th>
		<th>{{Semestre}}</th>
		<th width="100">{{Ações}}</th>
	</tr>
	<?php foreach($itens as $o): ?>
	<tr class="item">
		<td><?php echo $o->curso ?></td>
		<td><?php echo $o->polo ?></td>
		<td><?php echo $o->num_modulo . '-' . $o->modulo ?></td>
		<td><?php echo $o->semestre ?></td>
		<td><a href="<?php echo new Link('turma:alterar', "id={$o->id}") ?>">{{Alterar}}</a> | <a class="confirm" title="{{Excluir item}}: <?php echo $o->descricao ?>" href="<?php echo new Link('turma:excluir', "id={$o->id}") ?>">{{Excluir}}</a></td>
	</tr>
	<?php endforeach; ?>
</table>

<?php } else{ ?>
<h3>{{Nenhuma turma cadastrada}}</h3>
<?php } ?>
