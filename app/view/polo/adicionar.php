
<h2>{{<?php echo (action=='adicionar') ? 'Adicionar Pólo' : 'Editar Pólo';  ?>}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
	<form method="post">
		<input type="hidden" id="id" name="id" value="<?php echo Post::getVal('id') ?>" />
		<p>
			<label for="titulo">{{Descrição}}:</label>
			<input id="descricao" name="descricao" value="<?php echo Post::getVal('descricao') ?>" size="30" />
		</p>
		<p class="submit">
			<input type="submit" value="{{Enviar}}" /> {{ou}} <a href="<?php echo new Link('polo') ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>
