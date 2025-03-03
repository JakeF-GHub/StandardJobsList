<DOCTYPE html!>
<head>
<title>Onclick test</title>
<style>
.hide{
	display:none;
}

.show{
	display:block;
}
</style>
</head>

<body>
<div class ="answer_list"> Welcome </div>
<input type ="button" name="answer" value="Show Text Field" onclick="onButtonClick()"/>
<input class="hide" type="text" id="textInput" value="..." />

<script>
function onButtonClick(){
        if(document.getElementById("textInput").className=="hide") {

		document.getElementById("textInput").className="show";
} else {document.getElementById("textInput").className="hide";}
}
</script>
