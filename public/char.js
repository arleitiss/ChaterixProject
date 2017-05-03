var skins = [];
skins[0] = "http://chaterix.com/public/images/char_elements/base.png";
skins[1] = "http://chaterix.com/public/images/char_elements/base_dark.png";
skins[2] = "http://chaterix.com/public/images/char_elements/base_as.png";

var blinks = [];
blinks[0] = "http://chaterix.com/public/images/char_elements/eyes/blinking.gif";

var eyes = [];
eyes[0] = "http://chaterix.com/public/images/char_elements/eyes/blue.png";
eyes[1] = "http://chaterix.com/public/images/char_elements/eyes/green.png";
eyes[2] = "http://chaterix.com/public/images/char_elements/eyes/red.png";
eyes[3] = "http://chaterix.com/public/images/char_elements/eyes/aqua.png";
eyes[4] = "http://chaterix.com/public/images/char_elements/eyes/purple.png";
eyes[5] = "http://chaterix.com/public/images/char_elements/eyes/grey.png";
eyes[6] = "http://chaterix.com/public/images/char_elements/eyes/brown.png";
eyes[7] = "http://chaterix.com/public/images/char_elements/eyes/blackout.png";
eyes[8] = "http://chaterix.com/public/images/char_elements/eyes/whiteout.png";
eyes[9] = "http://chaterix.com/public/images/char_elements/eyes/crossed.png";

var hair = [];
hair[0] = "http://chaterix.com/public/images/char_elements/hair/black.png";
hair[1] = "http://chaterix.com/public/images/char_elements/hair/blond.png";
hair[2] = "http://chaterix.com/public/images/char_elements/hair/brown.png";

var mouth = [];
mouth[0] = "http://chaterix.com/public/images/char_elements/mouth/happy.png";
mouth[1] = "http://chaterix.com/public/images/char_elements/mouth/shut.png";

var pants = [];
pants[0] = "http://chaterix.com/public/images/char_elements/pants/shorts.png";
pants[1] = "http://chaterix.com/public/images/char_elements/pants/patrick.png";

var shoes = [];
shoes[0] = "http://chaterix.com/public/images/char_elements/shoes/black.png";
shoes[1] = "http://chaterix.com/public/images/char_elements/shoes/bleu.png";
shoes[2] = "http://chaterix.com/public/images/char_elements/shoes/bleu2.png";

var torso = [];
torso[0] = "http://chaterix.com/public/images/char_elements/torso/shirt.png";
torso[1] = "http://chaterix.com/public/images/char_elements/torso/google.png";

function LoadChar(code){
var data = code.split("c");
var blinker = blinks[0];

var skins2 = [skins[data[0]], eyes[data[1]], blinker, hair[data[2]], mouth[data[3]], pants[data[4]], shoes[data[5]], torso[data[6]]];
var inhtml = "";
for(var d = 0; d < skins2.length; d++){
inhtml = inhtml + "<img src='"+skins2[d]+"'/>";
}
//document.getElementById("out").innerHTML = inhtml;
}


function LoadCharDiv(codas, div){
var code = codas;
var data = code.split("c");
var blinker = blinks[0];



var skins2 = [skins[data[0]], eyes[data[1]], blinker, hair[data[2]], mouth[data[3]], pants[data[4]], shoes[data[5]], torso[data[6]]];
var inhtml = "";
for(var d = 0; d < skins2.length; d++){
inhtml = inhtml + "<img src='"+skins2[d]+"'/>";
}
document.getElementById(div).innerHTML = inhtml;
}


function LoadEditorChar(codas){
var code = codas;
var data = code.split("c");
var blinker = blinks[0];
var inhtml = "";

inhtml = inhtml + "<img class='builder_element' id='skins' src='"+skins[data[0]]+"'/>";
inhtml = inhtml + "<img class='builder_element' id='eyes' src='"+eyes[data[1]]+"'/>";
inhtml = inhtml + "<img class='builder_element' id='blinks' src='"+blinks[0]+"'/>";
inhtml = inhtml + "<img class='builder_element' id='hair' src='"+hair[data[2]]+"'/>";
inhtml = inhtml + "<img class='builder_element' id='mouth' src='"+mouth[data[3]]+"'/>";
inhtml = inhtml + "<img class='builder_element' id='pants' src='"+pants[data[4]]+"'/>";
inhtml = inhtml + "<img class='builder_element' id='shoes' src='"+shoes[data[5]]+"'/>";
inhtml = inhtml + "<img class='builder_element' id='torso' src='"+torso[data[6]]+"'/>";
document.getElementById("CharBuilderElements").innerHTML = inhtml;
}


function SwitchElement(type, order){
	var adr = type;
	var cur = this[adr].indexOf(document.getElementById(type).src);
	var source = document.getElementById(type);
	
	if(order == "next"){
	if(cur < this[adr].length-1){
	source.src = this[adr][cur+1];
	}
	else{
	source.src = this[adr][0];
	}
	}
	else if(order == "prev"){
	if(cur > 0){
	source.src = this[adr][cur-1];
	}
	else{
	source.src = this[adr][this[adr].length-1];
	}
	}//
}
function getCharCode(){
	var skn = skins.indexOf(document.getElementById("skins").src);
	var eye = eyes.indexOf(document.getElementById("eyes").src);
	var hr = hair.indexOf(document.getElementById("hair").src);
	var mth = mouth.indexOf(document.getElementById("mouth").src);
	var pnts = pants.indexOf(document.getElementById("pants").src);
	var shs = shoes.indexOf(document.getElementById("shoes").src);
	var trs = torso.indexOf(document.getElementById("torso").src);
	var finalChar = skn+"c"+eye+"c"+hr+"c"+mth+"c"+pnts+"c"+shs+"c"+trs;
	document.getElementById("finalCode").value = finalChar;
	document.getElementById("CharEditor").submit();
}

