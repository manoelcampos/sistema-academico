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

<?$adicionar=(action=='adicionar');?>
<h2>{{Notas da Disciplina}}</h2>
<span class="desc"><!--desc--></span>
  <h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> | <?=$turma->semestre?></h3>
  <br/>

	<form name="frm" id="frm" method="post">
		<input type="hidden" id="id_turma" name="id_turma" value="<?=p('id_turma') ?>" />
    <table width="100%">
    <caption>Disciplina: <?=$disciplina->descricao?></caption>
    <tr><th>Núm.</th><th>Matrícula</th><th>Aluno</th><th>Média Final</th></tr>
    <?
    $i=0;
    foreach($alunos_turma as $a) : 
       $i++;
       $id=($i%2==0 ? "id=alternaterow" : "");
    ?>
    <tr <?=$id?>>
		  <td align="center"><?=$i?></td>
		  <td>
			  <input type="hidden" id="id_aluno<?=$i?>" name="id_aluno<?=$i?>" value="<?=$a->id_aluno?>" size="10" />
        <?=$a->matricula?>
		  </td>
		  <td><?=$a->aluno?></td>
		  <td>
			  <input id="media_final<?=$i?>" size="7" maxlength="5" name="media_final<?=$i?>" value="<?=$a->media_final?>" size="10" />
		  </td>
    </tr>
    <?endforeach;?>
    </table>

    <br/>
    <fieldset>
		<p class="submit">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="94%">
			    <input type="submit" value="{{Enviar}}" />&nbsp;
          <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/> {{ou}} 
          <a href="<?php echo new Link('aluno-turma-disciplina') ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
        </td>
        <td><a href="#" onclick="window.scroolTo(0,0);" title="{{Topo da Página}}">{{Topo}}</a></td>
      </tr>
      </table>
		</p>
    </fieldset>
	</form>
