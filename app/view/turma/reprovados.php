<?php
function btnImprimir() {
  if (post) {?>
     <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>
  <?php
  }
}
?>
<form method="post" id="frm" name="frm">
 <fieldset>
  Pólo
  <?php createComboBox($polos, "id", "descricao", "id_polo", p('id_polo'), true, false);?>

  Curso
  <?php createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'), true, true, "", "onchange='frm.submit();'");?>

  <?php 
  if(post) {
    if(p("id_curso")>0) {
      echo "Módulo";
      createComboBox($modulos, "id", "ordem_descricao", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
    }
    
    if(p("id_modulo") > 0) {
			?>
 	    <br/><input type="submit" value="Atualizar" />
			<?php
      btnImprimir();
		}
  }  
  ?>
  &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo new Link(getIndexView()) ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
 </fieldset>
</form>

<?php if(post && p("id_modulo") > 0):?>
<table width="100%">
  <caption>
		<!--caption-->
  </caption>
  <thead>
    <tr>
      <th>Núm.</th>
      <th>Aluno</th>
      <?php 
      $legenda = "| ";
      foreach($disciplinas_turma as $d): 
        $legenda .= "$d->sigla: $d->descricao | ";
      ?>
      <th style="text-align: right"><?php echo $d->sigla?></th>
      <?php endforeach;?>
    </tr>
  </thead>

  <!-- Alunos -->
  <?php foreach($itens as $o): ?>
  <tr> 
    <td align="right" width="30px"><?php echo $o->num?></td>
    <td><?php echo $o->aluno;?></td>
		<!-- Notas das Disciplinas -->
    <?php 
		foreach($o->notas as $nota) :
       $cor = "";
			 if($nota->id_conceito==2 || $nota->media_final == 0.0) //reprovado
         $cor = "color: red";
		?>
	     <td style="text-align: right; <?php echo $cor;?>"><?php echo $nota->media_final?></td>
		<?php 
		endforeach; 
		?>
  </tr>
  <?php endforeach; ?>

  <tfoot>
    <tr>
      <td align="center" colspan="<?php echo count($disciplinas_turma)+3?>">
        <?php echo $legenda?>
      </td>
    </tr>
  </tfoot>
</table>


<fieldset>
   <input type="submit" value="Atualizar" />
   <?php btnImprimir(); ?>
</fieldset>
<?php endif; ?>

