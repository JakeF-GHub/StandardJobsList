<?php
session_start();
$uName = $_POST['username'];
$pWord = $_POST['password'];
$auth ="False";
if($uName == null or $pWord == null){
    echo "<p> Username or Password Incorrect.</p>";
}
else{
    
    $mysqli = new mysqli("localhost","AdminSJ","password","Standard_JobsDB");
}


if($mysqli->connect_error){
    exit ('Could not Connect');
  }

  $sql = "SELECT login,first_name,last_name,password FROM user WHERE login =? AND password = ?";

  $stmt = $mysqli->prepare($sql);

if(!$stmt){
    die('Error in Preparing Statement: ' .$mysqli->error);
}

$stmt-> bind_param ('ss',$uName,$pWord);

$stmt->execute();

$stmt->store_result();
$stmt->bind_result($login,$fName,$sName,$pass);
$stmt->fetch();

if ($pass == $pWord){
    $auth="True";
    $_SESSION['auth']=$auth;
    $_SESSION['login']=$login;
    $_SESSION['fName']=$fName;
    $_SESSION['sName']=$sName;
    
        
}



$stmt->close();

echo "<p>true/false: ".$_SESSION['auth']."</p>";
echo "<p>username:".$login."</p>";
echo "<p>password:" .$pass ."</p>";
echo "<p>First:".$fName."</p>";
echo "<p>Last:".$sName."</p>";
$mysqli->close();
?>