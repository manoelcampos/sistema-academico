<?php
 
/** View utilizada para adicionar ou alterar um registro de usuário
* @package SistemaReservas
* @subpackage View
*/
?>

<!--JQuery Validation Plugin: http://bassistance.de/jquery-plugins/jquery-plugin-validation/-->
<script type="text/javascript">
    $(document).ready(function(){
        $('#frm').validate({
            rules:{
                //minlength: 3 email: true equalTo: "#senha"
                nome:{ required: true },
                matricula:{ required: true },
                <?php if(action=='adicionar') : ?>
                senha:{ required: true },
                <?php endif; ?>
                email:{ required: true, email: true },
                id_tipo_usuario:{ required: true },
                ativo:{ required: true },
                confsenha:{ equalTo: "#senha" },
            }
        });
    });
</script>

<h2>{{<?php echo (action=='adicionar') ? 'Adicionar Usuário' : 'Editar Usuário';  ?>}}</h2>
<span class="desc"><!--desc--></span>
<fieldset>
	<form method="post" name="frm" id="frm">
		<input type="hidden" id="id" name="id" value="<?php echo Post::getVal('id') ?>" />
		<p>
			<label for="nome">{{Nome*}}:</label>
			<input id="nome" name="nome" value="<?php echo Post::getVal('nome') ?>" size="50" maxlength="50" />
		</p>
		<p>
			<label for="email">{{E-mail*}}:</label>
			<input id="email" name="email" value="<?php echo Post::getVal('email') ?>" size="50" maxlength="50"  />
		</p>
		<p>
			<label for="senha">{{Senha<?php if(action=='alterar') echo " (deixe em branco se não quiser alterar a mesma)";?>}}:</label>
			<input type="password" id="senha" name="senha" size="20" maxlength="20"  />

			<label for="confsenha">{{Confirmação da Senha}}:</label>
			<input  type="password" id="confsenha" name="confsenha" size="20" maxlength="20"  />

		</p>
    
		<p>
			<label for="login_ativo">{{Ativo*}}:</label>
			<?php createComboBox($simNao, "id", "descricao", "login_ativo", Post::getVal('login_ativo'), true, false);?>
		</p>

		<p class="submit">
			<input type="submit" value="{{Enviar}}" /> {{ou}} <a href="<?php echo new Link(getIndexView()) ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
		</p>
	</form>
</fieldset>
