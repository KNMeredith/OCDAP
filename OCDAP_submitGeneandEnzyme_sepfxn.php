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
		<p> Gene ID's are obtained from the GenBank or FASTA files for DNA sequences located at <a href="http://www.ncbi.nlm.nih.gov/">NCBI</a>.
			<br /> <br />
			Suggested NCBI search method: 
			<ol>
			<li>From the NCBI home page, select "Nucleotide" from the drop-down menu to the left of the search bar (near
				the top of the page).</li>
			<li>Type the desired gene into the search bar.</li>
			<li>Press the "Search" button to the right of the search bar.</li>
			<li>Once you have found the desired gene entry, click on its hyperlink. If your entry was very specific, it may automatically bring you
				to its GenBank page.</li>
			<li>In the "Version" section (the fourth category down the page), it should display "GI:#," where # is the gene ID for your desired gene.
				Copy and paste this number into the Gene ID entry box below.</li>
			</ol>
		</p>
		<br />
		<form action="substringsearch_grab_separatedfxns.php" method="POST" >
			Gene ID: <input name='geneID'  /> e.g. 24182471 <br /> 
				
			<!--options come before because can't send value otherwise-->
			Restriction Enzyme: 
				<?php
					enzymeMenu();
				?>
			<br />
			
			<input type="submit" value="Submit"> <br> 
		</form>
	</body>
</html>