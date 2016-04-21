<h2>{{Avaliações}}</h2>
<span class="desc"><!--desc--></span>

<fieldset>
  <form method="post" name="frm" id="frm">
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
    else if(post and p("id_curso")>0) {
      echo "Módulo";
      createComboBox($modulos, "id", "ordem_descricao", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
      echo "<p/>";
    }

    if(post) {
      if(p("id_modulo")>0) {
        echo "Disciplina";
        createComboBox($disciplinas, "id_disciplina", "descricao", "id_disciplina", p('id_disciplina'), true, true, "", "onchange='frm.submit();'");
      } 

      if(p('id_disciplina')>0) {?>
         <br/><br/>
         <input type="submit" value="Localizar" id="submit" name="submit" />
         <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>
         &nbsp;ou <a href="<?=new Link(Vortice::getView()) ?>">Voltar</a>
      <?
      }
    }
    ?>
  </form>
</fieldset>

<?
if(post && p("id_disciplina")>0):
  $urlcad = new Link("avaliacao:adicionar", "id_turma={$turma->id}&id_disciplina=".p("id_disciplina")."&popup=1")
?>
  <ul class="submenu">
	  <li>[<a href="#" onclick="popup('<?=$urlcad?>', '780px', '400px');">{{Adicionar nova Avaliação}}</a>]</li>
  </ul>
<?endif;?>

<?if(post && p("id_disciplina") > 0 && count($itens)) { ?>
<table width="100%">
	<tr>
		<th width="400px">{{Avaliação}}</th>
		<th width="100">{{Ações}}</th>
	</tr>
	<? 
  foreach($itens as $o): 
    $urlcad = new Link('avaliacao:alterar', "id={$o->id}&popup=1"); 
  ?>
	  <tr class="item">
		  <td><? echo $o->descricao ?></td>
		  <td>
          <a href="#" onclick="popup('<?=$urlcad?>', '780px', '400px');">{{Alterar}}</a> | 
          <a class="confirm" title="{{Excluir item}}: <?=$o->descricao ?>" href="<?=new Link('avaliacao:excluir', "id={$o->id}") ?>">{{Excluir}}</a>
      </td>
	  </tr>
	<? endforeach; ?>
</table>

<? }else{ ?>
<h3>{{Nenhuma avaliação cadastrada com os dados informados}}</h3>
<? } ?>
