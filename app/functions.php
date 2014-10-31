<?php


/* 
 * Copyright (c) 2008, Carlos André Ferrari <[carlos@]ferrari.eti.br>; Luan Almeida <[luan@]luan.eti.br>
 * All rights reserved. 
 */
 
/**
 * Application functions
 * @package SampleApp
 */

function stripAccents($str) {
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function arabicToRoman($N){ 
        $c="IVXLCDM"; 
        $s = "";
        for($a=5, $b=0; $N; $b++, $a^=7) {
                for($o=$N % $a, $N=$N/$a^0; $o--; ) {
                   $i = ($o>2 ? $b + $N - ($N&=-2) + $o=1 : $b);
                   $s = $c[$i] . $s;
                }
        }
        return $s; 
} 

/***
* Permite fechar uma janela popup, dando um refresh
* na janela que a abriu (opener window).
* @param bool $refreshOpenerWindow Indica se deve ser dado refresh na janela opener
* @param string $openerSubmitButtonId Id de um botão submit que será
* executado caso $refreshOpenerWindow seja true.
* Executando tal botão na janela opener, o form na mesma é enviado
* e a mesma é atualizada.
*/
function windowClose($refreshOpenerWindow=false, $openerSubmitButtonId="submit") {
?>
<script language="javascript">
  <?php if($refreshOpenerWindow):?>
    //window.opener.location.href = window.opener.location.href;
    //Busca a página novamente no servidor
    //window.opener.location.reload(true);
    //Não busca a página novamente no servidor
    //window.opener.location.reload(false);
    //window.opener.location.refresh();
    var botao = window.opener.document.getElementById("<?php echo $openerSubmitButtonId?>");
		if(botao && botao!=undefined)
   		 botao.click();
    if(window.opener.progressWindow)
       window.opener.progressWindow.close();
  <?php endif;?>
  window.close();
</script>
<?php
}


function createComboBox($itens, $keyFieldName, $descriptionField, $name="", $selectedValue="0", 
 $enabled=true, $includeEmptyItem=true, $emptyItemText="", $events="")
{
  if($name=="")
     $name = $keyFieldName;

  $enabledProp = "";
  if(!$enabled) 
     $enabledProp = "disabled=\"disabled\" style=\"background-color: silver;\" ";
	?>
  <select name="<?php echo $name?>" id="<?php echo $name?>" <?php echo $events?> <?php echo $enabledProp?> >
  <?php
  if(count($itens) == 0)
    echo "<option value='0'>Nenhum item encontrado</option>";
  elseif($includeEmptyItem)
    echo "<option value='0'>$emptyItemText</option>";
  foreach($itens as $o):
  ?>
    <option value="<?php echo $o->$keyFieldName?>" <?php echo ($selectedValue == $o->$keyFieldName ? "selected" : "")?>><?php echo $o->$descriptionField?></option>
  <?php endforeach;?>
  </select>
<?php
}


/**
* Formats a string containing a date to a specified format.
* @param string $dateStr Date in string format Y/m/d or Y-m-d
* @param string $foramt Format to convert the date
*/
function formatDateStr($dateStr, $format=MasterController::displayDateFormat) {

  if($dateStr == "" || $dateStr == "0000-00-00")
      return "";
      
  $timestamp = strtotime($dateStr);
  return date($format, $timestamp);      
}

/**
* Get a full date  in format "%d de %B de %Y" in Brazilian Portuguese
* @return string Return the formated date in Brazilian Portuguese, like "21 de Novembro de 2010"
*/
function getTranslatedDate($data=null) {  
  $month = strftime('%B');
  if($data != null) {
	 $data = strtotime($data);
     $month = date("F", $data);
  }
  
  switch($month) {
	  case "January":   $month = "Janeiro";    break;
	  case "February":  $month = "Fevereiro";   break;
	  case "March":     $month = "Março";     break;
	  case "April":     $month = "Abril";     break;
	  case "May":       $month = "Maio";       break;
	  case "June":      $month = "Junho";      break;
	  case "July":      $month = "Julho";      break;
	  case "August":    $month = "Agosto";    break;
	  case "September": $month = "Setembro"; break;
	  case "October":   $month = "Outubro";   break;
	  case "November":  $month = "Novembro";  break;
	  case "December":  $month = "Dezembro";  break;
  }
  if($data == null)
	return strftime('%d de ') . $month . strftime(' de %Y');
  else return date('d \d\e ', $data) . $month . date(' \d\e Y', $data);
}

/** Verifica se uma string inicia com uma outra determinada string
* @param string $str String onde procurar
* @param string $sub String a ser procurada
* @return boolean Retorna true se a string $sub foi encontrada no início da string $str
*/
function startsWith($str, $sub)
{
    $length = strlen($sub);
    return (substr($str, 0, $length) === $sub);
}

/** Verifica se uma string termina com uma outra determinada string
* @param string $str String onde procurar
* @param string $sub String a ser procurada
* @return boolean Retorna true se a string $sub foi encontrada no final da string $str
*/
function endsWith( $str, $sub ) {
  return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub );
}

