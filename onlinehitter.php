<?php
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$hits = mysqli_query($con, "SELECT DISTINCT (ip) FROM hitter");
$users_online = mysqli_query($con, "SELECT userID FROM users_online");
exec("pgrep node", $output, $return);
$status = "offline";
if ($return == 0) {
    $status = "online";
}
else{
	$status = "offline";
}


$total = mysqli_num_rows($hits)."@".mysqli_num_rows($users_online)."@".$status;
mysqli_close($con);
echo($total);


?>