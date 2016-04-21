<?php
/** View utilizada para exibir a lista de usuários e
 * permitir chamar as views de inclusão e edição.
 * @package AcademicoEad
 * @subpackage View
*/
?>
<h2>{{Usuários}}</h2>
<span class="desc"><!--desc--></span>
<ul class="submenu">
  <?php 
  $url = getIndexView().":adicionar";
  if(AccessControl::valid($url)) {?>
	<li>[<a href="<?php echo new Link($url) ?>">{{Adicionar novo Usuário}}</a>]</li>
	<?php }?>
</ul>

<fieldset>
  <div>
	<form method="post" name="frm" id="frm">
		<label for="tipo">{{Tipo}}:</label>
		<select id="tipo" name="tipo">
      <option value="">Todos</option>
      <option value="A" <?=(p("tipo")=="A" ? " selected " : "")?>>Alunos</option>
      <option value="P" <?=(p("tipo")=="P" ? " selected " : "")?>>Professores</option>
      <option value="C" <?=(p("tipo")=="C" ? " selected " : "")?>>Coordenadores</option>
      <option value="F" <?=(p("tipo")=="F" ? " selected " : "")?>>Funcionários</option>
    </select>

		<label for="login_ativo">{{Status}}:</label>
		<select id="login_ativo" name="login_ativo">
      <option value="">Todos</option>
      <option value="1" <?=(p("login_ativo")==1 ? " selected " : "")?>>Ativos</option>
      <option value="0" <?=(p("login_ativo")==0 ? " selected " : "")?>>Inativos</option>
    </select>

  	<input type="submit" value="{{Filtrar}}" /> 
	</form>
  </div>
</fieldset>

<?php 
/*A variável $itens é criada pelo controller
quando a action (método) correspondente à view atual
é executada no momento que a view é acionada.
Tal variável é definida como uma propriedade
do controller e assim, disponibilizada automaticamente
como uma variável global para a view*/
if (count($itens)){ 
?>

<table width="100%">
	<tr>
		<th width="240px">{{Nome}}</th>
		<th>{{Matrícula}}</th>
		<th>{{E-mail}}</th>
		<th>{{Tipo}}</th>
		<th>{{Ativo}}</th>																														
		<th width="100">{{Ações}}</th>
	</tr>
	<?php foreach($itens as $o): ?>
	<tr class="item">
		<td><?php echo $o->nome ?></td>
		<td><?php echo $o->matricula ?></td>
		<td><?php echo $o->email ?></td>
		<td><?php echo $o->tipo ?></td>
		<td><?php echo ($o->login_ativo ? "Sim" : "Não") ?></td>		
		<td>
      <?php 
      $url = getIndexView().":alterar";
      if(AccessControl::valid($url)) {?>		
		  <a href="<?php echo new Link($url, "id={$o->id}") ?>">{{Alterar}}</a> | 
		  <?php }?>
		  
      <?php 
      $url = getIndexView().":excluir";
      if(AccessControl::valid($url)) {?>				  
		  <a class="confirm" title="{{Excluir item}}: <?php echo $o->nome ?>" href="<?php echo new Link($url, "id={$o->id}") ?>">{{Excluir}}</a>
		  <?php }?>
    </td>
	</tr>
	<?php endforeach; ?>
</table>

<?php }else{ ?>
<h3>{{Nenhum usuário cadastrado}}</h3>
<?php } ?>


