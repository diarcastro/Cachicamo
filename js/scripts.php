<?php

header('Content-type: text/javascript');
header("cache-control: must-revalidate");
$offset = 60 * 60;
$expire = "expires: ".gmdate("D, d M Y H:i:s", time() + $offset)." GMT";
//header ($expire);
//ob_start("compress");

function compress($buffer){
  // remove comments
  $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
  // remove tabs, spaces, newlines, etc.
  $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
//    return $buffer;
  return ob_gzhandler($buffer, 5);
}

$scripts = Array();
//  $scripts[]='jquery.autosize.min.js';

$scripts[] = 'jquery.placeholder.min.js';
$scripts[] = 'Alerta.js';
$scripts[] = 'Utils.js';
$scripts[] = 'md5.min.js';
$scripts[] = 'script.js';


//  $scripts[]='jquery.color-2.1.1.min.js';
//  $scripts[]='Alerta.js';
//  $scripts[]='jquery.form.js';
//	$scripts[]='jquery.tipsy.min.js';
//	$scripts[]='errors.js';
echo '/* Scripts: ';
echo print_r($scripts,1);
echo '*/'."\n";

for($i = 0; $i < count($scripts); $i++){
  if(file_exists($scripts[$i]))
    require($scripts[$i]);
}
//ob_end_flush();
?>