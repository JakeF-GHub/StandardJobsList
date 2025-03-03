<!DOCTYPE html>
<head>
	<link rel="stylesheet" type="text/css" href="/styles.css">
</head>
<body>
<h2> Get Job</h2>
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
      document.getElementById("txtHint").innerHTML = "";
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
</body>
</html>
