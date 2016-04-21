<h2>{{Lançar Presenças e Conteúdo Lecionado}}</h2>
<span class="desc"><!--desc--></span>

<form method="post" name="frm" id="frm">
 <fieldset>
  <?
  echo "Pólo";
  createComboBox($polos, "id", "descricao", "id_polo", p('id_polo'), true, false);

  if(!Usuario::isTeacher()) {
    echo "Curso";
    createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'), true, true, "", "onchange='frm.submit();'");
  }

  if(Usuario::isTeacher()) {
    echo "Curso/Módulo";
    createComboBox($modulos, "id", "curso_modulo", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
  }
  else if(post && p("id_curso")>0) {
    echo "Módulo";
    createComboBox($modulos, "id", "ordem_descricao", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
    echo "<p/>";
  }

  if(post) {
    if(p("id_modulo")>0) {
      echo "Disciplina";
      createComboBox($disciplinas, "id_disciplina", "descricao", "id_disciplina", p('id_disciplina'), true, true, "", "onchange='frm.submit();'");
    }

    if(p('id_disciplina') > 0) {?>
       <input type="submit" name="submit" id="submit" value="Enviar" />       
    <?}
    
  }
  ?>
 </fieldset>
</form>

<?
if(post && p("id_disciplina")>0) : 
  $urlcad = new Link("dia-letivo:adicionar", "id_turma={$turma->id}&id_disciplina={$disciplina->id}&popup=1");
?>
[<a href='#' onclick="popup('<?=$urlcad?>', '780px', '600px');">
{{Registrar Presenças e Conteúdo para novo dia letivo}}
</a>]
<?endif;?>

<?if (post && p('id_disciplina') > 0 && count($dias_letivos)>0) { ?>
  <h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> <?=$turma->semestre?></h3>
  <br/>

  <table width="100%">
  <caption>Disciplina: <?=$disciplina->descricao?></caption>
  <tr>
     <th width="40px">Núm.</th>
     <th width="80px">Data</th>
     <th>Conteúdo Lecionado</th>
     <th>Aulas</th>     
     <th>Ações</th>
  </tr>
  <?
  $i=0;
  foreach($dias_letivos as $dia) : 
     $i++;
     $id=($i%2==0 ? "id=alternaterow" : "");
     $urlalter = new Link("dia-letivo:alterar", "id={$dia->id}&popup=1");
  ?>
  <tr <?=$id?>>
    <td align="right"><?=$i?></td>
    <td>
      <?=formatDateStr($dia->data, MasterController::displayDateFormat)?>
    </td>
    <td><?=str_replace("\n", "<br/>", $dia->conteudo);?></td>
    <td align="center"><?=$dia->quant_aulas?></td>
		<td><a href="#" onclick="popup('<?=$urlalter?>', '780px', '600px');">{{Alterar}}</a> </td>
  </tr>
  <?endforeach;?>
  </table>
  <a href="#" onclick="window.scroolTo(0,0);" title="{{Topo da Página}}">{{Topo}}</a>
<? } else { ?>
<h3>{{Nenhuma aula registrada na turma e disciplina informadas}}</h3>
<? } ?>
