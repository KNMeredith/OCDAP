<?php
	//finds positions where "'" and "_" occur in the startString -> become beginCutIndex and endCutIndex
	//"cleans up" the startString by storing only nucleotide letters into subString
	//determines if the enzyme makes blunt ends or sticky ends
	//calculates the length of subString and highlightWidth
	//sets javascript values for subString, subLength, beginCutIndex, endCutIndex, highlightWidth, and bluntCut
	function cleanCutSite($startString)
	{
		//gets length of cut site that includes "'" and "_" characters
		$startLength = strlen($startString);
		
		//creates an array of characters from $startString
		$startArray = str_split($startString, 1);
		
		//stores the cut site info that excludes "'"'s and "_"'s
		$finalString = "";
		
		//stores "'" character, indicating a cut on the primary DNA strand
		$cut = "'";
		
		//stores "_" character, indicating a cut on the complementary DNA strand
		$under = "_";
		
		//if true, cut will be a vertical line
		//if false, cut will be a staircase pattern
		//should only happen if no "_" are found
		//1 = true, 0 = false
		//default is true
		$bluntCut = 1;
		
		//goes through all characters in &startArray
		for ($i=0; $i<$startLength; $i++)
		{	
			//if "'" is at the current index in $startArray
			if ($startArray[$i] == $cut)
			{
				//set javascript variable to index the "'" was found at
				echo "beginCutIndex=".$i."; \n";
				
				//in the case that no "_" will be found, the endCutIndex will be the same 
				//as the beginCutIndex because it is a blunt cut
				//NOTE: setting the endCutIndex here will NOT be correct if "_" comes before "'" in cut site
				echo "endCutIndex=".$i."; \n";
			}
			
			//if "_" is at the current index in $startArray
			else if ($startArray[$i] == $under)
			{
				//sets javascript variable to index the "_" was found at
				//one must be subtracted from $i to account for the offset
				echo "endCutIndex=".$i."-1; \n";
				
				//if "_" was found, the cut will produce sticky ends
				//update $bluntCut and javascript variable to false
				$bluntCut = 0;
				echo "bluntCut=".$bluntCut."; \n";
			}
			
			//if neither "'" nor "_" was found at the current index in $startArray
			else
			{
				//adds the character at the current index in $startArray to the cleaned-up
				//version of the cut site (no "'" or "_")
				$finalString .= $startArray[$i];
			}
		}
		
		//stores the length of the cleaned-up cut site
		$subLength = strlen($finalString);
		
		//stores the height of the highlight box 
		//dependent on how long the cut site info is
		$highlightWidth = ($subLength*11)-3;
		
		//updates javascript variables for the cleaned-up cut site, its length,
		//the highlight width, and whether the cut site has a blunt cut or makes
		//sticky ends
		echo "subString=\"".$finalString."\"; \n";
		echo "subLength=".$subLength."; \n";
		echo "highlightWidth=".$highlightWidth."; \n";
		echo "bluntCut=".$bluntCut."; \n";
		
	}
?>