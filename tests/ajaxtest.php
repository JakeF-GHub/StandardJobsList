<!DOCTYPE html>
<head>
	<title> SJ Progress </title>
	<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
	<h2>STANDARD JOBS PROGRESS LIST</h2>
	<table>
		<tr>
			<th>Job Num</th>
			<th>Card Qty</th>
			<th>Date Created</th>
			<th>Date Issued</th>
			<th>Del Sch</th>
			<th>D/P</th>
			<th>Process Description</th>
			<th>Delivery Date</th>
			<th>Recieved from Stores</th>
			<th>Sent to Fab</th>
			<th>Date Packed</th>
			<th>Packed</th>
			<th>Late</th>
			<th>Missing BFI</th>
			<th>Comments</th>
		</tr>
		<?php
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
		//prepared statement
		$sql ="SELECT *  FROM " .$table;
		$result =$conn->query($sql);

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo"<tr>";
				echo "<td>" . $row["Job_No"] . "</td>";
				echo "<td>" . $row["Card_Qty"] . "</td>";
				echo "<td>" . $row["Date_Created"] . "</td>";
			        echo "<td>" . $row["Date_Issued"] . "</td>";
        			echo "<td>" . $row["Del_Sch"] . "</td>";
      			 	echo "<td>" . $row["DP_Tappings"] . "</td>";
       				echo "<td>" . $row["Process_Desc"] ."<br><input type = 'text' id ='desc' name ='new_pro_desc'></td>";
        			echo "<td>" . $row["Del_Date"] . "</td>";
       	 			echo "<td>" . $row["Recieved_From_Stores"] . "</td>";
        			echo "<td>" . $row["Sent_to_Fab"] . "</td>";
        			echo "<td>" . $row["Date_Packed"] . "</td>";
        			echo "<td>" . $row["Packed"] . "</td>";
        			echo "<td>" . $row["Late"] . "</td>";
        			echo "<td>" . $row["Missing_BFI"] . "</td>";
        			echo "<td>" . $row["Comments"] . "</td>";
				echo "</tr>";
			}

		}else {
			echo "<tr><td colspan = '2'>No data found </td></tr>";
		}
		$conn->close();
		?>
	</table>
  <form action="">
    <select name="Job" onchange="showJob(this.value)">
      <option value="">Select Job No.</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="53626">53626</option>
    </select>
  </form>
  <br>
  <div id= "txtHint">Job info Will be displayed here...</div>

  <script>
  function showJob(str) {
    if (str== "") {
      document.getElementById("txtHint").innerHTML = "Job info will be displayed here...";
      return;
    }
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("txtHint").innerHTML = this.responseText;
    }
    xhttp.open("GET", "getjob.php?q="+str);
    xhttp.send();
  }
</script>
