<?php

$mysqli = new mysqli("localhost", "AdminSJ", "password", "Standard_JobsDB");

if($mysqli->connect_error){
    exit ('Could Not Connect');
}

$sql= "UPDATE SJ_Progress SET editLock = 0 WHERE editLock = 1";

$stmt = $mysqli->prepare($sql);

if(!$stmt){
    die('Error in Preparing Statement: ' .$mysqli->error);
}


$stmt->execute();

$stmt->close();
$mysqli->close();

?>