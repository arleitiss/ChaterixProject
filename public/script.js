var socket = io.connect();
var username = null;
var userarray = null;
var stream = ss.createStream();
var filename="profile.jpg";

ss(socket).emit('profile-image', stream, {name: filename});
fs.createReadStream(filename).pipe(stream);

function dateFormat( dateobj )
{
	var date = new Date( dateobj );
	var yyyy = date.getFullYear();
    var mm = date.getMonth() + 1;
    var dd = date.getDate();
    var hh = date.getHours();
    var min = date.getMinutes();
    var ss = date.getSeconds();
	var today = new Date();
	var todaydd = today.getDate();
	
	
	
	if((todaydd-dd) == 0){
	mysqlDateTime = "Today | "+hh+":"+min+":"+ss;
	}
	else if((todaydd-dd) == 1){
	mysqlDateTime = "Yesterday | "+hh+":"+min+":"+ss;
	}
	else{
	var mysqlDateTime = dd+"/"+mm+" | "+hh+":"+min+":"+ss;
	}
    return mysqlDateTime;
}
var smileys = [];
	smileys[":/"] = "derp.png";
	smileys[":)"] = "happy.png";
	smileys[":D"] = "laugh.png";
	smileys[":3"] = "meow.png";
	smileys[":{"] = "must.png";
	smileys[":V"] = "pac.png";
	smileys[":("] = "sad.png";
	smileys[":O"] = "surprised.png";
	smileys[":?"] = "wat.png";


function replaceEmoticons(str) {
    for (var key in smileys) {
        var re = new RegExp("" + key.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/gi, "\\$&") + "", 'gi');
        str = str.replace(re, "<img src='http://chaterix.com/public/images/smileys/" + smileys[key] + "' id='chat_smls'/>");
    }
    return (str);
}


function autoscale(){
	var v = window.innerHeight - 170;
	document.getElementById("entry_window").style.height= v+"px";
	document.getElementById("online_window").style.height= v+"px";
	$('#chatEntries').scrollTop(1E10);
}

function play(){
       var audio = document.getElementById("audio");
       audio.play();
       }
	   
function dcd(){
       var audio = document.getElementById("audio_dc");
       audio.play();
       }				 
function loadMessages(msg, pseudo, time){
	$("#chatEntries").append('<div class="messagesOLD">' +
	"<span class='msg_date'>"+dateFormat(time)+"</span><span class='msg_seperator'> | </span><span class='msg_name'>"+ pseudo + '</span> : ' + replaceEmoticons(msg) + '</div>');
}
/*
var newmsg = $('<div class="message msg_owner">' + 
    "<span class='msg_date'>"+dateFormat(timesp)+
    "</span><span class='msg_seperator'> | </span><span class='msg_name'>" +
    pseudo + '</span> : <span class="msg"></span></div>');

//insert the new message using .text, which will encode the message at this point
newmsg.find(".msg").text(msg)

$("#chatEntries").append(newmsg);
*/
function ActBox(nameof, pseudo, type){
	var nic = pseudo;
	var selec = ".action"+nameof;
	console.log(type+" / "+selec);
	if(type == "pop"){
	$('[id=actionBox]').not(selec).hide();
	$(selec).toggle();
	}
	else if(type == "rep"){
	$('#messageInput').val("@"+pseudo+" ");
	$('#messageInput').focus();
	
	}
	else if(type == "prof"){
	UserProfile(pseudo);
	}
	}




	var msgcount = 0;
function addMessage(msg, pseudo){

	var post_date = new Date();
	var timesp = post_date;
	if(pseudo == "Me"){
	var newmsg = $('<div class="message msg_owner">' + 
    "<span class='msg_date'>"+dateFormat(timesp)+
    "</span><span class='msg_seperator'> | </span><span class='msg_name'>" +
    pseudo + '</span> : <span class="msg"></span></div>');
	newmsg.find(".msg").text(msg).html(function(_, currentContent){
		return replaceEmoticons(currentContent);
	});
	$("#chatEntries").append(newmsg);
	

	
	/*
	$("#chatEntries").append('<div class="message msg_owner">' +
	"<span class='msg_date'>"+dateFormat(timesp)+"</span><span class='msg_seperator'> | </span><span class='msg_name'>"+ pseudo + '</span> : ' + msg + '</div>');
*/
	}
	else if(replaceEmoticons(msg).indexOf(username) >= -0){
	$("#chatEntries").append('<div class="message" id="replier">' +
	"<span class='msg_date'>"+dateFormat(timesp)+"</span><span class='msg_seperator'> | </span><span onclick='ActBox(\""+pseudo+msgcount+"\", \""+pseudo+"\", \"pop\");'  class='msg_name'>"
	+"<div class='action"+pseudo+msgcount+"' id='actionBox'><div id='Prof' onclick='ActBox(\"action"+pseudo+msgcount+"\", \""+pseudo+"\", \"prof\");'>View Profile</div><div id='Reply' onclick='ActBox(\""+pseudo+msgcount+"\", \""+pseudo+"\",  \"rep\");'>Reply</div></div>"
	+ pseudo + '</span> : ' + replaceEmoticons(msg) + '</div>');
	$('[id=actionBox]').hide();	
	}
	else{
	$("#chatEntries").append('<div class="message">' +
	"<span class='msg_date'>"+dateFormat(timesp)+"</span><span class='msg_seperator'> | </span><span onclick='ActBox(\""+pseudo+msgcount+"\", \""+pseudo+"\", \"pop\");'  class='msg_name'>"
	+"<div class='action"+pseudo+msgcount+"' id='actionBox'><div id='Prof' onclick='ActBox(\"action"+pseudo+msgcount+"\", \""+pseudo+"\", \"prof\");'>View Profile</div><div id='Reply' onclick='ActBox(\""+pseudo+msgcount+"\", \""+pseudo+"\",  \"rep\");'>Reply</div></div>"
	+ pseudo + '</span> : ' + replaceEmoticons(msg) + '</div>');
	$('[id=actionBox]').hide();
	}
	$('#chatEntries').scrollTop(1E10);
	msgcount++;
	console.log(msgcount);
	}
	
	$(document).keypress(function(e){
    if (e.which == 13){
        $("#submit").click();
    }
});



