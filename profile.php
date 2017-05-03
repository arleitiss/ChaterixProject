<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
//Connection block.
if(isset($_GET['user'])){
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$userId = $_GET['user'];


//Getting profile data.
$query = mysqli_query($con,"SELECT * FROM users WHERE id=$userId");
$row = mysqli_fetch_assoc($query);

//Formatting some data.
$dob = explode("-", $row['dob']);
$cm = date("m");
$cd = date("j");
$cy = date("Y");
$age = $cy - $dob[2];
if($cm < $dob[1] || ($cm == $dob[1] && $cd<$dob[0])){
$age--;
}

$timesince = explode(" ",$row['date_of_reg']);
$diff = abs(strtotime($cy."-".$cm."-".$cd) - strtotime($timesince[0]));
$days = floor(($diff / (60*60*24)));
$timeon = $days;

$userId = $_SESSION['usrID'];
$msgGetUnread = mysqli_query($con, "SELECT * FROM pmessages WHERE msgto=$userId AND msgread=0");
$newMsg = mysqli_num_rows($msgGetUnread);

//Visitor logging (For profile views purpose).
// TODO: Implement sessions to make sure only registered can see profiles.
$cur_ip = $_SERVER['REMOTE_ADDR'];
mysqli_query($con, "INSERT INTO profile_views (`profile_id`, `ip`) VALUES ('$userId', '$cur_ip')");

//Profile views retriever.
$views = mysqli_query($con, "SELECT DISTINCT(ip) FROM profile_views WHERE profile_id=$userId");
?>
<html>
<!DOCTYPE html>
<head>
<title>
<?php 
echo($row['first_name']." ".$row['last_name']." Profile");
?>
</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href="public/styles/AccPage.css" rel="stylesheet" type="text/css"/>
<script src="http://chaterix.com/public/enter.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="http://chaterix.com/public/char.js"></script>
<script type="text/javascript">
function sendPm(ops){
	var formopen = document.getElementById("sendPMForm");
	if(ops == "open"){
	formopen.style.display = "block";
	}
	else{
	formopen.style.display = "none";
	}
}

</script>
</head>
<?php



if(isset($_POST['sendMsg'])){
	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lcd7PwSAAAAAKnvq3LvWvpiFeXTsstOYE7j0H-K&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $status = json_decode($response);
		if($status->success)
        {
        echo("<div style='display: none;' class='successMsg' id='errorMessage'>Message sent successfully. <div id='dismissal'>(Click to dismiss)</div></div><");
		echo('
		<script type="text/javascript">
		$("#errorMessage").fadeTo( "5000", 1 );
		$( "#errorMessage" ).click(function() {
		$( "#errorMessage" ).fadeTo( "3000" , 0, function() {
		// Animation complete.
		});
		});
		</script>
		');
		$userTo = $_GET['user'];
		$sentFromIP = $_SERVER['REMOTE_ADDR'];
		$mes = strip_tags(mysqli_escape_string($con ,$_POST['pmess']));
		$dateMsg = date("H:i d-M-y");
		$senderOf = $_SESSION['usrID'];
		mysqli_query($con, "INSERT INTO pmessages 
		(`msgto`, `msgfrom`, `message`, `date`, `sip`) VALUES
		('$userTo', '$senderOf', '$mes', '$dateMsg', '$sentFromIP')");
		}else
        {
        echo("<div style='display: none;' class='failMsg' id='errorMessage'>Captcha validation failed. Message not sent.<div id='dismissal'>(Click to dismiss)</div></div>");
		echo('
		<script type="text/javascript">
		$("#errorMessage").fadeTo( "5000", 1 );
		$( "#errorMessage" ).click(function() {
		$( "#errorMessage" ).fadeTo( "3000" , 0, function() {
		// Animation complete.
		});
		});
		</script>
		');
		}
}
?>
<body onload="LoadCharDiv('<?php echo($row['avatar']); ?>', 'AvatarImgFrame');startTime();">
<div style="display:none;" id="sendPMForm">
<form method="POST" action="profile.php?user=<?php echo($_GET['user']);?>">
<?php echo("<div id='toUser'>Message to ".$row['first_name'] ."&nbsp". $row['last_name'] ."&nbsp;". "(".$row['username'].")</div>");?>
<textarea required placeholder="Type your message here..." name="pmess"></textarea>
<div class="g-recaptcha" data-sitekey="6Lcd7PwSAAAAADwWzepTPIRiF_c9Z81thBEcrByG"></div>
<input type="button" onclick="sendPm();" id='cancelBts' value="Cancel" />
<input type="submit" value="Send" name="sendMsg"/>
</form>
</div>

<div id="MainBody">
<?php
include 'enterthec.php';
?>
	<div id="AccountFrame">
		<div id="AccountAvatar">
			<div id="AvatarImgFrame"><img src="http://upload.wikimedia.org/wikipedia/commons/c/cd/Placeholder_male_superhero_c.png" id="Acc_img"/></div>
			<input type="button" id="sendPm" onClick="sendPm('open');" value="Send Message" name="sendPm"/>
		</div>
		<div id="AccountInfo">
			<div id="NameObject" class="DetailObjects"><div class="DetailLabel"><?php echo($row['first_name'] ."&nbsp". $row['last_name'] ."&nbsp;". "(".$row['username'].")");?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Age: </div><div class="DetailInput" id="DetailAge"><?php echo($age); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Country: </div><div class="DetailInput" id="DetailCountry"><?php echo($row['country']); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">User Type: </div><div class="DetailInput" id="DetailType"><?php echo($row['level']); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Registered: </div><div class="DetailInput" id="DetailReg"><?php echo($timeon." Days Ago"); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Profile Views: </div><div class="DetailInput" id="DetailViews"><?php echo(mysqli_num_rows($views)); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">About Me: </div><div class="DetailInput" id="DetailAbout"><?php echo($row['about']);?></div></div>
		</div>


	</div>
</div>
</body>
</html>
<?php

}
else{
echo("Wrong URL.");
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$ip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];

mysqli_query($con, "INSERT INTO intrusions (`ip`, `comment`, `agent`) VALUES ('$ip', 'profile.php.php wrong id', '$agent')");
header( "refresh:3; url=index.php" ); 
}
?>