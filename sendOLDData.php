<?php
$oldVal = $_POST['old'];
$newVal = $_POST['new'];
$index = $_POST['index'];
$id = $_POST['id'];

switch ($index){
  case 0:

    $columnName ='Job_No';
    break;
  case 1:
    $columnName ='Card_Qty';
    break;
  case 2:
    $columnName ='Date_Created';
    break;
  case 3:
    $columnName ='Date_Issued';
    break;
  case 4:
    $columnName ='Del_Sch';
    break;
  case 5:
    $columnName ='DP_Tappings';
    break;
  case 6:
    $columnName ='Process_Desc';
    break;
  case 7:
    $columnName ='Del_Date';
    break;
  case 8:
    $columnName ='Recieved_From_Stores';
    break;
  case 9:
    $columnName ='Sent_to_Fab';
    break;
  case 10:
    $columnName ='Date_Packed';
    break;
  case 11:
    $columnName ='Packed';
    break;
  case 12:
    $columnName ='Late';
    break;
  case 13:
    $columnName ='Missing_BFI';
    break;
  case 14:
    $columnName='Comments';
    break;
  default:
    $columnName='Error';
}

$mysqli = new mysqli("localhost", "AdminSJ", "password", "Standard_JobsDB");
if($mysqli->connect_error){
  exit ('Could not Connect');
}

$sql = "UPDATE SJ_Progress SET $columnName = ? WHERE $columnName = ? AND JobID = ?";

$stmt = $mysqli->prepare($sql);

if(!$stmt){
  die('Error in Preparing Statement: ' .$mysqli->error);
}

$stmt->bind_param('ssi',$newVal,$oldVal,$id);

$stmt->execute();

$stmt->close();
$mysqli->close();

echo "Successful submission";

?>
