//file contains selectSite fxn, findSubString fxn, and displayArrays fxn

	//sets subArray and bluntCut depending on what user typed in
	//if enzyme not valid, will report so -> how to make it so redoes it? reload page?
	//takes enzyme name
	//needs to return subArray, subLength, bluntCut, beginCutIndex, endCutIndex, and highlightWidth
	function selectSite(resEnzyme)
	{
		var subString = ""; //holds sequence to be found
		var bluntCut = true;
		var beginCutIndex = 0;
		
		//for now, is case-sensitive
		//all info specific to enzyme -> stuff would be stored in a database
		if (resEnzyme == "AluI")
		{
			subString = "AGCT";
			bluntCut = true;
			beginCutIndex = 2; //cut begins after 2nd character/base -> just before 3rd character (index 2)				
		}
		
		else if (resEnzyme == "TaqI")
		{
			subString = "TCGA";
			bluntCut = false; 
			beginCutIndex = 1; //cut begins after 1st character/base of subString (t)
		}
		
		//enzyme not valid
		else
		{
			alert("This enzyme is not valid.");
		}
		
		//converts subString to array of characters
		//sets subLength equal to number of characters in subArray
		var subArray = subString.split("");
		var subLength = subArray.length;
		
		//only needed for bluntCut = false, but wasn't working when inside that portion b/c subLength hadn't been updated yet
		var endCutIndex = subLength - 1; //cut ends just before last character/base of complementary (t)
		
		//set highlightWidth
		var highlightWidth = (subLength*11)-3;
		
		return [subArray, subLength, bluntCut, beginCutIndex, endCutIndex, highlightWidth];
	}
	
	//looks thru bigArray for all instances of subArray
	//stores starting index values of subString locations in indexFound[]
	//if no instances found, will report so
	//takes subArray, bigLength, and subLength 
	//returns posFound array
	function findSubString(subArray, bigLength, subLength)
	{
		var posFound = [];
		var count = 0;
		
		//looks through all characters in original sequence
		for (i=0; i<(bigLength-subLength); i++) //make sure i+j not off array length
		{
			var looking = true;
			//looks through all subString characters
			for (j=0; j<subLength && looking; j++)
			{
				//if current character does not match character in subArray
				if (bigArray[i+j] != subArray[j]) {looking = false;}
			}
			//inner loop ends if a mismatch (looking = false) -> goes on to next i
			//or found complete match (looking still = true) -> store in array of positions found, then go to next i
			if (looking)
			{
				posFound[count] = i;
				count++;
			}
		}
		
		//if no instances of the cut site are found in the generated sequence
		if (posFound.length == 0)
		{
			document.writeln("Your chosen enzyme " + resEnzyme + " cannot make any cuts in this sequence. <br /> <br />");
		}
		
		return posFound;
	}