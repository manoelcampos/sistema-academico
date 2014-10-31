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
<h2>{{Cursos}}</h2>
<span class="desc"><!--desc--></span>
<ul class="submenu">
	<li>[<a href="<?= new Link("curso:adicionar") ?>">{{Adicionar novo Curso}}</a>]</li>
	<li>[<a href="<?= new Link("area-profissional") ?>">{{Áreas Profissionais}}</a>]</li>
	<li>[<a href="<?= new Link("modulo") ?>">{{Módulos}}</a>]</li>
	<li>[<a href="<?= new Link("disciplina") ?>">{{Disciplinas}}</a>]</li>
</ul>
<?php if (count($itens)){ ?>
<table width="100%">
	<tr>
		<th width="400px">{{Descrição}}</th>
		<th width="100">{{Ações}}</th>
	</tr>
	<?php foreach($itens as $o): ?>
	<tr class="item">
		<td><?php echo $o->descricao ?></td>
		<td><a href="<?php echo new Link('curso:alterar', "id={$o->id}") ?>">{{Alterar}}</a> | <a class="confirm" title="{{Excluir item}}: <?php echo $o->descricao ?>" href="<?php echo new Link('curso:excluir', "id={$o->id}") ?>">{{Excluir}}</a></td>
	</tr>
	<?php endforeach; ?>
</table>

<?php }else{ ?>
<h3>{{Nenhum curso cadastrado}}</h3>
<?php } ?>
