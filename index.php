<?php
session_start();
$_SESSION['valid'] = "true";
$con = mysqli_connect('localhost','root','[removed]','chaterix');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
$ip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
mysqli_query($con, "INSERT INTO hitter (`ip`, `agent`) VALUES ('$ip', '$agent')");

require_once('inc/recaptchalib.php');
$publickey = "6Ld_7PwSAAAAAGkObYS3-JqYq5ga2v-BlpHUAl-T";
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<link href="http://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css"/>
<link href="public/styles/home.css" rel="stylesheet" type="text/css"/>
<title>Chaterix Chat</title>
<script>
 var RecaptchaOptions = {
    theme : 'blackglass'
 };
 function ShowHideToggle(){
 if($("#home_footer").is(":visible") ){
	$("#reg_form").slideDown(1000);
	$("#home_footer").slideUp(1000);
	$("#header_logo").fadeOut(500);
	$("#hits").fadeOut(500);
	$("#online").fadeOut(500);
 }
 else{
	$("#reg_form").slideUp(1000);
	$("#home_footer").slideDown(1000);
	$("#header_logo").fadeIn(1000);
	$("#hits").fadeIn(1000);
	$("#online").fadeIn(1000);
 }
 }

 
window.onunload = function(){
document.getElementById("error").innerHTML = "";
};
function registerUser(){
LoadCountry();
ShowHideToggle();
}
function OnlineUsersAndHits(){
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("GET","onlinehitter.php",false);
xmlhttp.send();
  
if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	var response = xmlhttp.responseText;
	var counters = response.split("@");
	document.getElementById("hits_counter").innerHTML = counters[0];
	document.getElementById("online_counter").innerHTML = counters[1];
	if(counters[2] == "online"){
	document.getElementById("status_report").innerHTML = "<div id='statReport' class='fine'>Online</div>";
	}
	else{
	document.getElementById("status_report").innerHTML = "<div id='statReport' class='bad'>Offline</div>";
	}
	
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
function Validate(){
var resp = document.getElementById("recaptcha_response_field").value;
var chall = document.getElementById("recaptcha_challenge_field").value;
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.open("POST","ajaxCall.php",false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("chall="+chall+"&resp="+resp+"");

  
if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	var response = xmlhttp.responseText;
	if(response == "true"){
	document.forms["reg_form"].submit();
	}
	else{
	document.getElementById("input_error").innerHTML = "Wrong capcha, try again.";
	Recaptcha.reload();
	}
}	
}
setInterval(function(){
      OnlineUsersAndHits();
    },5000);
	
function showError(msg){
	document.getElementById("input_error").innerHTML = msg;
}
  
function CheckExistance(type){
var response = "exists";
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
	xmlhttp.open("POST","existance.php",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");


	if(type == "email"){
	var email = document.getElementById("email_field_reg").value;
		xmlhttp.send("email="+email+"");
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		return xmlhttp.responseText;
			}
	}
	else if(type == "nickname"){
	var nickname = document.getElementById("nickname_field").value;
		xmlhttp.send("nick="+nickname+"");
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		return xmlhttp.responseText;
	}
	}
	//return reponse;
}
  
function showUser() {
  var user = document.getElementById('email_field').value;
  var pass = document.getElementById('pass_field').value;
  
  if(user != "" && pass != ""){
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	var response = xmlhttp.responseText;
	if(response.indexOf("true") >= 0){
	var responses = response.split("-");
	document.getElementById('useid').value = responses[1];
	
	
	document.getElementById("error").innerHTML = "<span id='success'>Loading <img src='public/images/loading_symbol_small.gif'/></span>";
	  setTimeout(function () {
       document.forms["login_form"].submit();
    }, 3000);
	}
	

	else{
	document.getElementById("error").innerHTML = "<span id='fail'>Email or Password is incorrect.</span>";
	}
	}
  }
	xmlhttp.open("POST","validate.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("username="+user+"&password="+pass+"");
	}
	else{
	document.getElementById("error").innerHTML = "<span id='fail'>Please fill in both fields.</span>";
	}
	}

