<h2>{{Alunos}}</h2>
<span class="desc"><!--desc--></span>
<ul class="submenu">
	<li>[<a href="<?= new Link("aluno:adicionar") ?>">{{Adicionar novo Aluno}}</a>]</li>
</ul>
<?php if (count($itens)){ ?>
<table width="100%">
	<tr>
		<th width="400px">{{Nome}}</th>
		<th width="100">{{Ações}}</th>
	</tr>
	<?php foreach($itens as $o): ?>
	<tr class="item">
		<td><?php echo $o->nome ?></td>
		<td><a href="<?php echo new Link('aluno:alterar', "id={$o->id}") ?>">{{Alterar}}</a> | <a class="confirm" title="{{Excluir item}}: <?php echo $o->nome ?>" href="<?php echo new Link('aluno:excluir', "id={$o->id}") ?>">{{Excluir}}</a></td>
	</tr>
	<?php endforeach; ?>
</table>

<?php }else{ ?>
<h3>{{Nenhum curso cadastrado}}</h3>
<?php } ?>
