<?php
$userId = $_SESSION['usrID'];
$msgGetUnread = mysqli_query($con, "SELECT * FROM pmessages WHERE msgto=$userId AND msgread=0");
$newMsg = mysqli_num_rows($msgGetUnread);
echo('<div id="botStopper">');
echo("<div style='display: none;' id='messagesBody'>");
echo("</div>");
echo('</div>');
echo('<div id="MainHeaderLogo"><a href="http://chaterix.com/myprofile.php"><img src="http://chaterix.com/public/images/logo.png"/></a>
<div id="MyData">');
if($newMsg != 0){
echo("<input id='myDataItem' onclick='showMessages();' class='newYes' type='button' value='My Messages(".$newMsg.")'/>");
}
else{
echo("<input id='myDataItem' onclick='showMessages();' type='button' value='My Messages(".$newMsg.")'/>");
}
echo("<form action='myprofile.php'><input id='myDataItem' type='submit' value='My Profile'/></form>");
echo("<input id='myDataItem' style='color: #0071ff;' type='button' onclick='enterMatrix(".$userId.");' value='Enter the Chat'/>");
echo('
</div>
<div id="headerTime"></div></div>');
?>