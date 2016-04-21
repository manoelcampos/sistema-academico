<script language="javascript">
    function filtrar() {
        var enviar = document.getElementById("enviar");
        enviar.value="0";
        var frm = document.getElementById("frm");
        frm.submit();
        return true;
    }

    function enviarForm() {
        var enviar = document.getElementById("enviar");
        enviar.value="1";
        var frm = document.getElementById("frm");
        frm.submit();
        return true;
    }

    function validar() {
        var semestre = document.getElementById("semestre_inserir");
        if(semestre.value=="") {
            semestre.focus();
            window.alert("Informe o semestre");
            return false;
        }
        return true;
    }
</script>

<h2>{{<?php echo (action=='adicionar') ? 'Adicionar Turmas' : 'Editar Turma';  ?>}}</h2>
<span class="desc"><!--desc--></span>

<form method="post" id="frm" name="frm" onsubmit="return validar();">
 <fieldset>
  <input type="hidden" name="enviar" id="enviar" value="0"/>
  Ano/Semestre (AAAA/S) <input type="text" maxlength="6" 
                              id="semestre_inserir" name="semestre_inserir" size="8" 
                              value="<?php echo p("semestre_inserir");?>"/><br/>
  
  
  <div>
  Pólos:&nbsp;
  <?php
  if(post && ($id_polo = p("id_polo"))) {      
      array_unshift($id_polo, "");
  }
  foreach($polos as $polo) {
      $checked = "";
      if(post && $id_polo) {
        if(array_search($polo->id, $id_polo))
           $checked = "checked='checked'";
      }
      ?>
      <label>
        <input type="checkbox" name="id_polo[]" value="<?php echo $polo->id?>" <?php echo $checked;?> />
        <?php echo $polo->descricao; ?>
      </label>
      <?php
  }
  ?>
  </div>
  <br/><br/>
  Curso
  <?php createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'), true, true, "Selecione um curso", "onchange='filtrar();'");?>
  
  <?php 
  if(post) {
    if(p("id_curso")>0) {
      echo "Módulo";
      createComboBox($modulos, "id", "ordem_descricao", "id_modulo", p('id_modulo'), true, true, "Selecione um módulo", "onchange='filtrar();'");
      
      if(p("id_modulo")>0) {?>
          <br/><input type="submit" value="Inserir Turmas" onclick="return enviarForm();"/>
      <?
      }
    }
    
    ?>
    
    <?php
  }  
  ?>
  &nbsp;&nbsp;|&nbsp;&nbsp; <a href="<?php echo new Link(getIndexView()) ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
 </fieldset>
</form>
