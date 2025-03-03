<?php
$id = $_POST['id'];
$newLockVal = $_POST['lock'];
$mysqli = new mysqli("localhost", "AdminSJ", "password", "Standard_JobsDB");

if($mysqli->connect_error){
    exit ('Could Not Connect');
}

$sql= "UPDATE SJ_Progress SET editLock = ? WHERE JobID = ?";

$stmt = $mysqli->prepare($sql);

if(!$stmt){
    die('Error in Preparing Statement: ' .$mysqli->error);
}

$stmt->bind_param('ii',$newLockVal,$id);

$stmt->execute();

$stmt->close();
$mysqli->close();
echo "Row Locked by User ";
?>