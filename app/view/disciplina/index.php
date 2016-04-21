
<h2>{{Disciplina}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
  <form method="post" name="frm" id="frm">
    Curso
    <?
     createComboBox($cursos, "id", "descricao", "id_curso", p("id_curso"), true, true, "", $events="onchange='frm.submit.click();'");
    ?>
    <input type="submit" name="submit" id="submit" value="Exibir" />
  </form>
</fieldset>
<ul class="submenu">
  
  <?
  if(p("id_curso")!="") :
    $urlcad=new Link("disciplina:adicionar", "id_curso=".p("id_curso")."&popup=1");
    ?>
	  <li>[<a href="#" onclick="popup('<?=$urlcad?>', '780px', '600px');">{{Adicionar nova Disciplina}}</a>]</li>
	<?endif;?>
</ul>
<?php if (count($itens)){ ?>
<table width="100%">
	<tr>
  	<th>{{Curso}}</th>
  	<th>{{Módulo}}</th>  	
		<th>{{Disciplina}}</th>
    <th>{{CH}}</th>
		<th width="100">{{Ações}}</th>
	</tr>
	<?php foreach($itens as $o): ?>
	<tr class="item">
	  <td><?=$o->curso ?></td>
	  <td><?=$o->ordem_modulo ?></td>	  
		<td><?=$o->descricao ?></td>
    <td><?=$o->carga_horaria ?></td>
		<td>
		 <?$urlcad=new Link('disciplina:alterar', "id_curso=".p("id_curso")."&id={$o->id}&popup=1")?>
 		 <a href="#" onclick="popup('<?=$urlcad?>', '780px', '600px');">{{Alterar}}</a> | 
	 	 <a class="confirm" title="{{Excluir item}}: <?=$o->descricao ?>" href="<?=new Link('disciplina:excluir', "id={$o->id}") ?>">{{Excluir}}</a>
		</td>
	</tr>
	<?php endforeach; ?>
</table>

<?php }else{ ?>
<h3>{{Nenhuma disciplina cadastrada}}</h3>
<?php } ?>
