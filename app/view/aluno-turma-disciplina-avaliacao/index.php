  <h2>{{Notas de Turma por Disciplina e Avaliação}}</h2>
  <span class="desc"><!--desc--></span>

  <form method="post" name="frm" id="frm">
   <fieldset>
    <?
    echo "Pólo";
    createComboBox($polos, "id", "descricao", "id_polo", p('id_polo'), true, false);

    if(!Usuario::isTeacher()) {
      echo "Curso";
      createComboBox($cursos, "id", "descricao", "id_curso", p('id_curso'), true, true, "", "onchange='frm.submit();'");
    }

    if(Usuario::isTeacher()) {
      echo "Curso/Módulo";
      createComboBox($modulos, "id", "curso_modulo", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
    }
    else if(post && p("id_curso")>0) {
      echo "Módulo";
      createComboBox($modulos, "id", "ordem_descricao", "id_modulo", p('id_modulo'), true, true, "", "onchange='frm.submit();'");
      echo "<p/>";
    }

    if(post) {
      if(p("id_modulo")>0) {
        echo "Disciplina";
        createComboBox($disciplinas, "id_disciplina", "descricao", "id_disciplina", p('id_disciplina'), true, true, "", "onchange='frm.submit();'");
      } 

      if(p('id_disciplina')>0) {
        if(p("id_curso")>0)
          echo "Avaliação";
        else echo "<br/>Avaliação";
        createComboBox($avaliacoes, "id", "descricao", "id_avaliacao", 
               Post::getVal('id_avaliacao'), true, true, "", "onchange='frm.submit();'");
      }

      if(p('id_avaliacao')>0) {?>
         <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/>&nbsp;
         <a href="<?=new Link(Vortice::getView()) ?>">Voltar</a>
      <?}
    }
    ?>
   </fieldset>

   <?if(post && p("id_avaliacao")>0):?>
    <h3>Pólo: <?=$turma->polo?> | Curso: <?=$turma->curso?> | <?=$turma->modulo?> | <?=$turma->semestre?></h3>
    <br/>

    <table width="100%">
    <caption>Disciplina: <?=$disciplina->descricao?></caption>
    <tr><th>Núm.</th><th>Matrícula</th><th>Aluno</th><th>Nota</th></tr>
    <?
    $i=0;
    foreach($alunos_turma_disciplina_avaliacao as $a) : 
       $i++;
       $id=($i%2==0 ? "id=alternaterow" : "");
    ?>
    <tr <?=$id?>>
		  <td align="center"><?=$i?></td>
		  <td>
        <?=$a->matricula?>
		  </td>
		  <td><?=$a->aluno?></td>
		  <td>
			  <input id="nota<?=$a->id_aluno?>" size="7" maxlength="5" name="nota<?=$a->id_aluno?>" value="<?=$a->nota?>" size="10" />
		  </td>
    </tr>
    <?endforeach;?>
    </table>

    <br/>
    <fieldset>
		<p class="submit">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td width="94%">
			    <input type="submit" name="salvar" id="salvar" value="{{Salvar}}" />&nbsp;
          <input type="button" name="imprimir" id="imprimir" value="Imprimir" onclick="window.print();"/> {{ou}} 
          <a href="<?=new Link(Vortice::getView()) ?>" title="{{Voltar para a página anterior}}">{{Voltar}}</a>
        </td>
        <td><a href="#" onclick="window.scroolTo(0,0);" title="{{Topo da Página}}">{{Topo}}</a></td>
      </tr>
      </table>
		</p>
    </fieldset>
   <?endif;?>
	</form>
