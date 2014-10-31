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

<script type="text/javascript">

function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    return out;
}

//Funcao criada para nao executar o código jquery.
//Para que ele seja executado, o código deve ser
//retirado do corpo da funcao.
function ignorarJQuery() {
$(document).ready(function(){
	$("#enviar").click(function(){ //quando clicar no botão submit
		var dados = $("#frm").serialize();
		$.ajax({
		   type: "POST", 
		   url: "<?=virtualroot.Vortice::getView()?>", 
		   data: dados,
       dataType: "json",
		   beforeSend: function(){ 
				$("#loading").html("<img src='<?=virtualroot?>/images/loading.gif' border='0' />");
		   },
       //JSon Error: {"status":0,"message":"Erros:","errors":[{"key":"descricao","value":"Digite a descricao"}],"packages":[]}        
		   success: function(retorno){ 
           var erroStr = "<p>"+retorno.message + "</p><ul>";
           for(i=0; i < retorno.errors.length; i++)
              erroStr += "<li>"+retorno.errors[i].value+"</li>";
           erroStr += "</ul>";

           $("<div id='message'  class='error'>"+erroStr+"</div>").appendTo("body")
           $("#loading").html("");
		   },
       error: function(retorno) {
           $("#conteiner").html(dump(retorno));
       } 
		 });
		return false; //para não submeter o form do modo tradicional (sem AJAX)
	});
});
}
</script>
<!-- <div id="message" class="error"><p>Ocorreram os seguintes erros:</p><ul><li>Digite o nome do aluno</li></ul></div>  -->

<h2>{{<?php echo (action=='adicionar') ? 'Adicionar Curso' : 'Editar Curso';  ?>}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
	<form method="post" name="frm" id="frm">
		<input type="hidden" id="id" name="id" value="<?=p('id') ?>" />
		<p>
			<label for="descricao">{{Descrição}}:</label>
			<input id="descricao" name="descricao" value="<?=Post::getVal('descricao') ?>" size="30" />
		</p>
    
    <p>  
      <label for="id_area_profissional">Área Profissional</label>
      <?createComboBox($areas, "id", "descricao", "id_area_profissional", Post::getVal('id_area_profissional'));?>
    </p>

    <p>  
      <label for="id_regime_curso">Regime do Curso</label>
      <?createComboBox($regimes, "id", "descricao", "id_regime_curso", Post::getVal('id_regime_curso'));?>
    </p>

    <p>  
      <label for="id_nivel_curso">Nível do Curso</label>
      <?createComboBox($regimes, "id", "descricao", "id_nivel_curso", Post::getVal('id_nivel_curso'));?>
    </p>

		<p>
			<label for="perfil">{{Perfil Profissional de Conclusão}}:</label>
			<textarea id="perfil" name="perfil" cols="6" rows="10"><?=Post::getVal('perfil') ?></textarea>
		</p>

		<p class="submit">
			<span id="loading"></span>
      <input type="submit" value="{{Enviar}}" name="enviar" id="enviar" /> {{ou}} 
      <a href="<?=new Link('curso') ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>


