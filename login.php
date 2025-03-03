<?php
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <script>
    var auth = "<?php echo $_SESSION['auth']; ?>";
    if (auth){
      location.replace("http://10.0.100.82/SJ_Progress.php");
    }
    </script>
    <title>SJ Progress - Login</title>
    <link rel="stylesheet" type ="text/css" href="/loginStyle.css">
  </head>
  <body>
  <div>

    <p>Login:
    <input type = 'text' id='uName' autofocus>
    </p>
    <br>
    <p>Password:
    <input type ='password' id='pWord'>
    </p>
    <br>

    <button type ='button' id = 'submit' onclick='submit()'>Enter</button>
  </div>
  <div id = 'log'> 
  </div>


  <script>
    var input = document.getElementById("pWord");
    input.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("submit").click();
     }
    });
    function submit(){
      var uInput = document.getElementById('uName').value;
      var pInput = document.getElementById('pWord').value;
      
      const xhttp = new XMLHttpRequest();

      const formData = new FormData();

      formData.append('username',uInput);
      formData.append('password',pInput);


      xhttp.onload = function(){
        var insInto = document.getElementById('log');
        
        var auth = "<?php echo $_SESSION['auth']; ?>";
        if(auth){
          location.replace("http://10.0.100.82/SJ_Progress.php");
          
          <?php 
          //session variables that need to be declared before list 
          $_SESSION['page'] =1;
          $_SESSION['tableLength'] =948; //used to calculate No of pages. Need to change
          $_SESSION['order'] ='DESC' ;
          $_SESSION['column'] ='Job_No';
          $_SESSION['displayName'] = 'Newest Job First' ;
           ?>;
        } 
	      if(!auth){//if auth not true user couldnt sign in with correct credentials
	      location.reload();
	      }
      } 

      xhttp.open("POST","checkCred.php");
      xhttp.send(formData);
    }
  </script>

    </body> 