/** A partir da view atual, retorna o endereço da view index.
* Por exemplo, se a view atual é curso/adicionar,
* retorna curso/ que representa a action index da view curso
* @return string retorna o endereço da action index da view atual
*/
function getIndexView() {
      $view = Vortice::getView();
      //se tem uma barra no nome da view, então remove o nome da action da view, para pegar apenas o nome da página
      if($i=strpos($view, "/"))
         $view = substr($view, 0, $i);
      return $view;
}

/**
 * Gera código necessário para emitir, a partir do PHP, um alert JavaScript.
 * @param string $msg Mensagem a ser exibida no alert.
 * @param bool $voltar Se igual a true, gera um comando JavaScript para voltar à página
 * anterior. O valor padrão é false.
 */
function js_alert($msg, $voltar=false) {
	   echo "<script language=\"javascript\" charset=\"utf-8\">";
	   echo "window.alert(\"$msg\");";
	   if($voltar)
	      echo "window.history.go(-1);";
	   echo "</script>";		
}


/**
* Envia uma requisição HTTP a um servidor Web e 
* devolve o conteúdo retornado
* @param $url URL de destino 
* @param $method Método HTTP a ser utilizado (GET, POST, etc)
* @param $paramArray Parâmetros a serem enviados (no caso de uma requisição POST)
* @return Retorna o conteúdo de resposta da requisição, ou false em caso de erro
*/
function getWebResource($url, $method="GET", $paramArray=NULL) {
  $response = sendHttpRequest( $url, $method, $paramArray);
  if ($response['http_code'] == 200) {
        return (isset($response["content"]) ? $response["content"] : "");
    } else {
        return false;
    }
}

/**
 * Envia uma requisição HTTP para um servidor Web.  
 * http://nadeausoftware.com/articles/2007/07/php_tip_how_get_web_page_using_fopen_wrappers
 * @param $url URL of the requested page
 * @param $method HTTP method to be used (GET, POST, PUT or DELETE)
 * @param $paramArray Array containing the HTTP parameters list to be passed to the web page.
 * @return Return an array containing the header fields and content.
 */
function sendHttpRequest( $url, $method="GET", $paramArray=NULL )
{
    //foreach ($options as $k => $v)

    $httpParams = array(
        'user_agent'    => 'Tracker/1.0',
        'max_redirects' => 10,          // stop after 10 redirects
        'timeout'       => 120,         // timeout on response  
        'method'  => $method
    );
    
    if($method=="POST") {
       //http_build_query — Generate URL-encoded query string 
       $paramArray = http_build_query($paramArray);
       if($paramArray) {
          $httpParams['header']  = 
             "Content-type: application/x-www-form-urlencoded\r\n". 
             "Content-Length: ".strlen($paramArray)."\r\n"; 
          $httpParams['content'] = $paramArray;
       }
    }

    $options = array( 'http' => $httpParams);    
    $context = stream_context_create( $options );
    $page    = @file_get_contents( $url, false, $context );
 
    $response  = array( );
    if ( $page != false )
        $response['content'] = $page;
    else if ( !isset( $http_response_header ) )
        return null;    // Bad url, timeout

    // Save the header
    $response['header'] = $http_response_header;

    // Get the *last* HTTP status code
    $nLines = count( $http_response_header );
    for ( $i = $nLines-1; $i >= 0; $i-- )
    {
        $line = $http_response_header[$i];
        if ( strncasecmp( "HTTP", $line, 4 ) == 0 )
        {
            $aux = explode( ' ', $line );
            $response['http_code'] = $aux[1];
            break;
        }
    }
 
    return $response;
}


// Descomente este bloco para habilitar o suporte à URL's Encriptadas

/*
function getSessionKey($id='key'){
	if (Session::get("link_key_$id")=="")
		Session::set("link_key_$id", substr(crypt(date("U") . $id), -10));
	return Session::get("link_key_$id");
}

function link_encode($l){
	$lnk = unserialize($l);
	$lnk["chave"] = md5($l);
	$lnk = json_encode($lnk);
	$lnk = Crypt::Encrypt($lnk, getSessionKey());
	return $lnk . "/";
}

function link_decode($l){
	if (!$l) return;
	$l = Crypt::Decrypt($l, getSessionKey());
	$l = (array) json_decode($l);

	$chave = (isset($l['chave'])) ? $l['chave'] : '';
	unset ($l["chave"]);
	if (isset($l["pars"])) 
		$l["pars"] = (array)$l["pars"]; 
	$l = serialize($l);
	if ($chave == md5($l)) return $l;
	throw new Exception("ops!");
}
*/


