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

$check=$_POST['checking'];
$page=$_POST['page'];

$column =$_SESSION['column'];
$order= $_SESSION['order'];


//runs once when loaded
if ($check==0){

  $offset3 = getOffset();
  
  
  $sql = "SELECT *  FROM  SJ_Progress ORDER BY $column $order LIMIT 50 OFFSET $offset3";
  

  $sql2 ="SELECT COUNT(*) FROM SJ_Progress";

  $result =$conn->query($sql);

  $oldRes = makeArray($result);

  $countO =$conn->query($sql2);
  $count = $countO->fetch_assoc();
 
  $_SESSION['tableLength']=$count["COUNT(*)"];
  $_SESSION['old_result']= $oldRes;
  returnResult($_SESSION['column'],$_SESSION['order']);
}
//setInerval update
elseif ($check==1){

  // THIS METHOD CHECKS WHOLE LIST FOR CHANGES MIGHT STILL BE NEEDED FOR FULL LIST VIEW  
  /*
  $sql ="SELECT * FROM SJ_Progress";

  $result2 =$conn->query($sql);
  
  $newRes = makeArray($result2);
  
  $oldRes = $_SESSION['old_result'];

  compare($newRes,$oldRes);
*/
  $offset2 = getOffset();

  $sql = "SELECT *  FROM  SJ_Progress ORDER BY $column $order LIMIT 50 OFFSET $offset2";
  $result2 =$conn->query($sql);  

  $newRes = makeArray($result2);

  $oldRes = $_SESSION['old_result'];

  compare($newRes,$oldRes);

}

//last page
elseif($check==3){
  if ($_SESSION['page']>0){
    $_SESSION['page']+= -1;
  }

  else{
    $_SESSION['page']=0;
  }

  returnResult($_SESSION['column'],$_SESSION['order']);

}

//next page
elseif($check==4){
  $_SESSION['page']+= 1;
  returnResult($_SESSION['column'],$_SESSION['order']);

}
//select page
elseif($check==5){
  $_SESSION['page']=$page;
  returnResult($_SESSION['column'],$_SESSION['order']);

}

//filters
elseif($check==6){
  $offset4 = getOffset();
  $_SESSION['order']= $_POST['order'];
  $order = $_POST['order'];
  $_SESSION['column']= $_POST['col'];
  $column = $_POST['col'];
  $_SESSION['displayName']= $_POST['displayName'];

  $sql = "SELECT *  FROM  SJ_Progress ORDER BY $column $order LIMIT 50 OFFSET $offset4";
  
  $result =$conn->query($sql);

  $oldRes = makeArray($result);

  $_SESSION['old_result']= $oldRes;

  returnResult($_POST['col'],$_POST['order']);

}

function makeArray($result){
  $a1=[];
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $a1[] =$row;
      }
  }
  return $a1;
}

