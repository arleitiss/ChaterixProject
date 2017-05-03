<?php
$item = $_SERVER['REMOTE_ADDR'];
//$item = $_GET['ip'];
$names = json_decode(file_get_contents("http://country.io/names.json"), true);
$data = json_decode(file_get_contents("http://ipinfo.io/".$item."/json"));
echo($names[$data->country]);
?>