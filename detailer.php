<?php
error_reporting(E_ALL);
header('Content-Type: application/json');
ini_set('display_errors', 1);
if(isset($_POST['secretKey']) && $_POST['secretKey'] = "als" && isset($_POST['userid'])){
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$quer = "SELECT * FROM users WHERE id=".$_POST['userid'];
$res = mysqli_query($con, $quer);
while($row = mysqli_fetch_assoc($res)){
echo json_encode($row);
}


}
else{
echo("false");
}


?>