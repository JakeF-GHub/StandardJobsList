<?php
session_start();

$user = "AdminSJ";
$password = "password";
$database = "Standard_JobsDB";
$table = "SJ_Progress";
$servername="localhost";

//Database connection
$conn = new mysqli($servername, $user, $password, $database);

//check connection
if ($conn->connect_error){
  die("Connection failed:" . $conn->connect_error);
}

$sql= "SELECT JobID, editLock , Strike FROM SJ_Progress WHERE Editlock = 1 OR Strike =1";

$result = $conn->query($sql);

$array= makeArray($result);

$js_array = json_encode($array);

echo "var javasArray = ".$js_array . ";\n";


function makeArray($result){
    $a1=[];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $a1[] =$row;
        }
    }
    return $a1;
  }
  