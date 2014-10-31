<?php
function btnImprimir() {
  if(post and p('id_aluno_curso') > 0)  
     return "  <input type='button' name='imprimir' id='imprimir' accesskey='I' value='Imprimir' onclick='window.print(); frm.aluno.focus(); '/>";
  else return "";
}

$salvar = !strcmp(p("gerar"), "pdf");
$existem_alunos = (isset($alunos) && count($alunos) > 0);
if(!$salvar): 
?>
<form method="post" name="frm" id="frm">
 <fieldset>
  Pólo
  <?php createComboBox($polos, "id", "descricao", "id_polo", p('id_polo'), true, true);?>

  Curso
  <?php createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'));?>
  <p/>

  <?php
  if(p('aluno') != ""):
    echo "Nome do Aluno/Matrícula";
    createComboBox($alunos, "id", "nome_matricula", "id_aluno_curso", p('id_aluno_curso'), true, false); 
    if(count($alunos) > 1) :?>
        <span id="message" class="ok"><?php echo count($alunos);?> alunos encontrados</span>
    <?php
    endif;
  ?>
    <br/><br/><input type="submit" name="localizar" id="localizar" value="Nova Busca" accesskey="B"/>
  <?php
    if($existem_alunos) :?>
         <input type="submit" name="gerar" id="gerar" value="Gerar Relatório" accesskey="G"  />
    <?php endif;
  else:
  ?>
    Nome aluno, matrícula ou CPF
    <input type="text" name="aluno" id="aluno" maxlength="60" size="40" value="<?php echo p('aluno')?>"/>
    <br/><br/><input type="submit" name="localizar" id="localizar" value="Buscar" accesskey="B"/>
  <?php endif;?>

  <?php if(p('id_aluno_curso') != "") echo btnImprimir(); ?>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="<?php echo new Link(getIndexView()) ?>" title="{{Voltar para a página anterior}}">
    {{Voltar}}
    </a>
 </fieldset>
</form>
<?php 
endif;

if(p("gerar")) :
  require_once("modelo-historico3.php"); 
  /*gerar_historico(
        p("id_polo"), p("id_curso"), 
        $isHistoricoDefinitivo, $aluno, $aluno_curso, 
        $curso, $modulos_aluno, $config, virtualroot);*/
  if(!$salvar):
     echo "<fieldset>".  btnImprimir() . "</fieldset>";
  endif;
  
  if(p("imprimir")):?>
    <script language="javascript">
        window.print();
        //var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
        setTimeout(function(){window.close();}, 3000);
    </script>
  <?php
  endif;
endif;
