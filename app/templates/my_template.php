<?php
/* 
 * Copyright (c) 2008, Carlos André Ferrari <[carlos@]ferrari.eti.br>; Luan Almeida <[luan@]luan.eti.br>
 * All rights reserved. 
 */
 
 /**
 * Application template
 * @package AcademicoEad
 * @subpackage Template
 */

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo request_lang?>" lang="<?php echo request_lang?>">
<head>
	<title>
	<?php /*Tais variáveis definidas em comentários HTML são criadas por meio do método Vortice:setVar*/ ?>
	<!--title-->
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="Manoel Campos da Silva Filho" />
	<meta name="language" content="<?php echo request_lang?>" />
	<!--csstags-->
	<script>
		var rootvirtual = '<?php echo virtualroot ?>';
	</script>
	<!--As bibliotecas foram adicionadas diretamente na pasta js em webroot
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
  -->

	<!--jstags-->
</head>
<body onload="focus('semestre');">
  <div id="geral">
	  <div id="topo">
		  <!--<h1><a class="hidetxt" href="<?php echo virtualroot . request_lang ?>" title="{{Página inicial}}">{{Página inicial}}</a></h1>-->
	  </div>
    
    <?php if(Vortice::getView() != "usuario/login" && !p("popup")): ?>
    <div id="menu">
      <ul id="menu-principal" class="submenu">
          <li><a class="lnk1" href="<?php echo new Link('') ?>" title="{{Página Inicial}}">{{Página Inicial}}</a></li>
          <hr/>
          <?php if($u = Session::get("u")) :?>
            <?php foreach(AccessControl::getPages($u->tipo) as $title => $view):
              /*Se a chave (título da página) é numérica, é porque não foi definida um nome de chave explicitamente
              para a página no array, o que indica que ela possui uma rota (alias). Assim,
              cria um link apenas para a rota (que terá um título associado a ela).*/
              if(!is_numeric($title)):?>
                 <li><a class="lnk1" href="<?php echo new Link($view) ?>" title="{{<?php echo $title?>}}">{{<?php echo $title?>}}</a></li>
              <?php endif;?>
            <?php endforeach;?>
            <hr/>
            <li><a class="lnk1" href="<?php echo new Link('usuario:logout')?>">Sair do Sistema</a></li>
          <?php endif;?> 
      </ul>
    </div>
    <?php endif; ?>

    <div id="conteiner">
	    <!--message-->
      <?php if(Vortice::getView() != "usuario/login" && !p("popup")): ?>
      <div style="width: 100%; padding-top: 5px;">
        <table border="0" style="width: 100%;" id="tbDefaultFields">
          <tr>
            <td width="30%">
              <?php
              $view = Vortice::getView();
              //recorta o nome da action da view, para que seja redicionado para a action index
              //$view = substr($view, 0, strlen($view)-strlen(action));
              ?>
              <form method="post" id='frmsem' name='frmsem' action="<?php echo new Link('index')?>">
                Semestre: 
                <?php createComboBox(Turma::getSemestres(), "semestre", "semestre", "", 
                     Turma::getSemestrePadrao(), true, false, "", "onchange='frmsem.submit();'");?>
                <input type="hidden" name="url" value="<?php echo $view?>" />
              </form>
            </td>

            <?php $u = Session::get("u"); ?>
            <td width="57%">
                Usuário: <a href='<?php echo new Link("usuario:alterar", "id=$u->id")?>' 
                alt="Alterar dados pessoais"><?php echo $u->matricula . " - " . $u->nome?></a>
            </td>

            <td><a class="lnk1" href="<?php echo new Link('usuario:logout'); ?>">Sair do Sistema</a></td>
          </tr>
        </table>
      </div>
      <?php endif;?>

	    <div id="conteudo">
		    <!--menu-->
		    <!--content-->
	    </div>
    </div>
    <?php if(!p("popup")):?>
    <div id="rodape"><a href="http://manoelcampos.com/contato" target="_blank" title="Desenvolvedor">Desenvolvido por Manoel Campos</a></div>
    <?php endif;?>
  </div>
</body>
</html>
