<?php


$newLink = $_POST['link'];
$ID= $_POST['id'];
$linkName = $_POST['linkName'];

$user = "AdminSJ";
$password = "password";
$database = "Standard_JobsDB";
$table = "SJ_Progress";
$servername="localhost";

echo($newLink);
echo($ID);

//Database connection
$conn = new mysqli($servername, $user, $password, $database);

//check connection
if ($conn->connect_error){
  die("Connection failed:" . $conn->connect_error);
}

$sql = "UPDATE SJ_Progress SET hyperlink=? , HLName=? WHERE JobID =?";

$stmt=$conn->prepare($sql);
$stmt->bind_param('ssi',$newLink,$linkName,$ID);
$stmt->execute();
$conn->close();

?>