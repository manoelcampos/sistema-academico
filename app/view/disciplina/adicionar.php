<?php
/* 
 * Copyright (c) 2008, Carlos André Ferrari <[carlos@]ferrari.eti.br>; Luan Almeida <[luan@]luan.eti.br>
 * All rights reserved. 
 */
 
/**
 * Sample of a framework view to add or update a Exemplo field
 * @package SampleApp
 * @subpackage View
 */
 
?>

<h2>{{<?= (action=='adicionar' ? 'Adicionar Disciplina' : 'Editar Disciplina');  ?>}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
	<form name="frm" id="frm" method="post">
		<input type="hidden" id="id" name="id" value="<?=Post::getVal('id') ?>" />

		<p>
			<label >{{Curso}}: <?=$curso->descricao?></label>
		</p>

		<p>
			<label for="id_modulo">{{Módulo}}:</label>
			<?=createComboBox($modulos, "id", "descricao", "id_modulo", Post::getVal("id_modulo"));?>
		</p>

		<p>
			<label for="descricao">{{Descrição}}:</label>
			<input id="descricao" name="descricao" value="<?=Post::getVal('descricao') ?>" size="60" maxlength="100" />
		</p>

		<p>
			<label for="sigla">{{Sigla}}:</label>
			<input id="sigla" type="text" name="sigla" value="<?=Post::getVal('sigla') ?>" size="20" maxlength="10"/>
		</p>

		<p>
			<label for="carga_horaria">{{Carga Horária}}:</label>
			<input id="carga_horaria" name="carga_horaria" value="<?=Post::getVal('carga_horaria') ?>" size="5" maxlength="3"/>
		</p>
		
		<p class="submit">
			<input type="submit" value="{{Enviar}}" /> {{ou}} 
			<a href="#" onclick="window.close()" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>