function sentMessage(){
	if(($('#messageInput').val()).trim())
	{
	socket.emit('message', $('#messageInput').val());
	addMessage($('#messageInput').val(), "Me", new Date().toISOString(),
	 true);
	}
	$('#messageInput').val('');
}
function GoHome(){
	var loc = "http://chaterix.com/";
	window.location(loc);
}

function ToggleWindow(){
	var filterVal = 'blur(0px)';
	if($("#infoBox").css('display') == 'none'){
		$("#infoBox").show();
		filterVal = 'blur(15px)';
	}
	else{
		$("#infoBox").hide();
		filterVal = 'blur(0px)';
		$("#infoBox").html("");
	}
	
		$("#main_frame")
		.css('filter',filterVal)
		.css('webkitFilter',filterVal)
		.css('mozFilter',filterVal)
		.css('oFilter',filterVal)
		.css('msFilter',filterVal);
	}
function formatAgo(dor){
var a = new Date(dor);
var b = Date.parse(a);
var c = Date.parse(new Date());
var diff = c-b;
return (diff/1000/60/60/24);
}
	
function formatDob(dob){
var dof = dob.split("-");
var cs = new Date();
var cm = cs.getMonth();
var cd = cs.getDay();
var cy = cs.getFullYear();
var age = cy - dof[2];
if(cm < dof[1] || (cm == dof[1] && cd < dob[0])){
	age--;
}
return age;
}
	
function UserProfile(username){
	console.log("requested by: "+username);
	var dts;
	var d = new Date();
	var n = d.getMilliseconds();
	socket.emit("getuser", {
	'username' : username
	});
	socket.on("returnuser", function(data){
	dts = data['id'];
	var fname = data['first_name'];
	var sname = data['last_name'];
	var username = data['username'];
	var avatar = data['avatar'];
	var dob = data['dob'];
	
	var dateofreg = data['dor'];
	
	var country = data['country'];
	var level = data['level'];
	var innerGuy = document.getElementById("infoBox");
	innerGuy.innerHTML = 
	"<div id='InfoContainer'>"
		+"<div id='InfoHeader'><a href='http://chaterix.com/profile.php?user="+dts+"' target='_blank' id='VisitProfile'>View Profile(New Tab)</a><input type='button' onclick='ToggleWindow();' value='X'/></div>"
		+"<div id='InfoBody'>"
			+"<div id='InfoAvatar'><img src='http://chaterix.com/public/images/char_elements/base.png' id='AvatarImg'/></div>"
			+"<div id='InfoFrame'>"
				+"<div id='NameField'>"+fname+"&nbsp;"+sname+"&nbsp;("+username+")</div>"
				+"<div id='DetailsFields'>"
					+"<div class='InfoPiece'><div id='CountryPieceLabel' class='InfoLabel'>Country: </div><div id='CountryValue' class='InfoValue'>"+country+"</div></div>"
					+"<div class='InfoPiece'><div id='AgePieceLabel' class='InfoLabel'>Age: </div><div id='AgeValue' class='InfoValue'>"+formatDob(dob)+"</div></div>"
					+"<div class='InfoPiece'><div id='RegPieceLabel' class='InfoLabel'>Registered: </div><div id='RegValue' class='InfoValue'>"+Math.round(formatAgo(dateofreg))+" Days Ago</div></div>"
					+"<div class='InfoPiece'><div id='LevelPieceLabel' class='InfoLabel'>Level: </div><div id='LevelValue' class='InfoValue'>"+level+"</div></div>"
				+"</div>"
			+"</div>"
		+"</div>"
		+"</div>"
	+"</div>";
	LoadCharDiv(avatar, 'InfoAvatar');
	
	});
	ToggleWindow();
	var d2 = new Date();
	var n2 = d2.getMilliseconds();
	console.log("Exec Time: "+(Math.abs(n2 - n) / 1000)+" Seconds");
	}


