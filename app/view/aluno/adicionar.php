<h2>{{<?php echo (action=='adicionar') ? 'Adicionar Aluno' : 'Editar Aluno';  ?>}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
	<form method="post">
		<input type="hidden" id="id" name="id" value="<?php echo Post::getVal('id') ?>" />
		<p>
			<label for="nome">{{Nome}}:</label>
			<input id="nome" name="nome" value="<?php echo Post::getVal('nome') ?>" size="30" />
		</p>
		<p class="submit">
			<input type="submit" value="{{Enviar}}" /> {{ou}} <a href="<?php echo new Link('aluno') ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>
