<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors',1);
//Connection block.
if(isset($_SESSION['usrID'])){//
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$userId = $_SESSION['usrID'];

if(isset($_POST['saveChar'])){
	$newAva = $_POST['newChar'];
	mysqli_query($con, "UPDATE users SET avatar='$newAva' WHERE id=$userId");
	header('Location: http://chaterix.com/myprofile.php');
}
else if(isset($_POST['editd'])){
	$newDesc = strip_tags(mysqli_escape_string($con,$_POST['newDescription']), "<b>, <br>, <i>, <u>");
	mysqli_query($con, "UPDATE users SET about='$newDesc' WHERE id=$userId");
	header('Location: http://chaterix.com/myprofile.php');
}
else if(isset($_POST['addNew'])){
	$title = $_POST['newsTitle'];
	$description = $_POST['newsText'];
	$time = date("H:i d-M-y");
	mysqli_query($con, "INSERT INTO news (`title`, `text`, `date`) VALUES ('$title', '$description', '$time')");
	header('Location: http://chaterix.com/myprofile.php');
}


//Getting profile data.
$query = mysqli_query($con,"SELECT * FROM users WHERE id=$userId");
$row = mysqli_fetch_assoc($query);


//Admin Panel.
if($row['level'] == "Admin"){
	echo("
	<div id='AdminPanel'>
	<div id='Title'>Admin Panel</div>
	<input type='button' onclick='addNews(\"new\");' id='newsAdd' value='Add News Record'/>

	</div>
	");
	
	echo("<form id='newsForm' style='display: none;' method='POST' action='myprofile.php'>
	<input type='text' name='newsTitle' placeholder='Title of News'/>
	<textarea name='newsText' placeholder='News Description'></textarea>
	<input type='submit' name='addNew' value='Add Record'/>
	<input type='button' onclick='addNews(\"close\");' value='Cancel'/>
	
	</form>");
}

//Retrieve messages;
	$msgGet = mysqli_query($con, "SELECT * FROM pmessages WHERE msgto=$userId");
	$msgGetUnread = mysqli_query($con, "SELECT * FROM pmessages WHERE msgto=$userId AND msgread=0");
	$totalMsg = mysqli_num_rows($msgGet);
	$newMsg = mysqli_num_rows($msgGetUnread);



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
<link href="public/styles/AccPage.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://chaterix.com/public/char.js"></script>
<script src="http://chaterix.com/public/enter.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="public/styles/CharEditor.css" rel="stylesheet" type="text/css"/>
<?php
if($row['level'] == "Admin"){
?>
<link href="public/styles/administratorPanelSettings.css" rel="stylesheet" type="text/css"/>
<?php
}
?>
<link href="public/styles/home.css" rel="stylesheet" type="text/css"/>
<link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
	function addNews(ops){
	var news = document.getElementById("newsForm");
	if(ops == "new"){
	news.style.display = "block";
	}
	else if(ops == "close"){
	news.style.display = "none";
	}
	}


	function LoadCountry(){
	var ipa = document.getElementById("user_ip").value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","getcountry.php",false);
	xmlhttp.send("ip="+ipa);


	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	var response = xmlhttp.responseText;
	var i = document.getElementById("country_field");
	i.value = response;
	}
	else{
	document.getElementById("input_error").innerHTML = "Unable to get Country.";
	}
	}	
	
	function EditorLoad(){
		var ld = document.getElementById("ldr");
		var edd = document.getElementById("changeDesc");
		ld.style.display = "block";
		edd.style.display = "none";
		
		LoadEditorChar('<?php echo($row['avatar']); ?>');
	}
	function EditDesc(){
	var ld = document.getElementById("ldr");
	var edd = document.getElementById("changeDesc");
	edd.style.display = "block";
	ld.style.display = "none";
	}
	
</script>
</head>
<body onload="LoadCharDiv('<?php echo($row['avatar']); ?>', 'AvatarImgFrame');startTime();">
<div style="display: none;" id="changeDesc"><form method="POST" action="myprofile.php">
<textarea name="newDescription"><?php echo($row['about']); ?></textarea>
<div id="newInfo">Note: You may use &lt;b&gt;, &lt;u&gt;, &lt;i&gt; and &lt;br&gt; tags for formatting.<input type="submit" name="editd" value="Save Changes"/></div>

</form></div>
<div style="display: none;" id="ldr"><div id="CharBuilderParentEdit">
<div id="CharBuilderElements">
</div>
<div id="CharBuilderControls">
<form action="myprofile.php" id="CharEditor" method="POST">
<div id="Change">
<img class="builder_control_back" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('skins', 'prev');"/>
<class id="builder_label">Skin</class>
<img class="builder_control_front" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('skins', 'next');"/>
</div>

<div id="Change">
<img class="builder_control_back" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('hair', 'prev');"/>
<class id="builder_label">Hair</class>
<img class="builder_control_front" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('hair', 'next');"/>
</div>

<div id="Change">
<img class="builder_control_back" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('eyes', 'prev');"/>
<class id="builder_label">Eyes</class>
<img class="builder_control_front" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('eyes', 'next');"/>
</div>

<div id="Change">
<img class="builder_control_back" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('mouth', 'prev');"/>
<class id="builder_label">Mouth</class>
<img class="builder_control_front" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('mouth', 'next');"/>
</div>

<div id="Change">
<img class="builder_control_back" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('torso', 'prev');"/>
<class id="builder_label">Top</class>
<img class="builder_control_front" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('torso', 'next');"/>
</div>

<div id="Change">
<img class="builder_control_back" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('pants', 'prev');"/>
<class id="builder_label">Bottoms</class>
<img class="builder_control_front" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('pants', 'next');"/>
</div>

<div id="Change">
<img class="builder_control_back" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('shoes', 'prev');"/>
<class id="builder_label">Shoes</class>
<img class="builder_control_front" src="http://claro.mib.infn.it/arrow.png" onclick="SwitchElement('shoes', 'next');"/>
</div>
<input type="text" hidden id="finalCode" name="newChar"/>
<input type="submit" id="newCharSave" onclick="getCharCode();" name="saveChar" value="Save"/>
</form>
</div>
</div></div>
<div id="MainBody">
<?php
include 'enterthec.php';
?>
	<div id="DataFrame">
		<div id="controlData">
		<div class=""><input type="button" value="Sign out" onclick="LogOut();"	id="logout"/></div>
		<div id="EditChar"><input id="logout" type="button" value="Edit Character" onClick="EditorLoad();"/></div>
		<div class=""><input type="button" value="Edit Description" onclick="EditDesc();" id="logout"/></div>
		</div>
	</div>


	<div id="AccountFrame">
		<div id="AccountAvatar">
			<div id="AvatarImgFrame"><img src="http://upload.wikimedia.org/wikipedia/commons/c/cd/Placeholder_male_superhero_c.png" id="Acc_img"/></div>
			<input type="button" id="editProf" value="View Public Profile" onclick="window.location.href = 'http://chaterix.com/profile.php?user=<?php echo($userId);?>';" name="sendPm"/>
		</div>
		<div id="AccountInfo">
			<div id="NameObject" class="DetailObjects"><div class="DetailLabel"><?php echo($row['first_name'] ."&nbsp". $row['last_name'] ."&nbsp;". "(".$row['username'].")");?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Age: </div><div class="DetailInput" id="DetailAge"><?php echo($age); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Country: </div><div class="DetailInput" id="DetailCountry"><?php echo($row['country']); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">User Type: </div><div class="DetailInput" id="DetailType"><?php echo($row['level']); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Registered: </div><div class="DetailInput" id="DetailReg"><?php echo($timeon." Days Ago"); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">Profile Views: </div><div class="DetailInput" id="DetailViews"><?php echo(mysqli_num_rows($views)); ?></div></div>
			<div class="DetailObjects"><div class="DetailLabel">About Me: </div><div class="DetailInput" id="DetailAbout"><?php echo($row['about']);?></div><!--<div id="editAbout" onclick="EditAbout();">(edit)</div>--></div>
		</div>

	</div>
</div>
<div id="editPiece">
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