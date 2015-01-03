<?php
/**
 * Indica, ao percorrer a lista de disciplinas
 * em um laço, se passou de um módulo para outro.
 * Se sim, retorna um código css a ser usado
 * para incluir um separador entre as disciplinas
 * @param int $numColDisciplina Índice do laço que representa o número da disciplina
 */
function mudouDeModulo($total_disciplinas_modulo, $numColDisciplina) {
    if(isset($total_disciplinas_modulo)) {
        $achou = array_search($numColDisciplina, $total_disciplinas_modulo);
        if($achou) 
           return "border-right: 1px solid;";
    }    
    return "";
}
?>

<script language="javascript">
    function salvar_pdf(){
        document.getElementById("salvar").value = "1";
        document.getElementById("frm_alunos").submit();
    }
    
    function selecionar(check) {
        var id_aluno_curso = document.getElementsByName("id_aluno_curso[]");
        for(var i = 0; i < id_aluno_curso.length; i++) {
            id_aluno_curso[i].checked = check;
        }
    }
    
    function alterar_data() {
        var data_colacao_grau = document.getElementById("data_colacao_grau");
        if(data_colacao_grau.value === "") {
            data_colacao_grau.focus();
            window.alert("Informe a data de colação de grau");
            return false;
        }            
        
        /*var field = document.getElementsByName("id_aluno_curso");
        var selecionados = 0;
        for(var i = 0; i < field.length; i++){
            (field[i].checked ? selecionados++ : "");
        }
        if(selecionados === 0) {
            window.alert("Selecione algum aluno");
            return false;
        }*/            

        if(window.confirm("Tem certeza que deseja registrar a data para os alunos selecionados?")) {
            document.getElementById("alterar_data_colacao").value = "1";
            document.getElementById("frm_alunos").submit();
            return true;
        }
        
        return false;
    }
</script>
    
<form method="post" id="frm_alunos" name="frm_alunos">
    <input type="hidden" id="salvar" name="salvar" value="" />
    <input type="hidden" id="alterar_data_colacao" name="alterar_data_colacao" value="" />
    
    <fieldset>
        <p><input type="button" value="Salvar Históricos Selecionados" onclick="return salvar_pdf();"/></p>
    </fieldset>
    
    <table width="100%">
      <caption>
            <!--caption-->
      </caption>
      <thead>
        <?php if(isset($turmas)):?>
        <tr>
            <th style="width: 50px"></th>
            <th></th>
            <?php 
            $soma = 0;
            $total_disciplinas_modulo = array(0);
            for($i=0; $i<count($turmas); $i++) :
                $soma += $turmas[$i]->total_disciplinas;
                $total_disciplinas_modulo[] = $soma;
            ?>
                <th colspan="<?php echo $turmas[$i]->total_disciplinas; ?>" style="border-right: 1px solid; text-align: center">
                    Módulo <?php echo $i+1; ?>
                </th>
            <?php 
            endfor;
            ?>
        </tr>
        <?php endif; ?>
        <tr>
          <th><input type="checkbox" value="Todos" name="cbxAll" id="cbxAll" onclick="javascript:selecionar(this.checked);"  />Núm.</th>
          <th>Aluno</th>
          <?php 
          $legenda = "| ";
          $j=0;
          foreach($disciplinas_turma as $d) {
              $legenda .= "$d->sigla: $d->descricao | ";
              $j++;
              //quanto o valor do índice j for encontrado no vetor,
              //indica que mudou de um módulo para outro e deve-se
              //incluir um separador
              $separador = mudouDeModulo($total_disciplinas_modulo, $j);
          ?>
              <th style="text-align: right; <?php echo $separador; ?>"><?php echo $d->sigla; ?></th>
          <?php } ?>
        </tr>
      </thead>

      <!-- Alunos -->
      <form></form>
      <?php foreach($itens as $o): ?>
      <tr> 

          <td align="right" width="30px">
            <?php if(p("id_modulo")==0):?>
              <input type="checkbox" name="id_aluno_curso[]" value="<?php echo $o->id_aluno_curso ?>" />    
            <?php endif;?>
            <?php echo str_pad($o->num, 2, "0", STR_PAD_LEFT);?>
        </td>
        <td>
            <?php echo $o->aluno;?>
            <?php if(p("id_modulo")==0):?>
            <p>
                <form method="post" target="_blank" 
                action="<?php echo new Link("turma:historico")?>"> 
                    <input type="hidden" name="id_polo" value="<?php echo p("id_polo")?>" />
                    <input type="hidden" name="id_curso" value="<?php echo p("id_curso")?>" />
                    <input type="hidden" name="id_aluno_curso" value="<?php echo $o->id_aluno_curso?>" />
                    <input type="hidden" name="gerar" value="gerar" />
                    <input type="hidden" name="numero" value="<?php echo $o->num ?>" /> 
                    <input type="hidden" name="imprimir" value="true" /> 
                    <input type="button" onclick="this.form.submit();" value="Histórico" />
                </form>
            </p>
            <?php endif;?>
        </td>
            <!-- Notas das Disciplinas -->
            <?php 
            $j = 0;
            foreach($o->notas as $nota) :
                $j++;
                $separador = mudouDeModulo($total_disciplinas_modulo, $j);
                $cor = "";
                if($nota->id_conceito==2 || $nota->media_final == 0.0): //reprovado
                   $cor = "color: red; ";
                endif;
            ?>
                <td style="text-align: right; <?php echo $cor . $separador;?>">
                    <?php echo $nota->media_final?>
                </td>
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
    
    <?php if(p("id_modulo")==0):?>
    <fieldset>
        <input type="hidden" name="id_polo" value="<?php echo p("id_polo")?>" />
        <input type="hidden" name="id_curso" value="<?php echo p("id_curso")?>" />
        <div>
            <br/>
            <label>
                Data de Colação de Grau: 
                <input type="text" name="data_colacao_grau" id="data_colacao_grau" maxlength="10" size="10"/>
            </label>
            <input type="button" 
                   value="Registrar Data de Colação de Grau para os alunos selecionados"
                   onclick="return alterar_data();"/>
        </div>
    </fieldset>
    <?php endif;?>
    </form>