function compare($a1,$a2){
  if($a1==$a2){
      echo"2";
  }
  else{
      returnResult($_SESSION['column'],$_SESSION['order']);
      $_SESSION['old_result']=$a1;
  }
    
}
function getOffset(){
  $pageNo=$_SESSION['page'];
  if($pageNo <=0){
    $pageNo =0;
  }
  if ($pageNo==0){
    $offset = $pageNo * 50;
  }
  else{
    $offset = ($pageNo-1) * 50;
  }
 
  return $offset;
}
//conn isnt being closed 
function returnResult($column ="JobID" , $order="DESC"){
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

  $offset = getOffset();
  
  $sql ="SELECT *  FROM  SJ_Progress ORDER BY $column $order LIMIT 50 OFFSET $offset";
  
  $stmt = $conn->prepare($sql);
 

  $stmt->execute();

  $result =$stmt->get_result();

  //for number of rows, create a new row and td's for all columns in database
  if ($result->num_rows > 0) {
    //echo"<tr><td>".getOffset()."</td></tr>";
    while($row = $result->fetch_assoc()) {
       
        if($row["editLock"] ==1){
          echo "<tr class='Locked' id=".$row["JobID"].">";
        }
        else{echo"<tr id=".$row["JobID"].">";}

        if($row["Strike"]==1){

           echo "<td class='edite jobNo ".$row['Tag']."'><div class = 'hyperlinkHidden'><a id='linkR".$row["JobID"]."' href='".$row['HLName']."'>".$row['hyperlink']."</a></div><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Job_No"] . "</textarea></td>";
           echo "<td class='edite cardQty'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Card_Qty"] . "</textarea></td>";

           if ($row["Date_Created"] !== "0000-00-00"){
             echo "<td class='date DC'><input type='text' class ='strike datePkr' value='" . date("d/m/Y",strtotime($row["Date_Created"])) ."'></td>";
           }
           else{echo "<td class='date DC'><input type='text' class ='strike datePkr'></td>";}
         
           if ($row["Date_Issued"] !== "0000-00-00"){
             echo "<td class='date DI'><input type='text' class ='strike datePkr' value='" . date("d/m/Y",strtotime($row["Date_Issued"])) ."'></td>";
           }
           else{echo "<td class='date DI'><input type='text' class ='strike datePkr'></td>";}
           echo "<td class='edite delSch'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Del_Sch"] . "</textarea></td>";
           echo "<td class='edite dpTappings'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["DP_Tappings"] . "</textarea></td>";
           echo "<td class='edite processDesc'><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Process_Desc"] . "</textarea></td>";
         
           if ($row["Del_Date"] !== "0000-00-00"){
             echo "<td class='date DD'><input type='text' class ='strike datePkr' id='delDateNo".$row["JobID"]."' value='" . date("d/m/Y",strtotime($row["Del_Date"])) ."'></td>";
           }
           else{echo "<td class='date DD'><input type='text' class ='strike datePkr' id='delDateNo".$row["JobID"]."'></td>";}
         
           if ($row["Recieved_From_Stores"] !== "0000-00-00"){
             echo "<td class='date RFS'><input type='text' class ='strike datePkr' value='" . date("d/m/Y",strtotime($row["Recieved_From_Stores"])) ."'></td>";
           }
           else{echo "<td class='date RFS'><input type='text' class ='strike datePkr'></td>";}
         
           if ($row["Sent_to_Fab"] !== "0000-00-00"){
             echo "<td class='date STF'><input type='text' class ='strike datePkr' value='" . date("d/m/Y",strtotime($row["Sent_to_Fab"])) ."'></td>";
           }
           else{echo "<td class='date STF'><input type='text' class ='strike datePkr'></td>";}
          
           if ($row["Date_Packed"] !== "0000-00-00"){
             echo "<td class='date DP'><input type='text' class ='strike datePkr' id='dPackedNo".$row["JobID"]."' value='" . date("d/m/Y",strtotime($row["Date_Packed"])) ."'></td>";
           }
           else{echo "<td class='date DP'><input type='text' class ='strike datePkr' id='dPackedNo".$row["JobID"]."'></td>";}
         
           echo "<td class='strike  noEdit' id='packedNo".$row["JobID"]."'>" . $row["Packed"] . "</td>";
           echo "<td class='strike  noEdit' id='lateNo".$row["JobID"]."'>" . $row["Late"] . "</td>";
           echo "<td class='edite missingBFI'><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Missing_BFI"] . "</textarea></td>";
           echo "<td class='edite comments'><div class ='dropdown'><button class='hidden dropbtn' type='button' onclick='dropdown()'>Menu</button><div class='dropdown-content'><a onclick='strikeThrough()'>StrikeTrough</a><a onclick='addHyperLink()'>Hyperlink</a><a class = 'subcontent'> < Highlights</a></div><div class='dropdown-subcontent hide'><a onclick=addTag('ccr')>CCR</a><a onclick=addTag('urgent')>Urgent</a><a onclick=addTag('bfi')>BFI Del / On Order</a><a onclick=addTag('testbay')>Test Bay</a><a onclick=addTag('pmi')>PMI</a><a onclick=addTag('late')>Late</a><a onclick=addTag('')>Clear</a></div></div><textarea class='longTxt strike' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
           echo "</tr>";
          }

        else{

          echo "<td class='edite jobNo ".$row['Tag']."'><div class = 'hyperlinkHidden'><a id='linkR".$row["JobID"]."' href='".$row['hyperlink']."'>".$row['HLName']."</a></div><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Job_No"] . "</textarea></td>";
          echo "<td class='edite cardQty'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Card_Qty"] . "</textarea></td>";

          if ($row["Date_Created"] !== "0000-00-00"){
            echo "<td class='date DC'><input type='text' class ='datePkr' value='" . date("d/m/Y",strtotime($row["Date_Created"])) ."'></td>";
          }
          else{echo "<td class='date DC'><input type='text' class ='datePkr'></td>";}
        
          if ($row["Date_Issued"] !== "0000-00-00"){
            echo "<td class='date DI'><input type='text' class ='datePkr' value='" . date("d/m/Y",strtotime($row["Date_Issued"])) ."'></td>";
          }
          else{echo "<td class='date DI'><input type='text' class ='datePkr'></td>";}
          echo "<td class='edite delSch'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Del_Sch"] . "</textarea></td>";
          echo "<td class='edite dpTappings'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["DP_Tappings"] . "</textarea></td>";
          echo "<td class='edite processDesc'><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Process_Desc"] . "</textarea></td>";
        
          if ($row["Del_Date"] !== "0000-00-00"){
            echo "<td class='date DD'><input type='text' class ='datePkr' id='delDateNo".$row["JobID"]."' value='" . date("d/m/Y",strtotime($row["Del_Date"])) ."'></td>";
          }
          else{echo "<td class='date DD'><input type='text' class ='datePkr' id='delDateNo".$row["JobID"]."'></td>";}
        
          if ($row["Recieved_From_Stores"] !== "0000-00-00"){
            echo "<td class='date RFS'><input type='text' class ='datePkr' value='" . date("d/m/Y",strtotime($row["Recieved_From_Stores"])) ."'></td>";
          }
          else{echo "<td class='date RFS'><input type='text' class ='datePkr'></td>";}
        
          if ($row["Sent_to_Fab"] !== "0000-00-00"){
            echo "<td class='date STF'><input type='text' class ='datePkr' value='" . date("d/m/Y",strtotime($row["Sent_to_Fab"])) ."'></td>";
          }
          else{echo "<td class='date STF'><input type='text' class ='datePkr'></td>";}
        
          if ($row["Date_Packed"] !== "0000-00-00"){
            echo "<td class='date DP'><input type='text' class ='datePkr' id='dPackedNo".$row["JobID"]."' value='" . date("d/m/Y",strtotime($row["Date_Packed"])) ."'></td>";
          }
          else{echo "<td class='date DP'><input type='text' class ='datePkr' id='dPackedNo".$row["JobID"]."'></td>";}
        
          echo "<td class='noEdit' id='packedNo".$row["JobID"]."'>" . $row["Packed"] . "</td>";
          echo "<td class='noEdit' id='lateNo".$row["JobID"]."'>" . $row["Late"] . "</td>";
          echo "<td class='edite missingBFI'><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Missing_BFI"] . "</textarea></td>";
          echo "<td class='edite comments'><div class ='dropdown'><button class='hidden dropbtn' type='button' onclick='dropdown()'>Menu</button><div class='dropdown-content'><a onclick='strikeThrough()'>StrikeTrough</a><a onclick='addHyperLink()'>Hyperlink</a><a class = 'subcontent'> < Highlights</a></div><div class='dropdown-subcontent hide'><a onclick=addTag('ccr')>CCR</a><a onclick=addTag('urgent')>Urgent</a><a onclick=addTag('bfi')>BFI Del / On Order</a><a onclick=addTag('testbay')>Test Bay</a><a onclick=addTag('pmi')>PMI</a><a onclick=addTag('late')>Late</a><a class = 'deleteFilter' onclick=addTag('X')>Clear</a></div></div><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
          echo "</tr>";
          
          }
          
      }
   
      
    
      }
      else {
        echo "<tr><td colspan = '2'>No data found </td></tr>";
    }
   
  }
?>
