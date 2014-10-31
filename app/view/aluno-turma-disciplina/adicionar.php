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
<?php $adicionar=(action=='adicionar');?>
<h2>{{<?php echo $adicionar ? 'Registrar Nota de Aluno' : 'Editar Nota de Aluno';  ?>}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
  <h3>Pólo: <?php echo $turma->polo;?> | Curso: <?php echo $turma->curso;?> | <?php echo $turma->modulo;?> | <?php echo $turma->semestre;?></h3>
  <br/>

	<form method="post">
		<input type="hidden" id="id" name="id" value="<?php echo Post::getVal('id'); ?>" />
    <?php if($adicionar):?>
		<input type="hidden" id="id_turma" name="id_turma" value="<?php echo p('id_turma'); ?>" />
    <?php endif;?>

		<?php 
			if(p('popup')!="") 
			  echo "		<input type=\"hidden\" id=\"popup\" name=\"popup\" value=\"1\" />";
		?>

    <?php
    if($adicionar) {
       echo "<label for='id_aluno'>Aluno(a):</label>";
       createComboBox($alunos_turma, "id_aluno", "aluno", "id_aluno", Post::getVal('id_aluno'));
    }
    else echo "<label>Aluno(a): ".$aluno->nome."</label>";
    ?>

		<p>
    <label for="id_disciplina">{{Disciplina}}:</label>
    <?php createComboBox($disciplinas, "id_disciplina", "descricao", "id_disciplina", p('id_disciplina'), false);?>
		</p>

		<p>
			<label for="media_final">{{Média Final}}:</label>
			<input id="media_final" name="media_final" value="<?php echo Post::getVal('media_final') ?>" size="10" />
		</p>
		<p class="submit">
			<input type="submit" value="{{Enviar}}" /> {{ou}} 
      <a href="#" onclick="window.close()" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>
