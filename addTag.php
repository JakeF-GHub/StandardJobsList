<?php

$newTag = $_POST['tag'];
$iD = $_POST['row'];
$mysqli = new mysqli("localhost", "AdminSJ", "password", "Standard_JobsDB");

if($mysqli->connect_error){
    exit ('Could Not Connect');
}

$sql= "UPDATE SJ_Progress SET Tag = ? WHERE JobID = ?";

$stmt = $mysqli->prepare($sql);


if(!$stmt){
    die('Error in Preparing Statement: ' .$mysqli->error);
}

$stmt->bind_param('si',$newTag , $iD);
$stmt->execute();

$stmt->close();
$mysqli->close();
echo "added";
?>