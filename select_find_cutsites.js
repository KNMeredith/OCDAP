//file contains findSubString fxn

	//looks thru bigArray for all instances of subArray
	//stores starting index values of subString locations in indexFound[]
	//if no instances found, will report so
	//takes subArray, bigLength, and subLength 
	//returns posFound array
	function findSubString(subArray, bigLength, subLength)
	{
		var posFound = []; //stores all positions/indexes where subString is found
		var count = 0; //counter
		
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
				posFound[count] = i; //stores the current index/position into the posFound array
				count++; //increases the counter
			}
		}
		
		//if no instances of the cut site are found in the generated sequence
		if (posFound.length == 0)
		{
			//tells the user that the enzyme could not cut anywhere in the sequence
			document.writeln("Your chosen enzyme " + resEnzyme + " cannot make any cuts in this sequence. <br /> <br />");
		}
		
		//sets javascript array posFound to the posFound created here
		return posFound;
	}