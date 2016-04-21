
<h2>{{Módulo}}</h2>
<span class="desc"><!--desc--></span>
<ul class="submenu">
	<li>[<a href="<?= new Link("modulo:adicionar") ?>">{{Adicionar novo Módulo}}</a>]</li>
</ul>
<?if (count($itens)){ ?>
<table width="100%">
	<tr>
		<th>{{Curso}}</th>
		<th>{{Descrição}}</th>
		<th>{{Qualificação}}</th>
		<th>{{Ordem}}</th>
		<th width="100">{{Ações}}</th>
	</tr>
	<?foreach($itens as $o): ?>
	<tr class="item">
		<td><?=$o->curso ?></td>	
		<td><?=$o->descricao ?></td>
		<td><?=$o->qualificacao ?></td>
		<td><?=$o->ordem ?></td>
		<td>
		  <a href="<?=new Link('modulo:alterar', "id={$o->id}") ?>">{{Alterar}}</a> | 
  		<a class="confirm" title="{{Excluir item}}: <?=$o->descricao ?>" href="<?=new Link('modulo:excluir', "id={$o->id}") ?>">{{Excluir}}</a>
  	</td>
	</tr>
	<?endforeach; ?>
</table>

<?php }else{ ?>
<h3>{{Nenhum módulo cadastrado}}</h3>
<?php } ?>
