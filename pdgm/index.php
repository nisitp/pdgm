<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PDGM TOOL</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="/styles/tabulator.min.css">
<link rel="stylesheet" href="/styles/style.css">
<script type="text/javascript" src="/scripts/tabulator.min.js"></script>
<script src="/scripts/script.js"></script>
</head>
<body>
	<div class="form-wrapper">
		<form action = "#" method = "post" id="pdgm-search-form">  
			<p> 
				<label for = "npi">NPI: </label> 
				<input type = "text" id = "npi"><br /> 
	   
				<label for = "name">Name: </label> 
				<input type = "text" id = "name"><br /> 
	   
				<input type = "submit" value = "send">
	   		</p> 
		</form> 
	</div>
	<div class="pdgm-data-wrapper">
		<div class="npi-wrapper">
			<h3>NPI:</h3>
			<p class="npi-val"></p>
		</div>
		<div class="agency-data-wrapper">
			<h3>Agency Name:</h3>
			<p class="agency-name"></p>
			<h3>Agency State:</h3>
			<p class="agency-state"></p>
		</div>
		<div class="totpmts-wrapper">
			<h3>Total Payments:</h3>
			<p class="totpmts-data"></p>
		</div>
		<div class="primary-table-wrapper">
			<h3>Summary Table</h3>
			<div id="primary-table"></div>
		</div>
		<div class="secondary-table-wrapper">
			<h3>Detail Table</h3>
			<div id="secondary-table"></div>
		</div>
	</div>
</body>
</html>
