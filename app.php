<?php
include 'vendor/autoload.php';

$uploaddir = "uploads/";
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$filetype = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
$filename= $_FILES['userfile']['name'];

if(isset($_POST['submit'])){
  $filetype=$_FILES['userfile']['type'];
  if ($filetype=="application/pdf") {
    if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      echo "The file ". basename( $filename ). " is uploaded";
    } else {
      echo "Problema al subir el archivo";
      }
  } else {
    echo "Solamente podes subir archivos en formato PDFs.";
  }
}
if(isset($_POST["idioma"]) && ($_POST["plan"])){
  $plan = $_POST["plan"];
  $idioma = $_POST["idioma"];
}

$archivo = 'uploads/' . basename( $filename );
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile($archivo);
$text = $pdf->getText();
//echo $text;
preg_match('/VOUCHER Nº:(.*)/', $text, $voucher);
preg_match('/NOMBRE:(.*)/', $text, $nombre);
preg_match('/NOMBRE:(.*)/', $text, $nombre2);
preg_match('/DNI (.*)/', $text, $dni);
preg_match('/PASAPORTE (.*)/', $text, $pasaporte);
preg_match('/FECHA DE NACIMIENTO: (.*)/', $text, $dob);
preg_match('/PLAN: (.*)/', $text, $planVoucher);
preg_match('#\\DESTINO:(.+)\\VIGENCIA#s', $text, $destino);
preg_match('#\\EMISION:(.+)\\CONTACTO EMERGENCIA#s', $text, $emision);
preg_match('#\\EMERGENCIA:(.+)\\TEL.#s', $text, $contacto);
preg_match('/TEL.:(.*)/', $text, $tlf);
preg_match('/AGENCIA:(.*)/', $text, $agencia);
preg_match('/ AL (.*)/', $text, $to);
preg_match('/VIGENCIA: DEL (.*?) AL/', $text, $from);

$mpdf = new \Mpdf\Mpdf();
ob_start();
$stylesheet = file_get_contents('style.css');
// get the Customer Information in English
function customerInfo ($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, $tpl){
  echo "
  <div class='flex'>
    <div class='info'>
      <p class='voucher'>VOUCHER: {$voucher[1]}</p>
      <p>LAST AND FIRST NAME:{$nombre[1]}{$nombre2[1]}<br />
      ID/PASSPORT: {$dni[1]}{$pasaporte[1]}<br />
      DATE OF BIRTH: {$dob[1]}<br />
      PLAN: {$planVoucher[1]}<br />
      DESTINATION: {$destino[1]}<br />
      VALIDITY: FROM {$from[1]} TO {$to[1]}<br />
      DATE OF EMISSION: {$emision[1]}<br />
      EMERGENCY CONTACT: {$contacto[1]}<br />
      TELEPHONE: {$tlf[1]}<br />
      AGENCY: {$agencia[1]}</p>
    </div>
    <div class='logo'>
      <img src='logo.png' />
    </div>
  </div> 
  ";
  include $tpl;
}

// get the Customer Information in Portuguese
function customerInfoBr ($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, $tpl){
  echo "
  <div class='flex'>
    <div class='info'>
      <p class='voucher'>VOUCHER: {$voucher[1]}</p>
      <p>Sobrenome e nome: {$nombre[1]}{$nombre2[1]}<br />
      Passporte: {$dni[1]}{$pasaporte[1]}<br />
      Data de nascimento: {$dob[1]}<br />
      Plano: {$planVoucher[1]}<br />
      Destino: {$destino[1]}<br />
      Validade: {$from[1]} A {$to[1]}<br />
      Data de emissão: {$emision[1]}<br />
      Contato de emergência: {$contacto[1]}<br />
      Telefone: {$tlf[1]}<br />
      Agência: {$agencia[1]}</p>
    </div>
    <div class='logo'>
      <img src='logo.png' />
    </div>
  </div> 
  ";
  include $tpl;
}

if($plan === 'inf-15' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf15en.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);
  $mpdf->WriteHTML($template);  
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-25' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf25en.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '25-pro' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf25proen.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-40' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40en.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '40-pro' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40proen.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf40-proEU' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40EUproen.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-60' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf60en.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '60-pro' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf60proen.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-80' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf80en.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '80-pro' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf80proen.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-25' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg25en.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-25-pro' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg25proen.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-40' && $idioma === 'en'){
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg40en.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-40-pro' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg40proen.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '30-proEU' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf30EUen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === '40-proEU' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40EUen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-50-pro' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre50proEUen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-60-pro' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre60proen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-80-pro' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre80proen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-100-pro' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre100proen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-150-pro' && $idioma === 'en'){  
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre150proen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-250-pro' && $idioma === 'en'){ 
  customerInfo($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre250proen.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'inf-15' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf15br.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-25' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf25br.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '25-pro' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf25probr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '30-proEU' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf30EUbr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '40-proEU' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40EUbr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'pre-50-pro' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre50proEUbr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-40' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40br.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf40-proEU' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40EUpro.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '40-pro' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf40probr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-60' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf60br.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '60-pro' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf60probr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'inf-80' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf80br.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === '80-pro' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'inf80probr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-25' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg25br.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-25-pro' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg25probr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-40' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg40br.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'reg-40-pro' && $idioma === 'br'){
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'reg40probr.html');
  $template = ob_get_contents();
  ob_end_clean();
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D'); 
  echo $html;
}elseif($plan === 'pre-60-pro' && $idioma === 'br'){ 
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre60probr.html');
  $template = ob_get_contents();
  ob_end_clean(); 
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-80-pro' && $idioma === 'br'){ 
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre80probr.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-100-pro' && $idioma === 'br'){ 
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre100probr.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-150-pro' && $idioma === 'br'){  
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre150probr.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}elseif($plan === 'pre-250-pro' && $idioma === 'br'){ 
  customerInfoBr($voucher, $nombre, $nombre2, $dni, $pasaporte, $dob, $planVoucher, $destino, $from, $to, $emision, $contacto, $tlf, $agencia, 'pre250probr.html');
  $template = ob_get_contents();
  ob_end_clean();  
  $mpdf->WriteHTML($stylesheet,1);	
  $mpdf->WriteHTML($template);
  $mpdf->Output($idioma . '-' . $filename, 'D');   
  echo $html;
}else{
  echo "El plan elegido no coincide con el plan del voucher, intenta de nuevo";
}
?>