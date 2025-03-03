<?php
session_start();
print_r($_SESSION);
?>

<!DOCTYPE html>
<script>
	var auth = "<?php echo $_SESSION['auth']; ?>";
  	if (!auth){
    	location.replace("http://10.0.100.82/login.php");
  	}
	</script>
<head>
	<title> SJ Progress </title>
	<!--my stylesheet-->
	<link rel="stylesheet" type="text/css" href="/styles.css">

	<!--table editor-->
	<script src ="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="/SimpleTableCellEditor.es6.min.js"></script>

	<!--date picker-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<body>
	<h2 id='test'>STANDARD JOBS PROGRESS LIST</h2>

	<!--div contains erorr message if data is ever entered incorrectly -->
	<div class = "alert" id='err'>
		<h3><span class = "exitbtn" onclick='closeAlert()'>&times;</span>
			Could not Submit Data!</h3>
		<script>
			function closeAlert(){
				document.querySelector('.alert').style.display='none';
			  document.querySelector('.stick1').style.top='0px';

			}
		</script>
	</div>
	<!--//main Table containing all the data -->
	<div class= 'controls'>
		<button id='changeView' type = 'button' onclick='toggleView("packed")'>See Packed Only</button>
		<button id='changeView' type = 'button' onclick='toggleView("All")'>See All</button>
		<button id='logout' type = 'button' onclick='logout()'>Logout</button>
	</div>
	<table id="SJ_table">
		<thead class='stick1'>
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
		</thead>
		<tbody id='ins_into'>

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
		//SQL to get all data
		$sql ="SELECT *  FROM " .$table;
		$result =$conn->query($sql);

		//for number of rows, create a new row and td's for all columns in database
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo"<tr id=".$row["JobID"].">";
				echo "<td class='editMe'>" . $row["Job_No"] . "</td>";
				echo "<td class='editMe'>" . $row["Card_Qty"] . "</td>";

				if ($row["Date_Created"] !== "0000-00-00"){
					echo "<td class='date'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Date_Created"])) ."'></td>";
				}
				else{echo "<td class='date'><input type='text' class ='datePkr'></td>";}

				if ($row["Date_Issued"] !== "0000-00-00"){
					echo "<td class='date'><input type='text' class ='datePkr' value='" . date("d-m-Y",strtotime($row["Date_Issued"])) ."'></td>";
				}
				else{echo "<td class='date'><input type='text' class ='datePkr'></td>";}
				echo "<td class='editMe'>" . $row["Del_Sch"] . "</td>";
				echo "<td class='editMe'>" . $row["DP_Tappings"] . "</td>";
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
				echo "<td class='edite'><textarea class='longTxt' oninput='resizeTxtArea(this)'>" . $row["Comments"] . "</textarea></td>";
				echo "</tr>";
			}

		}else {
			echo "<tr><td colspan = '2'>No data found </td></tr>";
		}

		$conn->close();
		?>
	</tbody>
	</table>

	<!--set elements with class 'datePkr' as datepicker widgets
 			*When a txt box is clicked on it opens a datepicker-->
	<script>

	var newDate;
		$(document).on("focus",".datePkr", function(){
			$(this).datepicker({dateFormat: "dd-mm-yy", altField:"#actualDate", altFormat:"yy-mm-dd"}).on('change',function(){
				newDate = $('#actualDate').val();
				console.log(newDate);
				submitDate();
				return newDate;
			});
		});

	//resizes all text areas when the page loads
	document.addEventListener("DOMContentLoaded",function(){
		const textareas = document.querySelectorAll('.longTxt');
		textareas.forEach(textarea => resizeTxtArea(textarea));
	});

	document.getElementById('SJ_table').addEventListener('keydown', function(event){

		if (event.key == 'Enter') {
			var target = event.target;
			if (target.tagName === 'TEXTAREA') {
				event.preventDefault();
				target.blur();
			}
		}
	});

		$(document).ready(function (){
			var logAllEvents= true;

			//Editor for all rows except date columns
			var advancedEditor = new SimpleTableCellEditor("SJ_table");

			advancedEditor.SetEditableClass("editMe");//any element with class 'editMe' is amde editable

			//This function runs after a cell has been editied
			$('#SJ_table').on("cell:edited", function (event) {
				console.log(`'${event.oldValue}' changed to '${event.newValue}'`);

				submit(event.element.parentElement.id,event.element.cellIndex,event.newValue);
			});

			//checkboxes
			$("#advancedToggle").on('click', function(e){
				advancedEditor.Toggle($(e.currentTarget).is(':checked'));
			})

			//logs alerts to the console
			//when a cell it clicked on & clicked off of
			if (logAllEvents) {

                $('table').on("cell:onEditEnter", function (event) {
                    console.log('onEditEnter event');
                });

                $('table').on("cell:onEditEntered", function (event) {
                    console.log('onEditEntered event');
                });

                $('table').on("cell:onEditExit", function (event) {
                    console.log('onEditExit event');
                });

                $('table').on("cell:onEditExited", function (event) {
                    console.log('onEditExited event');
                });
		}
	//end of simpletableeditor script
	});
	var row;
	var column;
	//adds event listeners to each text box
	function addEL(){
		var tds= document.querySelectorAll('.editMe , .date , .edite');
		//gets the position of the row and column to be used when the data is submitted to DB
		tds.forEach(td => {
			td.addEventListener('click', function() {

				const tr = this.parentNode;

				row = [...tr.parentNode.children].indexOf(tr)+1;

				column = [...tr.children].indexOf(this);


				console.log("Row: ", row, "Column: ", column, "td:",this,"tr:",tr);
				return row;
				return column;
			});
		});
	}
	addEL();

	$(document).on("focusout", ".longTxt", function(){
			var input = this.value;
			submit(row,column,input);
		})

	</script>
	<br>
	<!-- button to add new rows to the table-->
	<form id='submit' method="post" action="">
	<button id='newRow'type='button' onclick='addNewRow()'>Add New Row</button>
	</form>
	<input type="text" id="actualDate">


	<script>
	//function for submitting Packed , Late and any Date columns
	function submitDate(){


		//submits changed value to database if all 3 parameters are correct/not null
		if(row && column && newDate){
			console.log(row, column, newDate);
			submit(row,column,newDate);
		}

		else{console.log("Data Not Sent: ",row, column, newDate);}

		//gets date of both text boxes
		var datePacked=(document.getElementById('dPackedNo'+row)).value;
		var delDate=(document.getElementById('delDateNo'+row)).value;

		//make sure neither value is empty
		if(datePacked !="00-00-0000" && delDate !="00-00-0000" ){

			//sets Packed to YES if it has been edited
			if(column == 10){
				container = document.getElementById('packedNo'+row);
				console.log(datePacked);
				container.innerHTML="YES";
				submit(row,11,"YES");

			}

			//checks if delDate or Packed date were ediited for the Packed & Late check
			if(column == 7 || column == 10){

				var oldValue=(document.getElementById('lateNo'+row)).innerText;
				console.log(datePacked.substring(6));
				console.log(datePacked.substring(3,5));
				console.log(datePacked.substring(0,2));

				var container;
				if (datePacked.substring(6) < delDate.substring(6)){

					if(datePacked.substring(3,5) < delDate.substring(3,5)){
						container=document.getElementById('lateNo'+row);
						container.innerHTML="NO";
						submit(row,12,"NO");
						return;
				}
			}
				else if(datePacked.substring(6) == delDate.substring(6) && datePacked.substring(3,5) == delDate.substring(3,5)){

					if(datePacked.substring(0,2) <= delDate.substring(0,2)){
						container=document.getElementById('lateNo'+row);
						container.innerHTML="NO";
						submit(row,12,"NO");
						return;
					}
					else {
						console.log("date packed > delivery date");
						container=document.getElementById('lateNo'+row);
						container.innerHTML="YES";
						submit(row,12,"YES");
					}
				}
					//delivery is late if packed after deleivery date
				else{
					console.log("date packed > delivery date");
					container=document.getElementById('lateNo'+row);
					container.innerHTML="YES";
					submit(row,12,"YES");
				}
			}
		}
	}

	//xhttp req to add empty row into Database
	//returns another row at the bottom of the table

	function toggleView(filter){
		document.getElementById('ins_into').innerHTML = '';
		const xhttp = new XMLHttpRequest();

		xhttp.onload = function(){
			var tBody = document.getElementById('ins_into');
			tBody.insertAdjacentHTML('beforeend',this.responseText);
			addEL();
			const textareas = document.querySelectorAll('.longTxt');
			textareas.forEach(textarea => resizeTxtArea(textarea));

			return;
		}
		if(filter == "packed"){
			xhttp.open("POST","getPackedOnly.php");
		}
		else{
			xhttp.open("POST","getAllRows.php");
		}

		xhttp.send();


	}

	function addNewRow(){
		//console.log(inputValues);
		const xhttp = new XMLHttpRequest();

	   xhttp.onload = function(){
			var tBody = document.getElementById('ins_into');
		  tBody.insertAdjacentHTML('beforeend', this.responseText);

			addEL();

			return;
		}

      xhttp.open("POST","addRow.php");
      xhttp.send();

	}
	var buttonElement = document.getElementById("newRow");
	buttonElement.onclick = addNewRow;

	function errorMessage(){
		document.querySelector('.alert').style.display='block';
		document.querySelector('.stick1').style.top='40px';
	}

	//function to submit changed data to the DB , different parameters used based on the data's format
	function submit(row, column,newValue){
		console.log("row:"+row+" column:"+column+" NewVal:"+newValue);
		var report;

		const xhttp = new XMLHttpRequest();

		const formData = new FormData();

		formData.append('new',newValue);
		formData.append('index',column);
		formData.append('id',row);

		xhttp.onload = function(){
			report=this.responseText;
			//is a report returned?, if yes , log it , if not , show error message
			report ? console.log("Successful" +report) : errorMessage();
		}

		xhttp.open("POST", "sendDatea.php");
		xhttp.send(formData);

		}

	function resizeTxtArea(textarea) {

	  textarea.style.height = 'auto'; // Reset height to auto to calculate new height
	  textarea.style.height = textarea.scrollHeight + 'px'; // Set height to scrollHeight (content height)
	}

	function logout(){
		const xhttp = new XMLHttpRequest();
		xhttp.open("POST","endSession.php",true);
		xhttp.send();
		location.reload();
	}
	</script>
</body>
