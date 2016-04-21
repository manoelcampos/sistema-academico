
<h2>{{<?php echo (action=='adicionar') ? 'Adicionar Módulo' : 'Editar Módulo';  ?>}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
	<form method="post">
		<input type="hidden" id="id" name="id" value="<?php echo Post::getVal('id') ?>" />
		<p>
    <label for="id_curso">Curso</label>
    <?
     createComboBox($cursos, "id", "descricao", "id_curso", Post::getVal("id_curso"), true, true, "", $events="onchange='frm.submit.click();'");
    ?>
    </p>
		
		<p>
			<label for="descricao">{{Descrição}}:</label>
			<input id="descricao" name="descricao" value="<?php echo Post::getVal('descricao') ?>" size="30" />
		</p>

		<p>
			<label for="qualificacao">{{Qualificação}}:</label>
			<input id="qualificacao" name="qualificacao" value="<?php echo Post::getVal('qualificacao') ?>" size="30" />
		</p>

		<p>
			<label for="ordem">{{Ordem}}:</label>
			<input id="ordem" name="ordem" value="<?php echo Post::getVal('ordem') ?>" size="30" />
		</p>

		<p class="submit">
			<input type="submit" value="{{Enviar}}" /> {{ou}} 
      <a href="<?php echo new Link('modulo') ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>
