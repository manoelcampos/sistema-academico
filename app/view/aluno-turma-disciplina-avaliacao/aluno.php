<h2>{{Notas de Disciplinas por Aluno}}</h2>
<span class="desc"><!--desc--></span>

<ul class="submenu">
  <?if(post):?>
	<li>
  [<a href="<?= new Link("aluno-turma-disciplina:adicionar", "id_turma={$turma->id}")?>">
  {{Adicionar nova Nota}}
  </a>]
  </li>

	<li>
  [<a href="<?= new Link("aluno-turma-disciplina:notas", "id_turma={$turma->id}")?>">
  {{Registrar Notas da Turma}}
  </a>]
  </li>
  <?endif;?>
</ul>

<h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> | <?=$turma->semestre?></h3>
<br/>

<form method="post">
 <fieldset>
    Aluno/Matrícula
    <?createComboBox($alunos_turma, "id_aluno", "aluno_matricula", "id_aluno", Post::getVal('id_aluno'));?>
    <input type="submit" name="localizar" id="localizar" value="Localizar" />
  <?if(post and Post::getVal('id_aluno')) :?>
     <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>
  <?endif;?>

 </fieldset>
</form>


<?php if (count($itens)){ ?>
<h3>Aluno(a): <?=$itens[0]->aluno?></h3>
<table width="100%">
	<tr>
		<th width="400">{{Disciplina}}</th>
		<th>{{Média}}</th>
		<th>{{Conceito}}</th>
		<th width="100">{{Ações}}</th>
	</tr>
	<?php foreach($itens as $o): ?>
	<tr class="item">
    <td><?php echo $o->disciplina ?></td>
    <td><?php echo $o->media_final ?></td>
    <td><?php echo $o->conceito ?></td>
		<td><a href="<?php echo new Link('aluno-turma-disciplina:alterar', "id={$o->id}") ?>">{{Alterar}}</a> | <a class="confirm" title="{{Excluir item}}: <?php echo $o->nome ?>" href="<?php echo new Link('aluno-turma-disciplina:excluir', "id={$o->id}") ?>">{{Excluir}}</a></td>
	</tr>
	<?php endforeach; ?>
</table>

<?php }else{ ?>
<h3>{{Nenhuma nota cadastrada para o aluno(a) na turma informada}}</h3>
<?php } ?>
