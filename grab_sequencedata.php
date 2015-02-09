<?php
	//for now, you need to already know gene ID #
	//prompt to type gene ID # in -> puts in preset url code to get file data
	//stores relevant sequence as string
				
	function getData()
	{			
		//uses geneID to get FASTA file web page text for desired organism
		$rawContent = file_get_contents("http://www.ncbi.nlm.nih.gov/sviewer/viewer.fcgi?tool=portal&sendto=on&log$=seqview&db=nuccore&dopt=fasta&val=24182471&extrafeat=0&maxplex=1");
					
		//selects only the sequence from the data and stores it as a string
		$rawSequence = stristr( $rawContent, "complete cds" );
					
		echo "bigString = \"".$rawSequence."\";\n";
	}
?>