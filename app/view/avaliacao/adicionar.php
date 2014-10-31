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

<h2>{{<?php echo (action=='adicionar') ? 'Adicionar Avaliação' : 'Editar Avaliação';  ?>}}</h2>
<span class="desc"><!--desc--></span>
<h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> <?=$turma->semestre?></h3>
<h3>Disciplina: <?=$disciplina->descricao?></h3>
<fieldset>
  <form method="post" name="frm" id="frm">
		<input type="hidden" id="id" name="id" value="<?=Post::getVal('id') ?>" />
    <input type="hidden" id="id_turma" name="id_turma" value="<?=p('id_turma') ?>" />
    <input type="hidden" id="id_disciplina" name="id_disciplina" value="<?=p('id_disciplina') ?>" />
		<p>
			<label for="descricao">{{Descrição da Avaliação}}:</label>
			<input id="descricao" name="descricao" value="<?=Post::getVal('descricao') ?>" size="50" />
		</p>
   
		<p class="submit">
			<span id="loading"></span>
      <input type="submit" value="{{Enviar}}" name="enviar" id="enviar" /> {{ou}} 
      <a href="#" onclick="window.close()" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>


