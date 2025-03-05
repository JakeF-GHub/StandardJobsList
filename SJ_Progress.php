<?php
session_start();

?>

<!DOCTYPE html>
<script>
//redirects to login page if user hasnt logged in 
	let auth = "<?php echo $_SESSION['auth']; ?>";
  	if (!auth){
    	location.replace("http://10.0.100.82/login.php");
  	}
	</script>
<head>
	<title> Standard Jobs Progress</title>
	<!--favicon 
	<link rel="icon" type="image.png" href="https://staffboard/favicon.png"> -->
	<!--my stylesheet-->
	<link rel="stylesheet" type="text/css" href="/styles.css">

	<!--table editor-->
	<script src ="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	

	<!--date picker-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>                            
<body>
	<div id ='sqlLog'>
		<?php
		print_r($_SESSION['column']);
		print_r($_SESSION['order']);
		print_r($_SESSION['displayName']);
		?>
	</div>

	<header>

	<h2>STANDARD JOBS PROGRESS LIST</h2>
	

	<div class= 'infoDiv'>

		<table id='info'>
			<tr>
				<th class = 'key ccr'>CCR</th>
				<th class= 'infoTable'></th>
			
			</tr>
			<tr>
				<th class = 'key urgent'>Urgent</th>
				<th class= 'infoTable'></th>

			</tr>
			<tr>
				<th class = 'key bfi'>BFI Del / On Order</th>
				<th class= 'infoTable'></th>
				

			</tr>
			<tr>
				<th class = 'key testbay'>Test Bay</th>
				<th class= 'infoTable'></th>

			</tr>
			<tr>
				<th class = 'key pmi'>PMI</th>
				<th class = 'infoTable DPT'></th>

			</tr>
			<tr>
				<th class = 'key late'>Late</th>
				<th class = 'infoTable DPT'></th>
			
			</tr>
			
			</table>
		
			
			</div>
	
	<br>

	<!-- Table containing the Key for the different highlights -->

		</header>	

		<!-- sticky div containing page navigation buttons + D/P Key
		<div class='pageControlsDiv'>
			
				<p id='DPKey'>Y = YES<br>N = NO</p>
				<button id='lastPage' class='pageControls' type='button' onclick='changePage("lastP")'>Last Page</button>

				<select id='pp' class='pageControls'  onchange='changePage("three",value)'>
					
			</select> 

				<button id='nextPage' class='pageControls' type='button' onclick='changePage("nextP")'>Next Page</button>

				<button id='curFilter' type='button' onclick='clearFilter()'>&#9747; <?php print_r($_SESSION['displayName'])?></button>

				<button id='logout' type = 'button' onclick='logout()'>Logout</button>	
			</div>-->
		
			<!--div contains erorr message if data is ever entered incorrectly -->
		<div class = "alert" id='err'>
			<h3><span class = "exitbtn" onclick='closeAlert()'>&times;</span>
			Error Saving Changes , Please Try Again</h3>
		<script>
			function closeAlert(){
				document.querySelector('.alert').style.display='none';
			  	document.querySelector('.stick1').style.top='68px';
			
			}
		</script>
		</div>

	<!-- Table Headings with the Filters dropdown in a div at the end of each line* -->
	<!-- *Except for Proc Desc as it dosent need one -->
	 <div class = 'nav'>
	 <table id= 'tagTable'>
	 <thead class='stick2'>
			<tr id='headTags'>
				<th class=tags></th>
				<th class=tags></th>

				<th class=tags></th>
				<th class=tags></th>
				<th class=tags></th>
			
				<th class='tags'><button id='lastPage' class='pageControls' type='button' onclick='changePage("lastP")'>Last Page</button>
				</th>
				<th class='tags'><select id='pageList' class='pageControls'  onchange='changePage("three",value)'>
					
					</select></th>
				<th class='tags'><button id='nextPage' class='pageControls' type='button' onclick='changePage("nextP")'>Next Page</button></th>
				<th class=tags ><button id='curFilter' type='button' onclick='clearFilter()'>&#9747; <?php print_r($_SESSION['displayName'])?></button></th>
				<th class=tags></th>
				<th class=tags></th>
				<th class=tags></th>
				<th class=tags></th>
				<th class=tags><button id='logout' type = 'button' onclick='logout()'>Logout</button>	</th>
			</tr>
		</table>
		</div>
	<table id="SJ_table">
		<thead class='stick1'>
			
			<tr class='head'>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("numbers","09","Job_No","Oldest Job First")'>Smallest to Largest</a><a onclick='newFilters("numbers","90","Job_No","Newest Job First")'>Largest to Smallest</a></div></div>Job/CCR No</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("numbers","09","Card_Qty","Card Qty Smallest First")'>Smallest to Largest</a><a onclick='newFilters("numbers","90","Card_Qty","Card Qty Largest First")'>Largest to Smallest</a></div></div>Card Qty</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("date","09","Date_Created","Date Created Oldest First")'>Oldest to Newest</a><a onclick='newFilters("date","90","Date_Created","Date Created Newest First")'>Newest to Oldest</a></div></div>Date Created</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("date","09","Date_Issued","Date Issued Oldest First")'>Oldest to Newest</a><a onclick='newFilters("date","90","Date_Issued","Date Issued Newest First")'>Newest to Oldest</a></div></div>Date Issued</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("alphabet","AZ","Del_Sch","Del Schedule A-Z")' >A to Z</a><a onclick='newFilters("alphabet","ZA","Del_Sch","Del Schedule Z-A")'>Z to A</a></div></div>Del Sch</th>
				<th class ='heading'><div class="caption">Y=YES N=NO</div><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("alphabet","AZ","DP_Tappings","Tappings A-Z")'>A to Z</a><a onclick='newFilters("alphabet","ZA","DP_Tappings","Tappings Z-A")'>Z to A</a></div></div>D/P Tappings</th>
				<th class ='heading'>Process Description</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("date","09","Del_Date","Del Date Oldest First")'>Oldest to Newest</a><a onclick='newFilters("date","90","Del_Date","Del Date Newest First")'>Newest to Oldest</a></div></div>Delivery Date</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("date","09","Recieved_From_Stores","RtF Oldest First")'>Oldest to Newest</a><a onclick='newFilters("date","90","Recieved_From_Stores","RtF Newest First")'>Newest to Oldest</a></div></div>Date Recieved from Stores</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("date","09","Sent_to_Fab","StF Oldest First")'>Oldest to Newest</a><a onclick='newFilters("date","90","Sent_to_Fab","StF Newest First")'>Newest to Oldest</a></div></div>Sent to Fab</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("date","09","Date_Packed","DP Oldest First")'>Oldest to Newest</a><a onclick='newFilters("date","90","Date_Packed","DP Newest First")'>Newest to Oldest</a></div></div>Date Packed</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("bool","No","Packed","Packed")'>Packed</a><a onclick='newFilters("bool","Yes","Packed","Not Packed")'>Not Packed</a></div></div>Packed ?</th>
				<th class ='heading'><div class ='th-dropdown'><button class='th-dropbtn th-hidden' type='button' onclick='viewsDropdown()'>V</button><div class='th-dropdown-content th-dropdownList'><a onclick='newFilters("bool","No","Late","Late")'>Late</a><a onclick='newFilters("bool","Yes","Late","On Time")'>On Time</a></div></div>Late ?</th>
				<th class ='heading'>Missing BFI/On Order Del Date</th>
				<th class ='heading'>Comments</th>
			</tr>
		</thead>
		<tbody id='ins_into'>
	</tbody>
	<!-- table body is filled out by printList() -->
	</table>
		
	<script>
		
		printList(0);

		//Gets information from the Jobs Data Table
		//The checks are for different serches and page controlls the portion of data retrieved 
		function printList(check,page){
			const xhttp = new XMLHttpRequest();
			const formData = new FormData();

			//check=1 checks for changes & only replaces data if true , called by setInterval() to run every 10seconds (unless i changed it)
			if (check==1){
				formData.append('checking',1);
				
			}

			//0 returns data without checking for changes 
			else if (check==0){
				formData.append('checking',0);
			}

			//3 replaces list with contents of the previous page
			else if (check == 3){
				formData.append('checking',3);
			}
			//4 is the same as 3 but for the next page instead
			else if (check == 4){
				formData.append('checking',4);
			}
			//5 jumps to the page selected in the dropdown 
			else if (check == 5){
				console.log(page);
				console.log(check);
				formData.append('checking',5);
				formData.append('page',page);
			}
			
			xhttp.onload= function(){
				let tBody=document.getElementById('ins_into');
				
				if(this.responseText=="2"){
					//result of check 0 if table is the same, skips the SQL and returns '2'
					console.log("tables were the same");
				}

				else{
					let editing=document.querySelectorAll('.inEdit');
					//checks table isnt being editied before refreshing
					if (editing.length){
						console.log("Table currently being Edited");
					}
					else{
						console.log("Inactive, Will Refresh ")
					
						tBody.innerHTML=this.responseText;
						//after reload, Event listeners need to be readded 
						addEL();
						//to lock cells
						ReadOnly();

						///saved filter settings???
						
						newFilters(globalView, lastDir, lastCol, lastDisplayName);
						
						cellFormating();
						
						console.log("table updated");
						//const textareas = document.querySelectorAll('.longTxt');
						//textareas.forEach(textarea => resizeTxtArea(textarea));
					}	
				}
			}
			xhttp.open("POST","getList.php",true);	
			xhttp.send(formData);	
		}
		
		//calls printlist(1) function every 10 seconds
		const intervalID = setInterval(() => printList(1),10000)
		
		</script>
	<!--set elements with class 'datePkr' as datepicker widgets
 			*When a txt box is clicked on it opens a datepicker-->
	<script>

	//creates datepickers on text inputs of the class datePkr
	//altField: is an attribute that has the datepicker alter a different input field 
			//useful for having the actual datepickers show in the desired format while still being accepted by tghe database
	let newDate;
		$(document).on("focus",".datePkr", function(){
			$(this).datepicker({dateFormat: "dd/mm/yy", altField:"#actualDate", altFormat:"yy-mm-dd"}).on('change',function(){
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
		removeLocks();
	});

	//changes default action for textareas when 'Enter' is pressed, will lose focus instead of line break
	document.getElementById('SJ_table').addEventListener('keydown', function(event){

		if (event.key == 'Enter') {
			let target = event.target;
			if (target.tagName === 'TEXTAREA') {
				event.preventDefault();
				target.blur();
			}
		}
	});
	let row;
	let column;
	
	//adds the event listeners to each table element 
	function addEL(){
		let tds= document.querySelectorAll('.editMe, .date, .edite');
		
		//this EL gets the row and column to be used when the data is submitted to DB
		tds.forEach(td => {
			td.addEventListener('mousedown', function() {
				//delay of 0ms so that focus out event fires first 
				setTimeout(()=> {

				const tr = this.parentNode;

				row = this.parentNode.id;

				column = [...tr.children].indexOf(this);
				
				//let focused=document.getElementById(row);
				//focused.classList.add('inEdit');
				
				//txtarea is childNode[1] in comments column
				console.log(this.classList);
				if (this.classList.contains('comments')){

					resizeTxtArea(this.childNodes[1]);
				}
				resizeTxtArea(this.childNodes[0]);
				
				
				
				//console.log debugging  
				console.log('and this',this.parentNode.id);
				console.log("Row: ", row, "Column: ", column, "td:",this,"tr:",tr);
				
				return row;
				return column;
				},0);
			});
		});
		

		//This EL calls lockRow() function & edits classlist for row when clicked
		let inputs = document.querySelectorAll('.datePkr, .longTxt, .editMe');
		inputs.forEach(input => {
			input.addEventListener('click',function(){
				setTimeout(() => {

					let focused=document.getElementById(row);
					
					//console.log(focused);
					
					//inEdit in the class list means that the page won't refresh until row is click out of  
					focused.classList.add('inEdit');
					lockRow(1);//locks in DB row so only current user can edit
					
				},0);
			})
		})

		
	}
	//ELs for headings only need to be done once 
	function thELs(){
		//gets clicks in table headings to activate the dropdown menu
		let ths = document.querySelectorAll('.heading');

		ths.forEach(th => {
			th.addEventListener('mousedown', function() {
				setTimeout(()=> {
					const tr = this.parentNode;

					column= [...tr.children].indexOf(this);

					console.log("th Column: ",column,"td:",this,"tr:",tr);
					
					return column;
				},0)
				
			});
		});
	}
	
	addEL();
	thELs();

	//document.getElementById('SJ_table').addEventListener('focusout', function(event){
	//	const clickedElement=event.target;
	//	console.log("EV Target"+clickedElement);
	//});

	//submits data in textarea to DB on focusout
	$(document).on("focusout", ".longTxt", function(){
			let input = this.value;
			submit(row,column,input);
		
		})

	
	$(document).on("focusout", ".inEdit", function(){
		let focused=document.getElementById(row);
		focused.classList.remove('inEdit');  //removes edit lock so that list can refresh
		lockRow(0);//unlock row so other users can edit
	})

	</script>
	<br>
	<!-- button to add new rows to the table-->
	<form id='submit' method="post" action="">
	
		<button id='newRow'type='button' onclick='addNewRow()'>+ Add New Row</button>

	</form>
	<!-- hidden input that contains the last date picked in yyyy-mm-dd format -->
	<input type="text" id="actualDate">

	<script>
	

	
	let tableLength=<?php print_r($_SESSION['tableLength']);?>;
	let currentPage=<?php print_r($_SESSION['page']);?>;

	let pageDropdown = document.getElementById("pageList");

	//divides the table lenght by 50 to create the right amount of 50-item-long pages in the <select>
	let pNum = Math.ceil(tableLength / 50) ;
	console.log(pNum);
	let thisPage = 1;
	
	while (thisPage <= pNum){
		

		//sets the currently shwon page as selected so that it us shown first on a reload
		if (thisPage == currentPage){
			pageDropdown.insertAdjacentHTML('beforeend',"<option value ='"+thisPage+"' selected>"+ thisPage,"</option>");
			
		}
		else{
			pageDropdown.insertAdjacentHTML('beforeend',"<option value ='"+thisPage+"'>"+ thisPage,"</option>");
		}
			
		thisPage+=1;
	}


	//Called when dates are changed to submit to DB
	function submitDate(){


		//submits changed value to database if all 3 parameters are correct/not null
		if(row && column && newDate){
			console.log(row, column, newDate);
			submit(row,column,newDate);
		}

		else{console.log("Data Not Sent: ",row, column, newDate);}

		//gets date of both text boxes
		let datePacked=(document.getElementById('dPackedNo'+row)).value;
		let delDate=(document.getElementById('delDateNo'+row)).value;

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

				let oldValue=(document.getElementById('lateNo'+row)).innerText;
				let dpYear = datePacked.substring(6); //year 
				let dpMonth = datePacked.substring(3,5); //month
				let dpDay = datePacked.substring(0,2); //day

				let ddYear = delDate.substring(6);
				let ddMonth = delDate.substring(3,5);
				let ddDay = delDate.substring(0,2);

				let container=document.getElementById('lateNo'+row); // Late column

				if (dpYear == ddYear){  //checks year first , then does more specific comparisions if ==

					if (dpMonth == ddMonth){ 

						if (dpDay <= ddDay){
							
							container.innerHTML="NO";
							submit(row,12,"NO");
							return;
						}
						else{
						
							container.innerHTML="YES";
							submit(row,12,"YES");
							return;
						}
	
					}
					if (dpMonth < ddMonth){

						
						container.innerHTML="NO";
						submit(row,12,"NO");
						return;

					}
					else{
						
						container.innerHTML="YES";
						submit(row,12,"YES");
						return;
					}

				}
				else if(dpYear < ddYear){
			
					container.innerHTML="NO";
					submit(row,12,"NO");
					return;
				}
				else{
					container.innerHTML="YES";
					submit(row,12,"YES");
					return;
				}
			}
		}
	}


	//default filter settings
	let globalView='All';
	let lastDir="<?php print_r($_SESSION['order'])?>";// defined from getList.php
	let lastCol="<?php print_r($_SESSION['column'])?>";//
	let lastDisplayName="<?php print_r($_SESSION['displayName'])?>";//
	
	function newFilters(view , direction , colName, displayName){
		//updates variables with new values from function call 
		globalView= view;
		lastDir = direction;
        lastCol = colName;
		lastDisplayName = displayName;
		console.log("saved settings: ",globalView," ",direction," ",colName);

		let table = document.getElementById("SJ_table");

		let filterDiv = document.getElementById("curFilter");
		console.log(filterDiv.innerHTML);

		filterDiv.innerHTML = 'X '+ displayName;



		const xhttp = new XMLHttpRequest();

		//Packed == YES
		if (view == "bool"){
			if(direction =='Yes'){
				order = "ASC";
			}
			else{
				order = "DESC";
			}
			
			
			//updates header with current filter
			

			const formData = new FormData();

			formData.append('checking',6);
			formData.append('col',colName);
			formData.append('order', order);
			formData.append('type','bool');
			formData.append('displayName',displayName);

			xhttp.onload = function(){
				let tBody =document.getElementById('ins_into');
				tBody.innerHTML=this.responseText;
				addEL();
				cellFormating();

				//const textareas = document.querySelectorAll('.longTxt');
				//textareas.forEach(textarea => resizeTxtArea(textarea));
			}
			xhttp.open("POST","getList.php");
			xhttp.send(formData);

		}

		if (view =="alphabet"){
			
			
			
			if (direction == "AZ"){
				 order = "ASC";
			}
			else{
				 order = "DESC";
			}
			
			const formData = new FormData();

			formData.append('checking',6);
			formData.append('col',colName);
			formData.append('order', order);
			formData.append('type','string');
			formData.append('displayName',displayName);

			xhttp.onload = function(){
				let tBody =document.getElementById('ins_into');
				tBody.innerHTML=this.responseText;
				addEL();
				cellFormating();

				//const textareas = document.querySelectorAll('.longTxt');
				//textareas.forEach(textarea => resizeTxtArea(textarea));
			}
			xhttp.open("POST","getList.php");
			xhttp.send(formData);
		}


		
		if (view =="numbers" || view =='date'){
			const xhttp = new XMLHttpRequest();
			if (direction == "09"){
				order = "ASC";
			}
			else{
				order = "DESC";
			}
			const formData = new FormData();
			formData.append('checking',6);
			formData.append('col' , colName);
			formData.append('order',order);
			formData.append('type','integer');
			formData.append('displayName',displayName);

			xhttp.onload = function(){
				let tBody =document.getElementById('ins_into');
				tBody.innerHTML=this.responseText;
				addEL();
				cellFormating();

				//const textareas = document.querySelectorAll('.longTxt');
					//textareas.forEach(textarea => resizeTxtArea(textarea));
			}
			xhttp.open("POST","getList.php");
			xhttp.send(formData);
		}

	}
		
	
	function addNewRow(){
		//console.log(inputValues);
		const xhttp = new XMLHttpRequest();
		
	   	xhttp.onload = function(){
			//finds table body by its id and adds the new row to the end of it
			let tBody = document.getElementById('ins_into');
		  	tBody.insertAdjacentHTML('beforeend', this.responseText);

			addEL();

			return;
		}

      	xhttp.open("POST","addRow.php");
      	xhttp.send();

	}

	let buttonElement = document.getElementById("newRow");
	//assigns addNewRow function to the button 
	buttonElement.onclick = addNewRow;

	function errorMessage(){
		document.querySelector('.alert').style.display='block';
		document.querySelector('.stick1').style.top='108px';
		
	}

	//function to submit changed data to the DB , different parameters used based on the data's format
	function submit(row, column,newValue){
		console.log("row:"+row+" column:"+column+" NewVal:"+newValue);
		let report;
		//declares report
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

		xhttp.open("POST", "sendData.php");
		xhttp.send(formData);

		}
	//can use to expand all rows when page loads but slows down performance significantly
	function resizeTxtArea(textarea) {

	  textarea.style.height = 'auto'; // Reset height to auto to calculate new height
	  textarea.style.height = textarea.scrollHeight + 'px'; // Set height to scrollHeight (content height)
	}

	function logout(){ //ends session and kicks user back to the login screen
		const xhttp = new XMLHttpRequest();
		xhttp.open("POST","endSession.php",true);
		xhttp.send();
		xhttp.onload = function(){
			location.reload();
		}
		
	}


	function lockRow(toggle){ //toggles editLock column in table
		curRow=document.getElementById(row);
		
		//console.log('THISONE',curRow.classList[0]);

		if (curRow.classList[0]=='Locked'){
			console.log("Cannot Edit, Locked by USER");
		}
		else{

			const xhttp = new XMLHttpRequest();
			const formData = new FormData();

			formData.append('id',row);

			if (toggle ==0){
				formData.append('lock',0);
			}
			else{
				formData.append('lock',1);}

			xhttp.onload =  function(){
				console.log("in lockRow",row);
				console.log(this.responseText);
			}
			xhttp.open("POST","lock.php");
			xhttp.send(formData);
		}
	}
	
	
	function ReadOnly(){//changes class of locked rows so that they cannot be edited

		document.querySelectorAll('.Locked').forEach((row)=>{
			row.querySelectorAll('textarea').forEach((textarea)=>{
				textarea.setAttribute('readonly',true);
				textarea.classList.add('noEdit');
				
			})

			row.querySelectorAll('.datePkr').forEach((dpkr)=>{
				dpkr.classList.remove('datePkr');
				dpkr.classList.add('datePkrLocked');
				dpkr.setAttribute('readOnly',true);
				
			})

		})
	}
	function dropdown(){//displays dropdown list when button is clicked
	
		let thisRow = document.getElementById(row);
		let thisDropdown= (thisRow.childNodes[14].childNodes[0].childNodes[1]);
		thisDropdown.classList.toggle("show");

		let hlOption = thisDropdown.childNodes[1];
		
		//hlOption.onclick = testFunction
		//console.log(hlOption.onclick);

		//hyperlink button & function == remove when true(hyperlink preset) else button == add
		if (document.getElementById("linkR"+row).innerHTML){
			hlOption.innerHTML = 'Remove HyperLink';
			hlOption.onclick = removeHyperlink;
		}
		else{hlOption.innerHTML = 'Add HyperLink';
			hlOption.onclick = addHyperLink
		}
	}

	function viewsDropdown(){
		let dropdowns = document.getElementsByClassName('th-dropdown-content');
		console.log(dropdowns[column]);
		if (column > 6 ){
			dropdowns[column-1].classList.toggle("show");
		}
		else{dropdowns[column].classList.toggle("show");}
		
		console.log("the column is ",column);
		console.log(dropdowns[column]);
	}
	window.onclick = function(event) {//closes dropdown when clicking anywhere else in the window
  		if (!event.target.matches('.dropbtn , .subcontent , .dropdown-subcontent')) {
    	let dropdowns = document.getElementsByClassName("dropdown-content");
    	let i;
    	for (i = 0; i < dropdowns.length; i++) {
      	let openDropdown = dropdowns[i];
      	if (openDropdown.classList.contains('show')) {
        	openDropdown.classList.remove('show');
      		}
    	}
  		}
		if (!event.target.matches('.th-dropbtn')) {//same for th dropdowns
    	let thDropdowns = document.getElementsByClassName("th-dropdown-content");
    	let i;
    	for (i = 0; i < thDropdowns.length; i++) {
      	let openThDropdown = thDropdowns[i];
      	if (openThDropdown.classList.contains('show')) {
        	openThDropdown.classList.remove('show');
      		}
    	}
  		}
		if (!event.target.matches('.th-dropbtn')) {//same for th dropdowns
    	let thDropdowns = document.getElementsByClassName("th-dropdown-content");
    	let i;
    	for (i = 0; i < thDropdowns.length; i++) {
      	let openThDropdown = thDropdowns[i];
      	if (openThDropdown.classList.contains('show')) {
        	openThDropdown.classList.remove('show');
      		}
    	}
  		}

		if (!event.target.matches('.th-dropbtn')) {//same for th dropdowns
    		let thDropdowns = document.getElementsByClassName("dropdown-subcontent");
    		let i;
    		for (i = 0; i < thDropdowns.length; i++) {
      			let openThDropdown = thDropdowns[i];
      			if (openThDropdown.classList.contains('show')) {
        			openThDropdown.classList.remove('show');
      			}
    		}
  		}
		
	}
	
	window.onmouseover = function(event) { 
	
		if (event.target.matches('.subcontent')) { 
			console.log(event.target);
			let thisRow = document.getElementById(row);
			console.log(thisRow);
			let thisDropdown= (thisRow.childNodes[14].childNodes[0].childNodes[2])
			let thisDropdown2= (thisRow.childNodes[14].childNodes[0].childNodes[1])
			console.log(thisDropdown2);
			let i;

        	thisDropdown.classList.add('show');
			thisDropdown.classList.remove('hide');

	

			thisDropdown.onmouseleave = function(){

				thisDropdown.classList.remove('show');
				thisDropdown.classList.add('hide');
    		}	
			thisDropdown.onclick = function(){
				thisDropdown.classList.remove('show');
				thisDropdown.classList.add('hide');
			}

			thisDropdown.childNodes[0].onmouseover = function() {
				thisRow.childNodes[0].classList.add('ccrP');
				console.log(thisRow.childNodes[0].classList)
			}
			thisDropdown.childNodes[0].onmouseleave = function(){
				thisRow.childNodes[0].classList.remove('ccrP');
			}


			thisDropdown.childNodes[1].onmouseover = function() {
				thisRow.childNodes[0].classList.add('urgentP');
				console.log(thisRow.childNodes[0].classList)
			}

			thisDropdown.childNodes[1].onmouseleave = function(){
				thisRow.childNodes[0].classList.remove('urgentP');
			}

			thisDropdown.childNodes[2].onmouseover = function() {
				thisRow.childNodes[0].classList.add('bfiP');
				console.log(thisRow.childNodes[0].classList)
			}

			thisDropdown.childNodes[2].onmouseleave = function(){
				thisRow.childNodes[0].classList.remove('bfiP');
			}

			thisDropdown.childNodes[3].onmouseover = function() {
				thisRow.childNodes[0].classList.add('testbayP');
				console.log(thisRow.childNodes[0].classList)
			}

			thisDropdown.childNodes[3].onmouseleave = function(){
				thisRow.childNodes[0].classList.remove('testbayP');
			}

			thisDropdown.childNodes[4].onmouseover = function() {
				thisRow.childNodes[0].classList.add('pmiP');
				console.log(thisRow.childNodes[0].classList)
			}

			thisDropdown.childNodes[4].onmouseleave = function(){
				thisRow.childNodes[0].classList.remove('pmiP');
			}

			thisDropdown.childNodes[5].onmouseover = function() {
				thisRow.childNodes[0].classList.add('lateP');
				console.log(thisRow.childNodes[0].classList)
			}

			thisDropdown.childNodes[5].onmouseleave = function(){
				thisRow.childNodes[0].classList.remove('lateP');
			}
		}	
	}

	

	function strikeThrough(){//
	
		let tr= document.getElementById(row);
		
		
		tr.querySelectorAll('.longTxt, .datePkr ,.noEdit').forEach((txt)=>{
			txt.classList.toggle("strike");
		})

		const xhttp = new XMLHttpRequest();

		const formData = new FormData();
		
		formData.append('id',row);
		xhttp.onload = function(){
			console.log(this.responseText);
		}

		
		
		xhttp.open("POST", "saveStrike.php");
		xhttp.send(formData);
		
	}

	function cellFormating(){
		let table = document.getElementById('SJ_table');
		console.log(table); 

		let iterator=0;
			while (iterator < table.tBodies[0].rows.length){
				
				//if jobNo classlist contains none? skip ;
				//Missing BFI not null == Blue
				let mBFI= document.getElementsByClassName('missingBFI');
				let jobNo = document.getElementsByClassName('jobNo');
				let mBFIData =(mBFI[iterator].childNodes[0].innerHTML);

				if(jobNo[iterator].classList.contains('X')){

					console.log('Skip, Manual')
				}
				else{
					
				
					if (mBFIData != ""){
						jobNo[iterator].classList.add('bfi');
					}

					//CCR
				
					if (jobNo[iterator].childNodes[1].innerHTML <10000){
						console.log(jobNo[iterator].childNodes[1].innerHTML);
						jobNo[iterator].classList.add('ccr');
					
					}
				

					//Urgent == if Delivery date < 1week from date created
					let dCList= document.getElementsByClassName('DC');
					let dDList = document.getElementsByClassName('DD');

		
				

					let dateCreated = dCList[iterator].childNodes[0].value;
					let deliveryDate = dDList[iterator].childNodes[0].value;
				
			
					const dcDate = new Date(dateCreated.substring(6),dateCreated.substring(3,5)-1,dateCreated.substring(0,2));
					const ddDate = new Date(deliveryDate.substring(6),deliveryDate.substring(3,5)-1,deliveryDate.substring(0,2));
					//console.log(dcDate.getTime());
					//console.log(ddDate.getTime());

					//console.log(ddDate.getTime() - dcDate.getTime())

					if (ddDate.getTime() - dcDate.getTime() < 604800000 && ddDate.getTime() - dcDate.getTime() > 0){
						//console.log("dates within a week!, URGENT");
						jobNo[iterator].classList.add('urgent');
					
					}
					else{//console.log("Not Urgent");
						}

					if (iterator >=0){
						let lateList = document.querySelectorAll('[id^=lateNo]');
						
					if (lateList[iterator].innerHTML == "YES" || jobNo[iterator].classList.contains('late')){
						console.log('its late');
						//console.log(lateList.innerHTML);
						let thisRow = document.getElementById(iterator);
					
						lateList[iterator].parentElement.classList.add('late');
						//console.log(thisRow.childNodes);
						
					}

					}
					//string search for Test bay and PMI
					let proDescs = document.getElementsByClassName('processDesc');
					let thisProDesc = proDescs[iterator].childNodes[0].innerHTML;
					if (thisProDesc.toLowerCase().includes("test bay")){
						jobNo[iterator].classList.add('testbay');
					}
					else if(thisProDesc.toLowerCase().includes("pmi")){
						jobNo[iterator].classList.add('pmi');
					}
				}
				
				iterator = iterator +1;
			}
	}

	function addHyperLink(){
		

		let thisLink = document.getElementById("linkR"+row);
		
		console.log(thisLink);
	
		
		let newLinkName = prompt("Enter a Name: ","");
		thisLink.innerHTML = newLinkName;
		
		if (newLinkName){
			console.log("ITS TRUE");
		}
		console.log(thisLink.innerHTML)
		let newLink =  prompt("Enter the Link: ");

		thisLink.href = newLink;
		
		
		saveHyperlink(newLink,row,newLinkName);

	}

	function saveHyperlink(link,id,linkName){
		console.log(link);

		const xhttp = new XMLHttpRequest();

		const formData =  new FormData();

		formData.append("link",link);
		formData.append("id",id);
		formData.append("linkName",linkName);

		xhttp.open("POST","saveHyperlink.php");
		xhttp.send(formData);

	}

	function removeHyperlink(){
		let thisLink = document.getElementById("linkR"+row);
		thisLink.innerHTML="";
		saveHyperlink("",row,"");
	}
		thisPage = currentPage;

	function changePage(dir,value){

		let selection = document.getElementById("pageList")
		
		
		if (dir =="nextP"){

			if (thisPage >= pNum){
				
				return
			}
			console.log(thisPage);
		
			//selection[thisPage-1].removeAttribute('selected');
			console.log(thisPage+1);
			selection[thisPage].selected ='selected';

			console.log(selection);
			thisPage +=1;
			printList(4);
		}
		else if (dir =="lastP"){
			console.log(thisPage);
			if(thisPage == 1){
				return
			}
			console.log(selection[thisPage]);

			selection[thisPage-1].removeAttribute('selected');
			
			console.log(thisPage)

			thisPage -=1;

			selection[thisPage-1].selected ='selected';

			console.log(selection[thisPage]);
			
		
			printList(3);
		}
		else{

			selection[thisPage-1].removeAttribute('selected');

			selection[value-1].selected ='selected';

			console.log(parseInt(value));

			thisPage = parseInt(value);
			printList(5,value);
		}

	}
	function removeLocks(){
		
		const xhttp = new XMLHttpRequest();

		xhttp.open("POST","clearLocks.php",true);
		xhttp.send();
	}
	function clearFilter(){
		newFilters("numbers","90","Job_No","Newest Job First");
	}
	function addTag(tagName){
		
		const xhttp = new XMLHttpRequest();

		const formData = new FormData();

		formData.append('tag',tagName);
		formData.append('row',row);
		
		let thisRow = document.getElementById(row);
		console.log(thisRow.childNodes[0].classList[2]);
		 xhttp.onload = function() {

			tagName ? thisRow.childNodes[0].classList.add(tagName) : thisRow.childNodes[0].classList.remove(thisRow.childNodes[0].classList[2]);
		
		}

		xhttp.open("POST","addTag.php",true);
		xhttp.send(formData);
	}
	</script>
</body>
