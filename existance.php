<?php
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$type = null;
$secret = "spyW";
if(isset($_POST['email'])){
$type = "email".$secret;
}
else if(isset($_POST['nick'])){
$type = "nick".$secret;
}
else{
$type = "error";
}

switch($type){

case "emailspyW":
$val = $_POST['email'];
mysqli_select_db($con,"users");
$query = mysqli_query($con, "SELECT * FROM users WHERE email='$val'");
$number = mysqli_num_rows($query);
	
	if($number == 0){
		echo("free");
		}
	else{
		echo("exists");
		}
		mysqli_close($con);
		break;

case "nickspyW":
$val = $_POST['nick'];
mysqli_select_db($con, "users");
$query = mysqli_query($con, "SELECT * FROM users WHERE username='$val'");
$number = mysqli_num_rows($query);

	if($number == 0){
		echo("free");
		}
	else{
		echo("exists");
		}
		mysqli_close($con);
		break;
		mysqli_close($con);
		break;
		
case "error":
		echo("error");
		}


?>