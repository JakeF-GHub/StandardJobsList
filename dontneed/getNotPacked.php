<?php

$mysqli = new mysqli("localhost", "AdminSJ", "password", "Standard_JobsDB");
if($mysqli->connect_error){
  exit('Could not Connect');
}
$param = "YES";
$sql = "SELECT * FROM SJ_Progress WHERE Packed !=?";

$stmt = $mysqli->prepare($sql);

if(!$stmt){
  die("Error in preparing statement: " .$mysqli->error);
}

$stmt->bind_param('s',$param);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()){
    if($row["editLock"] ==1){
      echo "<tr class='Locked' id=".$row["JobID"].">";
    }
    else{echo"<tr id=".$row["JobID"].">";}

    if($row["Strike"]==1){

      echo "<td class='edite'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Job_No"] . "</textarea></td>";
      echo "<td class='edite'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Card_Qty"] . "</textarea></td>";

      if ($row["Date_Created"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Date_Created"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='strike datePkr'></td>";}
    
      if ($row["Date_Issued"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Date_Issued"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='strike datePkr'></td>";}
      echo "<td class='edite'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Del_Sch"] . "</textarea></td>";
      echo "<td class='edite'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["DP_Tappings"] . "</textarea></td>";
      echo "<td class='edite'><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Process_Desc"] . "</textarea></td>";
    
      if ($row["Del_Date"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='strike datePkr' id='delDateNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Del_Date"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='strike datePkr' id='delDateNo".$row["JobID"]."'></td>";}
    
      if ($row["Recieved_From_Stores"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Recieved_From_Stores"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='strike datePkr'></td>";}
    
      if ($row["Sent_to_Fab"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Sent_to_Fab"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='strike datePkr'></td>";}
    
      if ($row["Date_Packed"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='strike datePkr' id='dPackedNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Date_Packed"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='strike datePkr' id='dPackedNo".$row["JobID"]."'></td>";}
    
      echo "<td class='strike  noEdit' id='packedNo".$row["JobID"]."'>" . $row["Packed"] . "</td>";
      echo "<td class='strike  noEdit' id='lateNo".$row["JobID"]."'>" . $row["Late"] . "</td>";
      echo "<td class=' edite'><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Missing_BFI"] . "</textarea></td>";
      echo "<td class=' edite'><div class ='dropdown'><button id='hidden' class='dropbtn' type='button' onclick='dropdown()'>Menu</button><div id='dropdownList' class='dropdown-content'><a onclick='strikeThrough()'>Striketrough row</a><a href='#'>Highlighting</a><a href='#'>...</a></div></div><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
      echo "</tr>";
     }

    else{

      echo "<td class='edite'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Job_No"] . "</textarea></td>";
      echo "<td class='edite'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Card_Qty"] . "</textarea></td>";
      
      if ($row["Date_Created"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Date_Created"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='datePkr'></td>";}
    
      if ($row["Date_Issued"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Date_Issued"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='datePkr'></td>";}
      echo "<td class='edite'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Del_Sch"] . "</textarea></td>";
      echo "<td class='edite'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["DP_Tappings"] . "</textarea></td>";
      echo "<td class='edite'><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Process_Desc"] . "</textarea></td>";
    
      if ($row["Del_Date"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='datePkr' id='delDateNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Del_Date"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='datePkr' id='delDateNo".$row["JobID"]."'></td>";}
    
      if ($row["Recieved_From_Stores"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Recieved_From_Stores"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='datePkr'></td>";}
    
      if ($row["Sent_to_Fab"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Sent_to_Fab"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='datePkr'></td>";}
    
      if ($row["Date_Packed"] !== "0000-00-00"){
        echo "<td class='date'><input type='text' class ='datePkr' id='dPackedNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Date_Packed"])) ."'></td>";
      }
      else{echo "<td class='date'><input type='text' class ='datePkr' id='dPackedNo".$row["JobID"]."'></td>";}
    
      echo "<td class='noEdit' id='packedNo".$row["JobID"]."'>" . $row["Packed"] . "</td>";
      echo "<td class='noEdit' id='lateNo".$row["JobID"]."'>" . $row["Late"] . "</td>";
      echo "<td class='edite'><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Missing_BFI"] . "</textarea></td>";
      echo "<td class='edite'><div class ='dropdown'><button id='hidden' class='dropbtn' type='button' onclick='dropdown()'>Menu</button><div id='dropdownList' class='dropdown-content'><a onclick='strikeThrough()'>StrikeTrough</a><a>Highlighting</a><a>...</a></div></div><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
      echo "</tr>";
    }
  }

  }
  else {
    echo "<tr><td colspan = '2'>No data found </td></tr>";
  }


$stmt->close();
$mysqli->close();
?>