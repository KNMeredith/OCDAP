<html>
	<head>
		<script src="error.js"> </script>
		<!--<script src="jquery-2.1.1.min.js"> </script>-->
		<title> OCDAP SubStringSearch Practice: Web Data Retrieval </title>
		<script>
			//attribute list from eclipse java file
			var resEnzyme = ""; //holds name of enzyme to use
			
			var subString = ""; //holds sequence to be found
			var subArray = []; //converts String to String array
			var subLength = 0; //length of subArray; used to be set as subLength = subArray.length here
			
			var bluntCut = true; //if bluntCut=true, enzyme produces blunt ends; if bluntCut=false, enzyme produces sticky ends
			var beginCutIndex = 0; //index within subArray where beginning of cut made
			var endCutIndex = 0; //index w/in subArray where end of cut made; only needed if bluntCut = false
			
			var bigString = ""; //holds String version of generated letters
			var bigArray = []; //holds randomly generated characters; find subString in here
			var bigLength = 0; //how long bigArray is
			
			var compString = ""; //holds String version of letters complementary to generate letters (see randomString comments)
			var compArray = []; //holds complementary characters
			
			var posFound = []; //posFound[i] is the ith occurence of subString
			var count = 0; //number of times subString found
			
			<?php 
				$spacingY=30; //amount of space in pixels b/w characters in original string versus complementary string
				$characterHeight=13; //assuming every character is about 13 pixels high
				$spacingLineGap=150; //amount of space in pixels between each of the rows in the sequence
				
				global $canvasPosY; $canvasPosY=90; //global php variable for y position relative to canvas of first character in sequence
				global $canvasHeight; $canvasHeight=0; //global php variable for canvas height
				global $codonNumLine; $codonNumLine=93; //global php variable for number of codons displayed per line (93, constant)
				global $totalLineHeight; //global php variable for total space each line (original sequence plus its complementary sequence, 
										//highlight boxes, symbols, and margins) takes up on canvas	

				//$spacingY/1.5 for space taken up by arrowheads (see drawUpperArrowhead() and drawLowerArrowhead in drawFound())
					//since $spacingLineGap technically includes the height of the lower arrowhead and the uppe rarrowhead of the next row,
					//there will always be some extra space after the last row with this calculation
				//$characterHeight*2 for the height of the characters in the row (original and complementary -> 13+13 = 26)
				//2nd $spacingY for the space in between the original and complementary strings (30)
				//$spacingLineGap/2 for "margin" space to distinguish one row from another; total margin = 150
				$totalLineHeight=(($spacingY/1.5) + ($characterHeight*2) + $spacingY + ($spacingLineGap/2)); //pixels
			?>
					
			//variables moved from inside drawFound() fxn to make global
			var startPos = 0; //index of current instance
			var canvasPosX = 10; //x position relative to canvas of first character in sequence
			var canvasPosY = 90; //y position relative to canvas of first character in sequence
			var spacingX = 10; //amount of space in pixels between each character on x-axis
			var spacingY = 30; //amount of space in pixels between characters in original string versus complementary string
			var spacingLineGap = 150; //amount of space in pixels between each of the rows in the sequence	
			var codonNumLine = 93; //number of codons displayed per line
					
			var moveX = canvasPosX; //x position where current character should be
			var moveY = canvasPosY; //y position where current character should be
				
			var pullBack = 0; //acts like w, except will be set back to 0 if new line needs to start	
			
			var highlightWidth = 0; //width of rectangle depends on how long subString is
			var highlightHeight = 13; //assuming each character is about 13px high
			
			var contextS; //use to get CanvasRenderingConext2D -> needed to draw
		
		<?php
			//stores enzyme name the user entered into local php variable
			$resEnzyme = addslashes( $_POST['resEnzyme'] );
			
			//sets javascript variable resEnzyme to the string stored in the php variable $resEnzyme
			echo "resEnzyme=\"".$resEnzyme."\";";
		?>
		
			//sets subArray and bluntCut depending on what user typed in
			//if enzyme not valid, will report so -> how to make it so redoes it? reload page?
			function selectSite()
			{
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
				subArray = subString.split("");
				subLength = subArray.length;
				
				//only needed for bluntCut = false, but wasn't working when inside that portion b/c subLength hadn't been updated yet
				endCutIndex = subLength - 1; //cut ends just before last character/base of complementary (t)
				
				//set highlightWidth
				highlightWidth = (subLength*11)-3;
			}
		
			<?php
				//for now, you need to already know gene ID #
				//prompt to type gene ID # in -> puts in preset url code to get file data
				//stores relevant sequence as string (bigString)
				//converts that string to array (bigArray)
				//sets bigLength
				function getSequence()
				{
					//need to ave global in front so it knows these variable refer to previously defined ones in earlier php
					global $canvasPosY;
					global $canvasHeight;
					global $codonNumLine;
					global $totalLineHeight;
					
					//stores gene ID the user entered into local php variable $geneID
					$geneID = addslashes( $_POST['geneID'] );
			
					//uses geneID to get FASTA file web page text for desired organism
					$rawContent = file_get_contents("http://www.ncbi.nlm.nih.gov/sviewer/viewer.fcgi?tool=portal&sendto=on&log$=seqview&db=nuccore&dopt=fasta&val=".$geneID."&extrafeat=0&maxplex=1");
					
					//selects "complete cds" and sequence from the data and stores it as a string
					$rawSequence = stristr( $rawContent, "complete cds" );
					
					//separates $rawSequence into an array of characters ($rawArray)
					$rawArray = explode("\n", $rawSequence);
					
					$i=0;  //local php variable to count through lines in sequence
					$rawLength=0; //local php variable to store total length of $rawArray
					
					//each entry in $rawArray stored as $line at every iteration ($line will be set to next character in array every iteration)
					foreach ($rawArray as $line)
					{
						//sets javascript variable bigString to the character $line is currently assigned to
						if ($i>0)
						{echo "bigString += \"".$line."\";\n";}
						
						$i++;
						$rawLength += strlen($line); //updates $rawLength's value after every iteration
					}
					
					//rounds decimal to whole number
					//$rawLength/$codonNumLine -> calculate number of lines taken up by sequence's characters
					//($rawLength/$codonNumLine)*$totalLineHeight -> calculate total amount of space taken up by all the lines
					//add $canvasPosY to account for space taken up by text "Edited sequence:" (see drawFound())
					$canvasHeight = round($canvasPosY+(($rawLength/$codonNumLine)*$totalLineHeight)); 
					
					//converts bigString to array of characters (bigArray)
					//sets bigLength to length of bigArray
					echo "bigArray = bigString.split(\"\");";
					echo "bigLength = bigArray.length;";
				}
			?>	
			
			//generates compString based on bigString
			//uses that string to make compArray
			//results will be used to make complementary strand later in drawFound()
			function makeComp()
			{
				//goes through total length of original sequence, character by character
				for (p=0; p<=bigLength; p++)
				{
					//local variables
					var compLetter = ""; //stores letter complementary to randLetter (see if consequences for details)
					
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
			}
			
			//looks thru bigArray for all instances of subArray
			//stores starting index values of subString locations in indexFound[]
			//if no instances found, will report so
			function findSubString()
			{
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
			}
			
			//displays enzyme 
			//displays subString and its instances indexes
			function displayArrays()
			{
				document.writeln("Your restriction enzyme: <br />" + resEnzyme + "<br /> <br />");
			
				document.writeln("Your cut site:<br />");
				
				//goes through length of subArray[]
				for (h=0; h<subLength; h++)
				{
					document.write(subArray[h]);
				}
				document.writeln("<br /><br />"); 
				
				document.writeln("Instances of cut site found at indexes:<br />");
				
				//if one or more instances of the subString were found
				if (count > 0)
				{
					//goes through length of posFound[]
					for (h=0; h<count; h++)
					{
						document.write(posFound[h] + "&nbsp;&nbsp;&nbsp;"); //&nbsp; = space
					}
				}
				
				//if no instances of the subString are found
				else
				{
					document.write("No instances of the subString were found in the sequence below.");
				}
				
				document.writeln("<br /><br />");
			}
	
			//draws generated sequence with highlight boxes to show where sub-string instances are
			//draws cut as instances drawn
			function drawFound()
			{
				//sets canvasS as element to be edited
				var canvasS = document.getElementById('searchCanvas');
			
				//use to get CanvasRenderingConext2D -> needed to draw
				contextS = canvasS.getContext('2d');
			
				//string containing font style, size and family
				//style = normal(default), italic, or bold
				contextS.font = 'normal 15pt Calibri';
				
				contextS.fillText('Edited sequence:', canvasPosX, 15);
				
				//goes through all characters in original sequence
				for (w=0; w<bigLength; w++)
				{		
					//x position of current character
					moveX = canvasPosX + (spacingX*pullBack);
					
					//if the current character's index value matches a posFound[] value
					if (w == posFound[startPos])
					{
						//draws rectangle where subString characters will be drawn
						contextS.fillStyle = "cyan";
						contextS.fillRect(moveX, moveY-highlightHeight, highlightWidth, highlightHeight); //for original strand
							
						//draws rectangle where complementary subString characters will be drawn
						contextS.fillStyle = "yellow";
						contextS.fillRect(moveX, (moveY + spacingY)-highlightHeight, highlightWidth, highlightHeight); //for complementary strand 
						
						//if enzyme used produces blunt ends
						if (bluntCut == true)
						{
							//draws vertical line
							contextS.beginPath();
							contextS.moveTo((beginCutIndex*spacingX) + moveX, moveY - spacingY);
							contextS.lineTo((beginCutIndex*spacingX) + moveX, moveY + (2*spacingY));
							contextS.stroke();
							
							//draws upper arrowhead
							drawUpperArrowhead((beginCutIndex*spacingX) + moveX, moveY - (spacingY/1.5));
							
							//draws lower arrowhead
							drawLowerArrowhead((beginCutIndex*spacingX) + moveX, moveY + (1.5*spacingY));
						}
						
						//if enzyme used produces sticky ends
						else
						{
							//draws sticky cut
							contextS.fillStyle = "gray";
							contextS.beginPath();
							//first vertical line
							contextS.moveTo((beginCutIndex*spacingX) + moveX, moveY - spacingY);
							//horizontal line; same y, different x
							contextS.lineTo((beginCutIndex*spacingX) + moveX, moveY + (spacingY/3));
							contextS.lineTo((endCutIndex*spacingX) + moveX, moveY + (spacingY/3));
							//second vertical line; same x as point before, different y
							contextS.lineTo((endCutIndex*spacingX) + moveX, moveY + (2*spacingY));
							contextS.stroke();
							
							//draws upper arrowhead
							drawUpperArrowhead((beginCutIndex*spacingX) + moveX, moveY - (spacingY/1.5));
							
							//draws lower arrowhead
							drawLowerArrowhead((endCutIndex*spacingX) + moveX, moveY + (1.5*spacingY));
						}
							
						//increments startPos to find next instance
						startPos++;
					}
					
					//continues drawing out characters in generated sequence
					//if gets to edge of canvas, will have to adjust y as well
					//sets fillStyle back to black in case a rectangle had to be drawn
					contextS.fillStyle = "black";
					contextS.fillText(bigArray[w], moveX, moveY);
					
					//draws complementary character below
					contextS.fillText(compArray[w], moveX, moveY + spacingY);
					
					//increments pullBack as w increments
					pullBack++;
					
					//moves to new line after 31 codons (93 characters)
					//resets appropriate variable to original values (pullBack)
					//moves y position to be further down canvas for next line
					if ((w+1)%codonNumLine == 0)
					{
						pullBack = 0;
						moveY = moveY + spacingLineGap;
					}
				}
			}
			
			//draws upper triangle for cut site
			function drawUpperArrowhead(lowX, lowY)
			{
				//draws lower arrowhead
				contextS.fillStyle = "gray";
				contextS.beginPath();
				contextS.moveTo(lowX, lowY);
				contextS.lineTo(lowX - (spacingX/2), lowY - (spacingY/2));
				contextS.lineTo(lowX + (spacingX/2), lowY - (spacingY/2));
				contextS.closePath();
				contextS.fill();
			}
			
			//draws lower triangle for cut site
			function drawLowerArrowhead(lowX, lowY)
			{
				//draws lower arrowhead
				contextS.fillStyle = "gray";
				contextS.beginPath();
				contextS.moveTo(lowX, lowY);
				contextS.lineTo(lowX - (spacingX/2), lowY + (spacingY/2));
				contextS.lineTo(lowX + (spacingX/2), lowY + (spacingY/2));
				contextS.closePath();
				contextS.fill();
			}
		</script>
	</head>
	
	<body>
		<h1>OCDAP SubStringSearch Practice </h1>
		
		<script>
			//based on what enzyme typed in, decides what subString is and stores it
			selectSite();
		
			//gets sequence from NCBI and stores into bigArray
			<?php getSequence(); ?>
			
			//creates compArray from bigArray
			makeComp();
			
			//looks thru bigArray for all instances of subArray
			//stores starting index values of subString locations in indexFound[]
			findSubString();
			
			//displays subString and its instances indexes
			displayArrays();
		</script>
		
		<!--separated fxns out so canvas would be made after document.write info, but before stuff actually want to draw-->
		<!--create canvas-->
		<!--border not required, but nice to see where it is for practice purposes-->
		<?php
			echo "<canvas id=\"searchCanvas\" width=\"1000\" height=\"".$canvasHeight."\" style=\"border:1px solid black;\"> </canvas>";
		?>
		
		<script>
			//draws generated sequence with highlight boxes and cuts to show where cut sites are
			drawFound();
		</script>
	</body>
</html>