<?php
session_start();
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$user = $_POST['email'];
$pass = crypt($_POST['pass'], "$6$"."al");

$que = mysqli_query($con, "SELECT * FROM users WHERE email='$user' AND password='$pass'");
if(mysqli_num_rows($que) != 0){
echo("Logging In..");
$res = mysqli_fetch_array($que);
$_SESSION['id'] = $res['id'];
$_SESSION['email'] = $res['email'];
$_SESSION['

//header( "refresh:3; url=myprofile.php" ); 
}
else{
echo("Something wrong happened, redirecting....");
$ip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
mysqli_query($con, "INSERT INTO intrusions (`ip`, `comment`, `agent`) VALUES ('$ip', 'redir.php intrusion attempt', '$agent')");
header( "refresh:5; url=index.php" ); 
}

?>