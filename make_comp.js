//This file contains the makeComp fxn	
	//generates compString based on bigString
	//uses that string to make compArray
	//results will be used to make complementary strand later in drawFound()
	function makeComp(bigArray, bigLength)
	{	
		//local variables
		var compLetter = ""; //stores letter complementary to randLetter (see if consequences for details)
		var compString = ""; //holds String version of letters complementary to generate letters (see randomString comments)
		var compArray = []; //holds complementary characters
		
		//goes through total length of original sequence, character by character
		for (p=0; p<=bigLength; p++)
		{	
			//finds letter complementary to letter in sequence
			if (bigArray[p] == "A") //if the current character is "A"
			{
				//A & T are complementary to each other
				compLetter = "T";
			}
			
			else if (bigArray[p] == "T") //if the current character is "T"
			{
				//A & T are complementary to each other
				compLetter = "A";
			}
			
			else if (bigArray[p] == "C") //if the current character is "C"
			{
				//C & G are complementary to each other
				compLetter = "G";
			}
			
			else //if the current character is "G"
			{
				//C & G are complementary to each other
				compLetter = "C";
			}
			
			//create Strings of letters
			compString = compString + compLetter; //updates compString to add on current compLetter
		}
		
		//convert String of letters (compString) to String array (compArray)
		compArray = compString.split("");
		
		//sets javascript variable compArray to compArray created here
		return compArray;
	}