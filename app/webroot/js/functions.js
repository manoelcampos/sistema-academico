function focus($excludeFieldName) {
  if(document.forms && document.forms.length > 0 && document.forms[0].elements)  {
     for(i = 0; i < document.forms[0].elements.length; i++)
       if(document.forms[0].elements[i].type != "hidden"
       && document.forms[0].elements[i].id != $excludeFieldName) {
         document.forms[0].elements[i].focus();
         return;
       }
  }
}

function popup(url, width, height, opcoes) {
  if(opcoes != "")	  
     opcoes = ", " + opcoes;
  window.open(url, "janela", "height = "+ height+", width = " + width + opcoes);
}
