<?php
session_start();

$columnName = $_POST['colName'];
$order = $_POST['order'];
$type = $_POST['type'];
$pageNo=$_SESSION['page'];
if($pageNo <0){
  $pageNo =0;

}
$offset = $pageNo * 50;
$limit = "LIMIT 100";


$mysqli = new mysqli("localhost","AdminSJ","password","Standard_JobsDB");
if($mysqli->connect_error){
	exit('Could not Connect');
}

$sql= "SELECT * FROM SJ_Progress ORDER BY " .$columnName." " .$order." ".$limit." OFFSET ".$offset;






$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

      if($row["editLock"] ==1){
        echo "<tr class='Locked' id=".$row["JobID"].">";
      }
      else{echo"<tr id=".$row["JobID"].">";}

      if($row["Strike"]==1){

         echo "<td class='edite jobNo'><div class = 'hyperlinkHidden'><a id='linkR".$row["JobID"]."' href='".$row['hyperlink']."'>".$row['hyperlink']."</a></div><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Job_No"] . "</textarea></td>";
         echo "<td class='edite cardQty'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Card_Qty"] . "</textarea></td>";

         if ($row["Date_Created"] !== "0000-00-00"){
           echo "<td class='date DC'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Date_Created"])) ."'></td>";
         }
         else{echo "<td class='date DC'><input type='text' class ='strike datePkr'></td>";}
       
         if ($row["Date_Issued"] !== "0000-00-00"){
           echo "<td class='date DI'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Date_Issued"])) ."'></td>";
         }
         else{echo "<td class='date DI'><input type='text' class ='strike datePkr'></td>";}
         echo "<td class='edite delSch'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Del_Sch"] . "</textarea></td>";
         echo "<td class='edite dpTappings'><textarea class='strike longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["DP_Tappings"] . "</textarea></td>";
         echo "<td class='edite processDesc'><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Process_Desc"] . "</textarea></td>";
       
         if ($row["Del_Date"] !== "0000-00-00"){
           echo "<td class='date DD'><input type='text' class ='strike datePkr' id='delDateNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Del_Date"])) ."'></td>";
         }
         else{echo "<td class='date DD'><input type='text' class ='strike datePkr' id='delDateNo".$row["JobID"]."'></td>";}
       
         if ($row["Recieved_From_Stores"] !== "0000-00-00"){
           echo "<td class='date RFS'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Recieved_From_Stores"])) ."'></td>";
         }
         else{echo "<td class='date RFS'><input type='text' class ='strike datePkr'></td>";}
       
         if ($row["Sent_to_Fab"] !== "0000-00-00"){
           echo "<td class='date STF'><input type='text' class ='strike datePkr' value='" . date("d-m-Y",strtotime($row["Sent_to_Fab"])) ."'></td>";
         }
         else{echo "<td class='date STF'><input type='text' class ='strike datePkr'></td>";}
       
         if ($row["Date_Packed"] !== "0000-00-00"){
           echo "<td class='date DP'><input type='text' class ='strike datePkr' id='dPackedNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Date_Packed"])) ."'></td>";
         }
         else{echo "<td class='date DP'><input type='text' class ='strike datePkr' id='dPackedNo".$row["JobID"]."'></td>";}
       
         echo "<td class='strike  noEdit' id='packedNo".$row["JobID"]."'>" . $row["Packed"] . "</td>";
         echo "<td class='strike  noEdit' id='lateNo".$row["JobID"]."'>" . $row["Late"] . "</td>";
         echo "<td class='edite missingBFI'><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Missing_BFI"] . "</textarea></td>";
         echo "<td class='edite comments'><div class ='dropdown'><button id='hidden' class='dropbtn' type='button' onclick='dropdown()'>Menu</button><div id='dropdownList' class='dropdown-content'><a onclick='strikeThrough()'>Striketrough row</a><a href='#'>Highlighting</a><a href='#'>...</a></div></div><textarea class='strike longTxt' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
         echo "</tr>";
        }

      else{

        echo "<td class='edite jobNo'><div class = 'hyperlinkHidden'><a id='linkR".$row["JobID"]."' href='".$row['hyperlink']."'>".$row['hyperlink']."</a></div><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Job_No"] . "</textarea></td>";
        echo "<td class='edite cardQty'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Card_Qty"] . "</textarea></td>";
          
        if ($row["Date_Created"] !== "0000-00-00"){
          echo "<td class='date DC'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Date_Created"])) ."'></td>";
        }
        else{echo "<td class='date DC'><input type='text' class ='datePkr'></td>";}
      
        if ($row["Date_Issued"] !== "0000-00-00"){
          echo "<td class='date DI'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Date_Issued"])) ."'></td>";
        }
        else{echo "<td class='date DI'><input type='text' class ='datePkr'></td>";}
        echo "<td class='edite delSch'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["Del_Sch"] . "</textarea></td>";
        echo "<td class='edite dpTappings'><textarea class='longTxt' oninput='resizeTxtArea(this)' style='resize: none;'>" . $row["DP_Tappings"] . "</textarea></td>";
        echo "<td class='edite processDesc'><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Process_Desc"] . "</textarea></td>";
      
        if ($row["Del_Date"] !== "0000-00-00"){
          echo "<td class='date DD'><input type='text' class ='datePkr' id='delDateNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Del_Date"])) ."'></td>";
        }
        else{echo "<td class='date DD'><input type='text' class ='datePkr' id='delDateNo".$row["JobID"]."'></td>";}
      
        if ($row["Recieved_From_Stores"] !== "0000-00-00"){
          echo "<td class='date RFS'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Recieved_From_Stores"])) ."'></td>";
        }
        else{echo "<td class='date RFS'><input type='text' class ='datePkr'></td>";}
      
        if ($row["Sent_to_Fab"] !== "0000-00-00"){
          echo "<td class='date STF'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Sent_to_Fab"])) ."'></td>";
        }
        else{echo "<td class='date STF'><input type='text' class ='datePkr'></td>";}
      
        if ($row["Date_Packed"] !== "0000-00-00"){
          echo "<td class='date DP'><input type='text' class ='datePkr' id='dPackedNo".$row["JobID"]."' value='" . date("d-m-Y",strtotime($row["Date_Packed"])) ."'></td>";
        }
        else{echo "<td class='date DP'><input type='text' class ='datePkr' id='dPackedNo".$row["JobID"]."'></td>";}
      
        echo "<td class='noEdit' id='packedNo".$row["JobID"]."'>" . $row["Packed"] . "</td>";
        echo "<td class='noEdit' id='lateNo".$row["JobID"]."'>" . $row["Late"] . "</td>";
        echo "<td class='edite missingBFI'><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Missing_BFI"] . "</textarea></td>";
        echo "<td class='edite comments'><div class ='dropdown'><button id='hidden' class='dropbtn' type='button' onclick='dropdown()'>Menu</button><div id='dropdownList' class='dropdown-content'><a onclick='strikeThrough()'>StrikeTrough</a><a>Highlighting</a><a>...</a></div></div><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
        echo "</tr>";
        }
    }
  
    }
    else {
      echo "<tr><td colspan = '2'>No data found </td></tr>";
    }
?>