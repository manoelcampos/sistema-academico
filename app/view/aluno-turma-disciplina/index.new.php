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
  <h2>{{Notas de Turma por Disciplina}}</h2>
  <span class="desc"><!--desc--></span>

  <form method="post" name="frm" id="frm">
   <fieldset>
    Pólo
    <?createComboBox($polos, "id", "descricao", "id_polo", Post::getVal('id_polo'));?>

    Curso
    <?createComboBox($cursos, "id", "descricao", "id_curso", Post::getVal('id_curso'));?>

    Módulo
    <?createComboBox($modulos, "id", "ordem_descricao", "id_modulo", Post::getVal('id_modulo'));?>
    <p/>
    <?
    $id_disciplina = 0;
    if(post) {
      $id_disciplina = Post::getVal('id_disciplina');
      $id_disciplina = (empty($id_disciplina) ? 0 : $id_disciplina);
      if(count($disciplinas)) {
        echo "Disciplina";
        createComboBox($disciplinas, "id_disciplina", "descricao", "id_disciplina", $id_disciplina, true, true, "", "onchange='frm.submit();'");
      } else echo "Nenhuma disciplina encontrada com os dados informados";
    }
    ?>

    <?if($id_disciplina==0):?>
    <input type="submit" name="localizar" id="localizar" value="Localizar" />
    <?else:
    echo "Avaliação";
    createComboBox($avaliacoes, "id_avaliacao", "descricao", "id_avaliacao", 
           Post::getVal('id_avaliacao'), true, false, "", "onchange='frm.submit();'");
    endif;?>

    <?if(post and $id_disciplina>0) :?>
       <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>&nbsp;
       <a href="<?=new Link('aluno-turma-disciplina') ?>">Voltar</a>
    <?endif;?>

   </fieldset>

   <?if(post && $id_disciplina>0):?>
    <h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> | <?=$turma->semestre?></h3>
    <br/>

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
        <?=$a->matricula?>
		  </td>
		  <td><?=$a->aluno?></td>
		  <td>
			  <input id="media_final<?=$a->id_aluno?>" size="7" maxlength="5" name="media_final<?=$a->id_aluno?>" value="<?=$a->media_final?>" size="10" />
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
			    <input type="submit" name="salvar" id="salvar" value="{{Salvar}}" />&nbsp;
          <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/> {{ou}} 
          <a href="<?=new Link('aluno-turma-disciplina') ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
        </td>
        <td><a href="#" onclick="window.scroolTo(0,0);" title="{{Topo da Página}}">{{Topo}}</a></td>
      </tr>
      </table>
		</p>
    </fieldset>
   <?endif;?>
	</form>