function Register(){
	showError("");
	var name = $("#name_field").val();
	var surname = $("#surname_field").val();
	var nickname = $("#nickname_field").val();
	var day = $("#dob_day").val();
	var month = $("#dob_month").val();
	var year = $("#dob_year").val();
	var email = $("#email_field_reg").val();
	var pass1 = $("#password_field_reg").val();
	var pass2 = $("#password_field2_reg").val();
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(name == "" || surname == "" || nickname == "" || day == "" || month == "" || year == "" || email == "" || pass1 == "" || pass2 == ""){
		showError("Some fields were left blank.");
	}
	else if(CheckExistance("nickname") == "exists"){
		showError("Nickname already in use.");
	}
	else if(re.test(email) == false){
		showError("Please specify correct email.");
		}
	else if(CheckExistance("email") == "exists"){
		showError("Email already in use.");
	}
	else if(pass1.length < 6){
		showError("Password length must be at least 6.");
	}
	else if(pass2 != pass1){
		showError("Passwords do not match.");
	}	
	else{
		Validate();
	}
}		
</script>
</head>
<body onload="OnlineUsersAndHits();">
<?php
$news = mysqli_query($con, "SELECT * FROM news ORDER BY id DESC");
echo("<div id='newsTab'>");
echo("<div id='newsLabel'>Announcements & News</div>");
while($row = mysqli_fetch_assoc($news)){
echo("
<div class='newsPiece'>
<div class='newsTitle'>Re: ".$row['title']."</div>
<div class='newsDesc'>".$row['text']."</div>
<div class='newsDate'>".$row['date']."</div>
</div>");
}
echo("</div>");


echo("<input type='text' id='user_ip' hidden disabled value='".$_SERVER['REMOTE_ADDR']."'/>"); ?>
<div id="home_header">
<form method="POST" id="reg_form" action="process.php" style="display:none;">
<div id='discard'><button type="button" onclick='registerUser();' id="discard_button"></button></div>
<div id='input_field_reg'><span id='label'>Name: </span><input type='text'  name='name' id='name_field' placeholder='Your Name'/></span></div>
<div id='input_field_reg'><span id='label'>Surname: </span><input type='text'  name='surname' id='surname_field' placeholder='Your Surname'/></span></div>
<div id='input_field_reg'><span id='label'>Nickname: </span><input type='text'  name='nickname' id='nickname_field' placeholder='Your Nickname for Chat'/></span></div>
<div id='input_field_reg'><span id='label'>Country: </span><input type='text'  name='country' readonly id='country_field' value="Unable to get Country"/></span></div>
<div id='input_field_reg'><span id='label'>Date of Birth: </span>
<span id='dob_selector'>
<input type='number' id="dob_day" min='1' max='31' placeholder='Day' name='dob_day'/>
<input type='number' id="dob_month" min='1' max='12' placeholder='Month' name='dob_month'/>
<input type='number' id="dob_year" min='1950' max='<?php echo date("Y"); ?>' placeholder='Year' name='dob_year'/>
</span>
</span></div>
<div id='input_field_reg'><span id='label'>Email: </span><input type='email'  name='email_reg' id='email_field_reg' placeholder='Your Email'/></span></div>
<div id='input_field_reg'><span id='label'>Password: </span><input type='password'  name='pass_reg' id='password_field_reg' placeholder='Password'/></span></div>
<div id='input_field_reg'><span id='label'>Retype Password: </span><input type='password'  id='password_field2_reg' name='pass_reg2' placeholder='Retype Password'/></span></div>
<div id='input_error'></div>
<div id='input_field_reg'><span id='label'></span><div id='capuchino'><?php echo recaptcha_get_html($publickey);?></div></span></div>
<div id='input_field_reg'><button type='button' onclick='Register();' id='reg_button_sub'  name='reg' placeholder='Register'>Register</button></span></div>
</form>
<img src="public/images/logo.png" id="header_logo"/>
<div id="status">Chat Status: <div id="status_report"></div></div>
<div id="hits">Total Hits: <div id="hits_counter"></div></div>
<div id="online">Online: <div id="online_counter"></div></div>
</div>
<div id="home_footer">
<div id="login">
<div id="error"></div>
<form method="POST" id="login_form" action="http://chaterix.com/myprofile.php"><input type="text" name="userid" id="useid" hidden="hidden"/>
<div id="email_part"><span id="email_label">E-Mail: </span><input type="text" name="email" id="email_field"/><button type="button" name="login" value="Login" onclick="showUser();" id="login_button">Login</button></div>
<div id="pass_part"><span id="pass_label">Password: </span><input type="password" name="pass" id="pass_field"/><button type="button" onclick="registerUser();" name="register" value="Register" id="reg_button">Register</button></div>
</form>
</div>
</div>
</body>
</html>
