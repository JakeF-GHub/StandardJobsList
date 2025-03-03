<?php
$mysqli = new mysqli("localhost","AdminSJ","password","Standard_JobsDB");
if($mysqli->connect_error){
	exit('Could not Connect');
}

$sql = "INSERT INTO SJ_Progress () VALUES ()";

$stmt = $mysqli->prepare($sql);

if(!$stmt){
	die('Error in Preparing Statement: ' .$mysqli->error);
}
$stmt->execute();
$stmt->close();

$sql2 = "SELECT JobID , hyperlink , HLName FROM SJ_Progress ORDER BY JobID Desc";
$stmt2 = $mysqli ->prepare($sql2);

if (!$stmt2){
	die('Error in preparing Statement: ' .$mysqli->error);
}
$stmt2->execute();


$stmt2->bind_result($res,$hyperlink, $hyperlinkName);
$stmt2->fetch();
$stmt2->close();
$mysqli->close();

echo"<tr id=".$res.">";
echo"<td class='edite jobNo'><div class = 'hyperlinkHidden'><a id='linkR".$res."' href='".$hyperlink."'>".$hyperlinkName."</a></div><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>0</textarea></td>";
echo"<td class='edite cardQty'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>0</textarea></td>";
echo"<td class ='date DC'><input type='text' class ='datePkr'></td>";
echo"<td class ='date DI'><input type='text' class ='datePkr'></td>";
echo"<td class='edite delSch'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'></textarea></td>";
echo"<td class='edite dpTappings'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'></textarea></td>";
echo"<td class='edite processDesc'><textarea class='longTxt' oninput='resizeTxtArea(this)'></textarea></td>";
echo"<td class ='date DD'><input type='text' class ='datePkr' id='delDateNo".$res."'></td>";
echo"<td class ='date RFS'><input type='text' class ='datePkr'></td>";
echo"<td class ='date STF'><input type='text' class ='datePkr'></td>";
echo"<td class ='date DP'><input type='text' class ='datePkr' id='dPackedNo".$res."'></td>";
echo"<td class='noEdit' id='packedNo".$res."'></td>";
echo"<td class='noEdit' id='lateNo".$res."'></td>";
echo"<td class='edite missingBFI'><textarea class='longTxt' oninput='resizeTxtArea(this)'></textarea></td>";
echo "<td class='edite comments'><div class ='dropdown'><button class='hidden dropbtn' type='button' onclick='dropdown()'>Menu</button><div class='dropdown-content'><a onclick='strikeThrough()'>StrikeTrough</a><a onclick='addHyperLink()'>Hyperlink</a><a class = 'subcontent'> < Highlights</a></div><div class='dropdown-subcontent hide'><a onclick=addTag('ccr')>CCR</a><a onclick=addTag('urgent')>Urgent</a><a onclick=addTag('bfi')>BFI Del / On Order</a><a onclick=addTag('testbay')>Test Bay</a><a onclick=addTag('pmi')>PMI</a><a onclick=addTag('late')>Late</a><a onclick=addTag('')>Clear</a></div></div><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
echo "</tr>";
?>
