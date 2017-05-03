<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$auth = $_POST['authPass'];
$cas = $_POST['type'];
$val = $_POST['val'];
//echo(crypt($auth, '$6$arleitiss'));
if(crypt($auth, '$6$arleitiss') == '$6$arleitiss$GeZf7TId2icg0x.U0XB794XmIAzOvopVflFBPVMAVU6S/1.rX2L1klFZkGlc7L1KKxmajx18lK52aEbIVnNFS/'){


switch($cas){
case "deviceId":
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$dats = explode("-", $val);
mysqli_query($con, "UPDATE users SET deviceId='".$dats[0]."' WHERE id='".$dats[1]."'");
break;




}

}




?>