<?php

include 'vendor/autoload.php';
$parser = new \Smalot\PdfParser\Parser();
$pdf = $parser->parseFile('uploads/test.pdf');
$text = $pdf->getText();
echo $text;
?>
preg_match("^\\d{1,2}/\\d{2}/\\d{4}^", "datehere");


var name = info.match(/NOMBRE:(.*)/)[1];


if (strpos($text, 'VOUCHER Nº') !== FALSE) {
  echo 'Encontrado';
} else {
  echo "No encontrado";
}


$voucher = preg_split("/\bVOUCHER Nº\b/iu", $text);
echo array_pop($voucher);

variable = "El documento ya ha sido registado anteriormente,su estado es aceptado";
$position =strpos($variable , 'es ');
echo substr($variable, $position + 2); 




function getInfo() {
  $filename= 'uploads/' . basename($_FILES['userfile']['name']);
  $parser = new \Smalot\PdfParser\Parser();
  $pdf = $parser->parseFile($filename);
  $text = $pdf->getText();
  $position =strpos($text , 'VOUCHER:');
  echo substr($text, $position + 8);

 }
 getInfo();