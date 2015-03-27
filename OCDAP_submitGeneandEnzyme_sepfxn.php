<?php
	include("enzyme_table.php");
?>

<html>
	<head>
		<script src="error.js"> </script>
		<title> OCDAP: Gene and Enzyme Form </title>
	</head>
	
	<body>
		<h2> OCDAP: Gene and Enzyme Form </h2>
		<form action="substringsearch_grab_separatedfxns.php" method="POST">
			Gene ID: <input name='geneID'  /> e.g. 24182471 <br /> 
			Restriction Enzyme: 
			<?php
				enzymeMenu();
			?>
			<br />
			<input type="submit" value="Submit"> <br> 
		</form>
	</body>
</html>