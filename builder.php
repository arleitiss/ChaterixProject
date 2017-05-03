<!DOCTYPE html>
<html>
<head>
<title>Builder</title>
<link href="public/styles/CharEditor.css" rel="stylesheet" type="text/css"/>
<script src="http://chaterix.com/public/char.js"></script>
</head>
<body>
<div id="CharBuilderParent">
<div id="CharBuilderElements">
<img class="builder_element" id="skins" src="http://chaterix.com/public/images/char_elements/base.png">
<img class="builder_element" id="eyes" src="http://chaterix.com/public/images/char_elements/eyes/green.png"/>
<img class="builder_element" id="blinks" src="http://chaterix.com/public/images/char_elements/eyes/blinking.gif"/>
<img class="builder_element" id="hair" src="http://chaterix.com/public/images/char_elements/hair/black.png"/>
<img class="builder_element" id="mouth" src="http://chaterix.com/public/images/char_elements/mouth/happy.png"/>
<img class="builder_element" id="pants" src="http://chaterix.com/public/images/char_elements/pants/shorts.png"/>
<img class="builder_element" id="shoes" src="http://chaterix.com/public/images/char_elements/shoes/black.png"/>
<img class="builder_element" id="torso" src="http://chaterix.com/public/images/char_elements/torso/shirt.png"/>
</div>
<div id="CharBuilderControls">
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

</div>
</div>
</body>
</html>