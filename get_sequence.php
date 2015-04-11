<?php
	//for now, you need to already know gene ID #
	//prompt to type gene ID # in -> puts in preset url code to get file data from NCBI
	//stores relevant sequence from NCBI as string (bigString)
	//converts that string to array (bigArray)
	//sets bigLength
	function getSequence($geneID)
	{
		//need to have global in front so it knows these variable refer to previously defined ones in earlier php
		global $rawLength;
		
		//uses geneID to get FASTA file web page text for desired organism/gene
		$rawContent = file_get_contents("http://www.ncbi.nlm.nih.gov/sviewer/viewer.fcgi?tool=portal&sendto=on&log$=seqview&db=nuccore&dopt=fasta&val=".$geneID."&extrafeat=0&maxplex=1");
		
		//selects "complete cds" and sequence from the data -> stores it as a string
		$rawSequence = stristr( $rawContent, "complete cds" );
		
		//separates $rawSequence into an array of characters by lines ($rawArray)
		$rawArray = explode("\n", $rawSequence);
		
		$i=0;  //local php variable to count through lines in sequence
		$rawLength=0; //local php variable to store total length of $rawArray
		
		//each entry in $rawArray stored as $line at every iteration ($line will be set to next character in array every iteration)
		foreach ($rawArray as $line)
		{
			//sets javascript variable bigString to the character $line is currently assigned to
			if ($i>0)
			{echo "bigString += \"".$line."\";\n";} //update javascript value of bigString
			
			//increase the counter
			$i++;
			
			$rawLength += strlen($line); //updates $rawLength's value after every iteration
		}
		
		//converts bigString to array of characters (bigArray)
		//sets javascript variables bigLength to length of bigArray
		echo "bigArray = bigString.split(\"\");";
		echo "bigLength = bigArray.length;";
	}
?>