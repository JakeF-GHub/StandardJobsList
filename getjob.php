<?php
$mysqli = new mysqli("localhost", "AdminSJ", "password", "Standard_JobsDB");
if($mysqli->connect_error) {
  exit('Could not connect');
}

$sql = "SELECT Job_No, Card_Qty, Process_Desc FROM SJ_Progress WHERE Job_No = ?";

$stmt = $mysqli->prepare($sql);

if(!$stmt){
	die('Error in perparing statement: ' .$mysqli->error);
}

$stmt->bind_param("i",$_GET['q']);
$stmt->execute();

if ($stmt->errno) {
	die('Error in executing statement: ' .$stmt->error);
}

$stmt->store_result();
$stmt->bind_result($jno, $jcard_qty, $jprocess_desc);
$stmt->fetch();
$stmt->close();

echo "<table>";
echo "<tr>";
echo "<th>Job No</th>";
echo "<td>" . $jno . "</td>";
echo "<th>Card qty</th>";
echo "<td>" . $jcard_qty . "</td>";
echo "<th>Description</th>";
echo "<td>" . $jprocess_desc . "</td>";
echo "</tr>";
echo "</table>";

 ?>
