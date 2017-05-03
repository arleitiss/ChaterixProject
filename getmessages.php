<?php

if(isset($_GET['data'])){
$dats = array();
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$quer = mysqli_query($con, "SELECT * FROM (SELECT * FROM messages ORDER BY id DESC LIMIT 20 ) sub ORDER BY id ASC");
while($row = mysqli_fetch_assoc($quer)){
$dats[] = $row;
}
echo(json_encode($dats));
}
else{

}