<?php 
  $btnSalvar = "salvar";
?>

<script language="javascript">
  var btnSalvar = "<?=$btnSalvar?>";
  
  function filtrar() {
    if(document.getElementById('data').value != "") {
       limpar();
       return true;
    }
    return false;
  }
  
  function salvar() {
    document.getElementById(btnSalvar).value=btnSalvar;  
  }
  
  function limpar() {
    document.getElementById(btnSalvar).value='';
  }
  
  //http://docs.jquery.com/UI/Datepicker
  $(document).ready(function(){
    $.datepicker.setDefaults( { 
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dateFormat: 'dd/mm/yy'
      } 
    );
        
    $('#data').datepicker({
       onSelect: function(dateText, inst) {
          document.getElementById("enviar").click();
       }
    });
    
  });	
  

	$(function() {
		$( "#data" ).datepicker();
	});
</script>

<h2>{{Lançar Presenças e Conteúdo Lecionado}}</h2>
<span class="desc"><!--desc--></span>

<form method="post" name="frm" id="frm">
 <fieldset>
  <?
  $quant_aulas = "0";
  $data = "";
  $conteudo = "";
  //Se tem um parâmetro id, o usuário está alterando um registro,
  //assim, não existirão os parâmetros id_turma e id_disciplina
  if(p("id")){
    $quant_aulas = $dia->quant_aulas;
    $data = $dia->data;
    $conteudo = (Post::getVal($btnSalvar)=="" ? $dia->conteudo : Post::getVal("conteudo"));
  ?>
    <strong>Quantidade de Aulas</strong>: <?=$quant_aulas?>&nbsp;&nbsp;&nbsp;&nbsp;

    <!-- O campo não tem id para evitar que apareça o JQuery UI Datapicker, pois o usuário
    não pode alterar o mesmo na edição de um registro.-->
    <strong>Data Letiva</strong>: <?=formatDateStr($data)?>
  <?
  } else {
    if(post) {
      $quant_aulas = Post::getVal("quant_aulas");
      $data = Post::getVal("data");
      $conteudo = Post::getVal("conteudo");
    }      
  ?>
    <input type="hidden" name="id_turma" value="<?=p('id_turma')?>">
    <input type="hidden" name="id_disciplina" value="<?=p('id_disciplina')?>">

    Quantidade de Aulas
    <select id="quant_aulas" name="quant_aulas" onchange="document.getElementById('enviar').click();">
      <option value="0"></option>       
      <option value="1" <?=($quant_aulas==1 ? " selected " : "")?>>1</option>
      <option value="2" <?=($quant_aulas==2 ? " selected " : "")?>>2</option>
      <option value="3" <?=($quant_aulas==3 ? " selected " : "")?>>3</option>
      <option value="4" <?=($quant_aulas==4 ? " selected " : "")?>>4</option>                        
    </select>

    Data Letiva
    <input type="text" readonly="true" maxlength="10" size="8" id="data" name="data" value="<?=$data?>"/>
    <input type="submit" name="enviar" id="enviar" value="Enviar" onclick="return filtrar();" />             
  <?}?>
 </fieldset>

<?if ($quant_aulas > 0 && $data != "") { ?>
  <h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> <?=$turma->semestre?></h3>
  <h3>Disciplina: <?=$disciplina->descricao?></h3>
  <br/>
  <label for="conteudo"><strong>Conteúdo Lecionado</strong></label>
  <textarea id="conteudo" name="conteudo" rows="4" cols="10"><?=$conteudo?></textarea>
  <input type="submit" id="<?=$btnSalvar?>" name="<?=$btnSalvar?>" value="Salvar Conteúdo Lecionado e Presenças" onclick="salvar();">  
  
  <table width="100%">
  <caption>Presenças</caption>
  <tr>
     <th>Núm.</th>
     <th>Matrícula</th>
     <th>Aluno</th>
     <?for($i=1; $i<= $quant_aulas; $i++):?>
     <th><?=$i?>a.</th>
     <?endfor;?>
  </tr>
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
    <?
    for($j=1; $j<= $quant_aulas; $j++):
      //Nome do campo que armazena a frequencia para um determinado
      //aluno em determinada aula
      $checkBoxName = "aula$j" . "_aluno" . $a->id_aluno;
      //Se tem o parâmetro id é porque o usuário está editando um registro
      if(p("id")=="") {
        //indica se o aluno $a (número $i) está presente ou não na aula número $j
        $presente=Post::getVal($checkBoxName); 
        $checked = (Post::getVal($btnSalvar)=="") || ($presente=='1'); 
      }
      else {
        $fieldAula = "aula$j";
        //Se o usuário não clicou no salvar ainda, pega os registros da frequência dos alunos do campo $frequencia
        //(preenchido a partir de consulta ao BD, dentro da action alterar no Controller)
        if(Post::getVal($btnSalvar)=="")
            $presente = (isset($frequencia[$a->id_aluno]->$fieldAula) ? $frequencia[$a->id_aluno]->$fieldAula : "0");
        //Senão, o registro da frequência será obtido dos campos enviados via POST
        else $presente = Post::getVal($checkBoxName);
        $checked = ($presente=='1');
      }
    ?>
    <td><input type="checkbox" value="1" <?=($checked ? 'checked=checked' : '')?> name="<?=$checkBoxName?>" /></td>
    <?endfor;?>
  </tr>
  <?endforeach;?>
  </table>
  <table border="0" width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td width="94%">
      <input type="submit" id="<?=$btnSalvar?>" name="<?=$btnSalvar?>" value="Salvar Conteúdo Lecionado e Presenças" onclick="salvar();">
    </td>
    <td><a href="#" onclick="window.scroolTo(0,0);" title="{{Topo da Página}}">{{Topo}}</a></td>
  </tr>
  </table>
<? }  ?>
</form>
