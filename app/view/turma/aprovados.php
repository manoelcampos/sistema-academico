<?php
//ob_start();

function btnImprimir() {
  if (post):?>
     <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>
  <?php
  endif;
}

$ids_aluno_curso = p("id_aluno_curso");
$salvar = (post && p("salvar") && $ids_aluno_curso!="" && count($ids_aluno_curso)>0);
?>
    <form method="post" id="frm" name="frm">
     <fieldset>
      Pólo
      <?php createComboBox($polos, "id", "descricao", "id_polo", p('id_polo'), true, false);?>

      Curso
      <?php createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'), true, true, "", "onchange='frm.submit();'");?>

      <?php 
      if(post):
        if(p("id_curso")>0):
          echo "Módulo";
          createComboBox($modulos, "id", "ordem_descricao", "id_modulo", p('id_modulo'), true, true, "Todos", "onchange='frm.submit();'");
        endif;
        ?>
        <br/><input type="submit" value="Atualizar" />
        <?php
          btnImprimir();
      endif; 
      ?>
      &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo new Link(getIndexView()) ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
     </fieldset>
    </form>
<?php 
    if(post && p("id_curso") > 0):
        require_once "modelo_aprovados_modulo.php"; 
        echo "<fieldset>" . btnImprimir() . "</fieldset>";
    endif;