function ShowDialog(type ,text){
	document.getElementById("chatUsers").innerHTML = "<span id='dialog_notice'><div id='dialog_type'>"+type+"<button type='button' onClick=\"location.href='http://chaterix.com/'\" id='dialog_discard'>X</button></div><div id='dialog_message'>"+text+"</div></span>";
}


function getdisconnected(username){
	$('#'+username).remove();
	SystemMessage(username + ' has disconnected');
}

	socket.on('disconnect', function () {
	ShowDialog("Disconnected", "You are not logged in.");
	})

	socket.on('message', function(data){
		addMessage(data['message'], data['pseudo']);
		$('#chatEntries').scrollTop(1E10);
		play();
		if (!document.hasFocus()){ 
		interval = setInterval(changeTitle, 700);
		}
	});
	
		socket.on('loadmsg', function(data){

		loadMessages(data['message'], data['nickname'], data['time']);
		});

		//Load users after joining chat.
		socket.on('loadusers', function(usernames){
		var listofusers = usernames['list'];
		username = usernames['myself'];
		for(var i = 0; i < listofusers.length; i++){
			if(listofusers[i] == username){
			$('#chatUsers').append('<div class="user owner" id="'+listofusers[i]+'" onclick="UserProfile(\''+listofusers[i]+'\');">'+listofusers[i]+' (Myself)</div');
			}
			else{
		$('#chatUsers').append('<div class="user" id="'+listofusers[i]+'" onclick="UserProfile(\''+listofusers[i]+'\');">'+listofusers[i]+'</div');
			}
		}
		});
		
		
		function SystemMessage(msg){
		$('#chatEntries').append('<div class="message_system"><span class="msg_name">System: </span>' + msg + '</div>');
		dcd();
		$('#chatEntries').scrollTop(1E10);
		}
		
		socket.on('new_user', function(data){
		$('#chatUsers').append('<div class="user" onclick="UserProfile(\''+data['username']+'\');" id="'+data['username']+'">'+data['username']+'</div');
		SystemMessage(data['username']+' has connected');
		});
	

		//Get current users in list (client side)
		function getonlineusers(){
		var all = $("#chatUsers > div").map(function() {
		return this.id;
		}).get();
		return all;
}
		socket.on('heartbeat_users', function(data){
			var new_users = data['latest_users'];
			var old_users = getonlineusers();
			var diff = $(old_users).not(new_users).get();	
			for(var i = 0; i < diff.length; i++){
			getdisconnected(diff[i]);
			};
			
			
		});
		

function addSmiley(id){
	var smilee = [];
	smilee[0] = ":/";
	smilee[1] = ":)";
	smilee[2] = ":D";
	smilee[3] = ":3";
	smilee[4] = ":{";
	smilee[5] = ":V";
	smilee[6] = ":(";
	smilee[7] = ":O";
	smilee[8] = ":?";
	var exdata = $('#messageInput').val();
	$('#messageInput').val(exdata+" "+smilee[id]);
	$('#messageInput').focus();
}

$(function() {
    $("#submit").click(function() {sentMessage();});
	$( "#infoBox" ).toggle();
	$('[id=actionBox]').hide();
	$('#chatEntries').scrollTop(1E10);
	var smiles = 
	"<img src='http://chaterix.com/public/images/smileys/derp.png' onclick='addSmiley(0);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/happy.png' onclick='addSmiley(1);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/laugh.png' onclick='addSmiley(2);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/meow.png' onclick='addSmiley(3);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/must.png' onclick='addSmiley(4);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/pac.png' onclick='addSmiley(5);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/sad.png' onclick='addSmiley(6);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/surprised.png' onclick='addSmiley(7);'/>"+
	"<img src='http://chaterix.com/public/images/smileys/wat.png' onclick='addSmiley(8);'/>";
	$("#iconsList").html(smiles);
	
	
	
	$('#emoticons').click(function(e) {
    $("#iconsList").toggle();
	});
	/*
	$('#userPhotoInput').change(function(e){
		var file = e.target.files[0];
		var stream = ss.createStream();
		ss(socket).emit('image'), stream, {size: file.size});
		ss.createBlobReadStream(file).pipe(stream);
		
	});*/
	
	});


//Notification action.
var title = "Chaterix.com Chat";
var new_title = "New Message";
function changeTitle() {
	if(document.title == title){
	document.title = new_title;
	}
	else if(document.title == new_title){
	document.title = title;
	}
	
}
interval = null;
$(window).focus(function () {
    clearInterval(interval);
    $("title").text(title);
});
$("#entry_window").mouseover(function() {
	clearInterval(interval);
	$("title").text(title);
});
	