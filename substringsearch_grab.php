<html>
	<head>
		<script src="error.js"> </script>
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
			
			var canvasHeight = 0; //height of canvas; depends on number of lines
			var codonNumLine = 93; //number of codons displayed per line
			var rowHeight = 70; //estimated height of row, including symbol, sequence, and complementary sequence
			
			//variables moved from inside drawFound() fxn to make global
			var startPos = 0; //index of current instance
			var canvasPosX = 10; //x position relative to canvas of first character in sequence
			var canvasPosY = 90; //y position relative to canvas of first character in sequence
			var spacingX = 10; //amount of space in pixels between each character on x-axis
			var spacingY = 30; //amount of space in pixels between characters in original string versus complementary string
			var spacingLineGap = 150; //amount of space in pixels between first row of sequence 
					
			var moveX = canvasPosX; //x position where current character should be
			var moveY = canvasPosY; //y position where current character should be
				
			var pullBack = 0; //acts like w, except will be set back to 0 if new line needs to start	
			
			var highlightWidth = (subLength*10)-3; //width of rectangle depends on how long subString is
			var highlightHeight = 10; //assuming each character is about 10px high
			
			var contextS; //use to get CanvasRenderingConext2D -> needed to draw
		
		<?php
			$resEnzyme = addslashes( $_POST['resEnzyme'] );
			echo "resEnzyme=\"".$resEnzyme."\";"; 
			//echo "document.writeln(\"".$resEnzyme."\");";
			//echo "alert(\"".$resEnzyme."\")";
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
				highlightWidth = (subLength*10)-3;
			}
		
			<?php
				//for now, you need to already know gene ID #
				//prompt to type gene ID # in -> puts in preset url code to get file data
				//stores relevant sequence as string
				function getSequence()
				{
					$geneID = addslashes( $_POST['geneID'] );
			
					//uses geneID to get FASTA file web page text for desired organism
					$rawContent = file_get_contents("http://www.ncbi.nlm.nih.gov/sviewer/viewer.fcgi?tool=portal&sendto=on&log$=seqview&db=nuccore&dopt=fasta&val=".$geneID."&extrafeat=0&maxplex=1");
					
					//selects "complete cds" and sequence from the data and stores it as a string
					$rawSequence = stristr( $rawContent, "complete cds" );
					$rawArray = explode("\n", $rawSequence);
					$i=0;
					foreach ($rawArray as $line)
					{
						if ($i>0)
						{echo "bigString += \"".$line."\";\n";}
						
						$i++;
					}
					
					//converts bigString to array of characters (bigArray)
					echo "bigArray = bigString.split(\"\");";
					echo "bigLength = bigArray.length;";
				}
			?>	
			
			//generates compString based on bigString
			//uses that string to make compArray
			function makeComp()
			{
				for (p=0; p<=bigLength; p++)
				{
					//local variables
					var compLetter = ""; //stores letter complementary to randLetter (see if consequences for details)
					
					//finds letter complementary to letter in sequence
					if (bigArray[p] == "A") 
					{
						//a & t are complementary to each other
						compLetter = "T";
					}
					
					else if (bigArray[p] == "T") 
					{
						//a & t are complementary to each other
						compLetter = "A";
					}
					
					else if (bigArray[p] == "C") 
					{
						//c & g are complementary to each other
						compLetter = "G";
					}
					
					else 
					{
						//c & g are complementary to each other
						compLetter = "C";
					}
					
					//create Strings of letters
					compString = compString + compLetter;
				}
				
				//convert Strings of letters to String arrays
				compArray = compString.split("");
			}
			
			//looks thru bigArray for all instances of subArray
			//stores starting index values of subString locations in indexFound[]
			//if no instances found, will report so
			function findSubString()
			{
				//looks through all 459 characters
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
				
				//sets canvasHeight (to be used later) -> depends on number of lines
				canvasHeight = (bigLength/codonNumLine)*rowHeight;
			
				//use to get CanvasRenderingConext2D -> needed to draw
				contextS = canvasS.getContext('2d');
			
				//string containing font style, size and family
				//style = normal(default), italic, or bold
				contextS.font = 'normal 15pt Calibri';
				
				contextS.fillText('Edited sequence:', canvasPosX, 15);
				
				//goes through all 456 characters
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
		<canvas id="searchCanvas" width="1000" height="1000" 
				style="border:1px solid black;"> </canvas>
		
		<script>
			//draws generated sequence with highlight boxes and cuts to show where cut sites are
			drawFound();
		</script>
	</body>
</html>