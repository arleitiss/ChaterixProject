<?php
session_start();
$u = $_POST['username'];
$p = $_POST['password'];
$p = crypt($p, "$6$"."al");
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"users");
$sql = ("SELECT id FROM users WHERE email='$u' AND password='$p'");
$ids = mysqli_query($con,$sql);
$result = mysqli_num_rows($ids);
$usd = mysqli_fetch_object($ids);
$userID = $usd->id;

if($result == 1){
$_SESSION['usrID'] = $userID;
echo("true-".$userID);
}
else{
echo("false");
}

mysqli_close($con);
?>