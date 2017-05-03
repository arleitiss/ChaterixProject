	function enterMatrix(usrd){
		var xmlhttp;
		var usrd = usrd;
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
			xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText;
				if(response != "false"){
				var bot = document.getElementById("botStopper");
				bot.innerHTML = 
				"<form hidden id='botter' method='POST' action='http://chaterix.com:3000'>"+
				"<input type='text' name='userid' value='"+usrd+"'/>"+
				"<input type='text' name='email' value='"+response+"'/>";
				document.forms["botter"].submit();
				}
				else{
					document.write("Something happened. Please login again.");
				}
			}
		}
		xmlhttp.open("POST", "http://chaterix.com/enter.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("id="+usrd);
		
	}
	function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    m = checkTime(m);
    var weekday = new Array(7);
	weekday[0]=  "Sunday";
	weekday[1] = "Monday";
	weekday[2] = "Tuesday";
	weekday[3] = "Wednesday";
	weekday[4] = "Thursday";
	weekday[5] = "Friday";
	weekday[6] = "Saturday";

	var n = weekday[today.getDay()];
	
	//
    document.getElementById('headerTime').innerHTML = "<div id='iDay'>"+n+"</div><div id='iTime'>"+h+":"+m+"</div>";
    var t = setTimeout(function(){startTime()},500);
}

function checkTime(i) {
    if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
var chatee;
var checked;
function showMessages(){
	
		var xmlhttp;

		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
			xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText;
				if(response != "false"){
				var bot = document.getElementById("messagesBody");
				bot.style.display = "block";
				if($('#autoref').is(':checked')){
				checked = true;
				}
				else{
				checked = false;
				}
				
				//$('.myCheckbox').prop('checked', true);
				bot.innerHTML = response;
				$("#refresh").click(function() {
				showMessages();
				});

				$("#msgClose").click(function() {
				$( "#messagesBody" ).hide();
				});
				if(checked == true){
					$('#autoref').prop('checked', true);
				}
				
				
				}
				else{
					document.write("Something happened. Please login again.");
				}
			
			}
		}
		xmlhttp.open("POST", "http://chaterix.com/messageret.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("action="+"threads");
		
}
function readThread(msgfrom){
	chatee = msgfrom;
	var mso = msgfrom;
	var xmlhttp;

		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
			xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var response = xmlhttp.responseText;
				if(response != "false"){
				var bot = document.getElementById("messagesBody");
				if($('#autoref').is(':checked')){
				checked = true;
				}
				else{
				checked = false;
				}
				bot.innerHTML = response;
				
				
				
				$("#refresh").click(function() {
				readThread(chatee);
				});

				$("#msgClose").click(function() {
				$( "#messagesBody" ).hide();
				});
				
				$("#msgBack").click(function() {
				showMessages();
				});
				
				
				$('#msMain').scrollTop($('#msMain')[0].scrollHeight);
				if(checked == true){
					$('#autoref').prop('checked', true);
				}
				}
				else{
					document.write("Something happened. Please login again.");
				}
				
			}
		}
		xmlhttp.open("POST", "http://chaterix.com/messageret.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("action="+"messages&msid="+mso);
}


function sendReply(msn){
	$.post("messageret.php",
    {
        action: "reply",
        messenger: msn,
		message: $('#msText').val()
    },
    function(data, status){
        readThread(msn);
    });
}

var ajaxTimeout;


function poll() {
    if ($("#msBox").is(":visible")){
		if($('#autoref').is(':checked')){
		readThread(chatee);
		}
    }
	
}


$(function() {
    setInterval(poll, 5000)
});

function pollThreads() {
    if ($("#threadData").is(":visible")){
		if($('#autoref').is(':checked')){
		showMessages();
		}
    }
	
}


$(function() {
    setInterval(pollThreads, 5000)
});











