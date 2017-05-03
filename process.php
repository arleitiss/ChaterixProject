<?php
session_start();

if($_SESSION['valid'] == "true" && strpos($_SERVER['HTTP_REFERER'], "chaterix.com") == true){
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$name = mysql_escape_string(htmlentities($_POST['name']));
$surname = mysql_escape_string(htmlentities($_POST['surname']));
$nickname = mysql_escape_string(htmlentities($_POST['nickname']));
$country = $_POST['country'];
$dob = $_POST['dob_day']."-".$_POST['dob_month']."-".$_POST['dob_year'];
$email = $_POST['email_reg'];
$pass = crypt($_POST['pass_reg'], "$6$"."al");
$ip = $_SERVER['REMOTE_ADDR'];
mysqli_query($con, "INSERT INTO users (`first_name`, `last_name`, `username`, `dob`, `email` , `password` ,`ip`, `country`) VALUES ('$name', '$surname', '$nickname', '$dob' ,'$email', '$pass', '$ip', '$country')");
echo('Successfully Registered, redirecting...');
header( "refresh:5; url=index.php" ); 
}
else{
echo("Validation Failed, IP logged as suspicious activity occurred.");
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$ip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];

mysqli_query($con, "INSERT INTO intrusions (`ip`, `comment`, `agent`) VALUES ('$ip', 'process.php intrusion attempt', '$agent')");
}
?>