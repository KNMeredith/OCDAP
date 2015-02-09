<html>
	<head>
		<script src="error.js"> </script>
		<title> Web Data Grab Thingy </title>
		<script>
			var bigString = ""; //holds String version of generated letters
			var bigArray = []; //holds randomly generated characters; find subString in here
			var bigLength = 0; //how long bigArray is
			
			<?php
				//uses geneID to get FASTA file web page text for desired organism
				$rawContent = file_get_contents("http://www.ncbi.nlm.nih.gov/sviewer/viewer.fcgi?tool=portal&sendto=on&log$=seqview&db=nuccore&dopt=fasta&val=".$geneID."&extrafeat=0&maxplex=1");
					
				//selects "complete cds" and sequence from the data and stores it as a string
				$rawSequence = stristr( $rawContent, "complete cds" );
				$rawArray = explode("\n", $rawSequence);
				//echo "bigArray = \"".$rawSequence."\";\n";
				$i=0;
				foreach ($rawArray as $line)
				{
					if ($i>0)
					{echo "bigString += \"".$line."\";\n";}
					
					$i++;
				}
			?>
			
			function showSequence()
			{
				document.writeln(bigString);
				
				/*
				bigArray = bigString.split("");
				bigLength = bigArray.length;
				
				for (w=0; w<bigLength; w++)
				{
					document.write(bigArray[w]);
				}
				
				document.writeln("<br /><br />");
				document.writeln("showSequence got called and did its thing");
				*/
			}
		</script>
	</head>
	
	<body>
		<script>
			showSequence();
		</script>
	</body>
</html>