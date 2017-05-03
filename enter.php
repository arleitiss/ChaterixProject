<?php
session_start();
$u = $_SESSION['usrID'];
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"users");
$sql = ("SELECT email FROM users WHERE id='$u'");
$ids = mysqli_query($con,$sql);
$result = mysqli_num_rows($ids);
$usd = mysqli_fetch_object($ids);
$userID = $usd->email;

if($result == 1){
echo($userID);
}
else{
echo("false");
}

mysqli_close($con);
?>