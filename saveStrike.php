<?php

$id = $_POST['id'];

$mysqli = new mysqli("localhost", "AdminSJ", "password", "Standard_JobsDB");

if($mysqli->connect_error){
  exit ('Could not Connect');
}

$sql = "SELECT Strike FROM SJ_Progress WHERE JobID = ".$id;



$result= $mysqli->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
      echo "strike: " . $row["Strike"];
      if($row["Strike"] ==0){
        $sql2 = "UPDATE SJ_Progress SET Strike =1 WHERE JobID = ?";

        $stmt = $mysqli->prepare($sql2);
        $stmt->bind_param('i',$id);   

      }

      else{
        $sql2 = "UPDATE SJ_Progress SET Strike =0 WHERE JobID = ?";

        $stmt = $mysqli->prepare($sql2);
        $stmt->bind_param('i',$id);
      }
    
    }
  } else {
    echo "0 results";
  }
$stmt->execute();
$mysqli->close();

?>