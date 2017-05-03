<?php
session_start();
$userId = $_SESSION['usrID'];

if(isset($_POST['action'])){
	if($_POST['action'] == "threads"){
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

$messagesList = mysqli_query($con, "SELECT * FROM pmessages WHERE msgto=$userId GROUP BY msgfrom, id DESC");
$previous = 0;
echo("<div id='controls'>Auto Refresh<input type='checkbox' id='autoref' placeholder='Auto Refresh' value='Auto Refresh' /><input type='button' id='refresh' value='Refresh'/><input type='button' id='msgClose' value='X'/></div>");
while($rowTwo = mysqli_fetch_assoc($messagesList)){
	$quer = mysqli_query($con, "SELECT id, first_name, last_name, username FROM users WHERE id=".$rowTwo['msgfrom']."");
	$muser = mysqli_fetch_assoc($quer);

	if($previous != $rowTwo['msgfrom']){
		if($rowTwo['msgread'] == 0){
			echo("<div id='threadMainNew' onclick='readThread(".$rowTwo['msgfrom'].");'>");
		}
		else{
			echo("<div id='threadMain' onclick='readThread(".$rowTwo['msgfrom'].");'>");
		}
		echo("
			<div id='threadData'>
			<div id='threadFrom'>".$muser['first_name']." ".$muser['last_name']." (".$muser['username'].")</div>
			<div id='threadLastTime'>".$rowTwo['date']."</div>
			</div>
			<div id='threadMessage'><div id='threadLast'>".$rowTwo['message']."</div></div>
			");
			if($rowTwo['msgread'] == 0){
				echo("<div id='threadStatusNew'>New Messages</div>");
			}
			else{
				echo("<div id='threadStatus'>No new messages</div>");
			}
			
			echo("
		</div>
		");
	}
	else if($previous == $rowTwo['msgfrom']){
		
	}
	$previous = $rowTwo['msgfrom'];
}
}


else if($_POST['action'] == "messages"){
	$messenger = $_POST['msid'];
	$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
	$que = mysqli_query($con, "SELECT id, first_name, last_name, username FROM users WHERE id=$messenger");
	$muse = mysqli_fetch_assoc($que);
	$ips = $_SERVER['REMOTE_ADDR'];
	$dtd = date("H:i d-M-y");
	mysqli_query($con, "UPDATE pmessages SET rip='$ips', readtime='$dtd', msgread='1' WHERE msgto=$userId AND msgfrom=$messenger");
	
	
	$qry = mysqli_query($con, "SELECT * FROM pmessages WHERE msgto=$userId AND msgfrom=$messenger OR msgto=$messenger AND msgfrom=$userId");
	echo("<div id='msBox'>");
	echo("<div id='controls'><input type='button' value='Back' id='msgBack'/>Auto Refresh<input type='checkbox' id='autoref' placeholder='Auto Refresh' value='Auto Refresh' /><input type='button' id='refresh' value='Refresh'/><input type='button' id='msgClose' value='X'/></div>");
	echo("<div id='msMain'>");
	while($msg = mysqli_fetch_assoc($qry)){
		if($msg['msgfrom'] == $userId){
		echo("<div id='msBodyMy'>");
		echo("<div id='Secondary'><div id='msSenderMyself'>Myself</div>");	
		}
		else{
		echo("<div id='msBody'>");
		echo("<div id='Secondary'><div id='msSender'>".$muse['first_name']." ".$muse['last_name']." (".$muse['username'].")</div>");
		}
		echo("<div id='msDate'>".$msg['date']."</div></div>");
		echo("<div id='Primary'><div id='msMessage'>".$msg['message']."</div></div>");
		echo("</div>");
	}
	echo("</div>");
	echo("<div id='msReply'><textarea id='msText' placeholder='Type reply here'></textarea><input type='button' id='sendReply' onclick='sendReply(".$messenger.");' value='Send Reply'/></div>");
	echo("</div>");
	}

else if($_POST['action'] == "reply"){
		$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
	$toSend = $_POST['messenger'];
	$msg = strip_tags(mysqli_escape_string($con ,$_POST['message']));
	$sentFromIP = $_SERVER['REMOTE_ADDR'];
	$dateMsg = date("H:i d-M-y");
	$senderOf = $_SESSION['usrID'];
	mysqli_query($con, "INSERT INTO pmessages (`msgto`, `msgfrom`, `message`, `date`, `sip`) VALUES ('$toSend', '$senderOf', '$msg', '$dateMsg' , '$sentFromIP')");
	
}


}
?>