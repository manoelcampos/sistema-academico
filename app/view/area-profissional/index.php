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
<h2>{{Áreas Profissionais}}</h2>
<span class="desc"><!--desc--></span>
<ul class="submenu">
	<li>[<a href="<?= new Link("area-profissional:adicionar") ?>">{{Adicionar nova Área Profissional}}</a>]</li>
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
		<td><a href="<?php echo new Link('area-profissional:alterar', "id={$o->id}") ?>">{{Alterar}}</a> | <a class="confirm" title="{{Excluir item}}: <?php echo $o->descricao ?>" href="<?php echo new Link('area-profissional:excluir', "id={$o->id}") ?>">{{Excluir}}</a></td>
	</tr>
	<?php endforeach; ?>
</table>

<?php }else{ ?>
<h3>{{Nenhuma área profissional cadastrada}}</h3>
<?php } ?>
