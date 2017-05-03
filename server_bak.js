var socket = io.connect();
var username = null;
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
function autoscale(){
	var v = window.innerHeight - 170;
	document.getElementById("chatEntries").style.height= v+"px";
	document.getElementById("chatUsers").style.height= v+"px";
}

function play(){
       var audio = document.getElementById("audio");
       audio.play();
       }
				 
function loadMessages(msg, pseudo, time){
	$("#chatEntries").append('<div class="messagesOLD">' +
	"<span class='msg_date'>"+dateFormat(time)+"</span><span class='msg_seperator'> | </span><span class='msg_name'>"+ pseudo + '</span> : ' + msg + '</div>');
	$('#chatEntries').scrollTop(1E10);
}

function addMessage(msg, pseudo){
	var post_date = new Date();
	var timesp = post_date;
	if(pseudo == "Me"){
	$("#chatEntries").append('<div class="message msg_owner">' +
	"<span class='msg_date'>"+dateFormat(timesp)+"</span><span class='msg_seperator'> | </span><span class='msg_name'>"+ pseudo + '</span> : ' + msg + '</div>');

	}
	else{
	$("#chatEntries").append('<div class="message">' +
	"<span class='msg_date'>"+dateFormat(timesp)+"</span><span class='msg_seperator'> | </span><span class='msg_name'>"+ pseudo + '</span> : ' + msg + '</div>');
	}
		$('#chatEntries').scrollTop(1E10);
	}


function sentMessage(){
	if($('#messageInput').val() != "")
	{
	socket.emit('message', $('#messageInput').val());
	addMessage($('#messageInput').val(), "Me", new Date().toISOString(),
	 true);
	$('#messageInput').val('');
	}
}

function getdisconnected(username){
	$('#'+username).remove();
}


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

		
		socket.on('loadusers', function(usernames){
		var listofusers = usernames;
		for(var i = 0; i < listofusers.length; i++){
			if(listofusers[i] == username){
			$('#chatUsers').append('<div class="user owner" id="'+listofusers[i]+'">'+listofusers[i]+' (Myself)</div');
			}
			else{
			
		$('#chatUsers').append('<div class="user" id="'+listofusers[i]+'">'+listofusers[i]+'</div');
			}
		}
		});
		
		socket.on('newuser', function(data){
		$('#chatUsers').append('<div class="user" id="'+data['username']+'">'+data['username']+'</div');
		
		});
		socket.on('heartbeat_users', function(data){
			var new_users = data['latest_users'];
			var old_users = getonlineusers();
			var users_dc = [];
			console.log('______________');
			var diff = $(old_users).not(new_users).get();	
			for(var i = 0; i < diff.length; i++){
			getdisconnected(diff[i]);
			};
			
			
		});
		
$(function() {

    $("#submit").click(function() {sentMessage();});
});
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
function getonlineusers(){
		var all = $("#chatUsers > div").map(function() {
		return this.id;
		}).get();
		return all;
}
	