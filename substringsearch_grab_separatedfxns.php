<?php
	include ("get_sequence.php");
?>

<html>
<!-- Actual page to be viewed is coded at bottom of file -->
	<head>
		<script src="error.js"> </script>
		<script src="jquery-1.11.2.js"> </script>
		<script src="select_find_cutsites.js"></script>
		<script src="make_comp.js"></script>
		<script src="display_results.js"></script>
		
		<title> OCDAP SubStringSearch Practice: Web Data Retrieval </title>
		<script>
			//attribute list from eclipse java file
			var resEnzyme = ""; //holds name of enzyme to use
			
			var subArray = []; //converts String to String array
			var subLength = 0; //length of subArray; used to be set as subLength = subArray.length here
			
			var bluntCut = true; //if bluntCut=true, enzyme produces blunt ends; if bluntCut=false, enzyme produces sticky ends
			var beginCutIndex = 0; //index within subArray where beginning of cut made
			var endCutIndex = 0; //index w/in subArray where end of cut made; only needed if bluntCut = false
			
			var bigString = ""; //holds String version of generated letters
			var bigArray = []; //holds randomly generated characters; find subString in here
			var bigLength = 0; //how long bigArray is
			
			var compArray = []; //holds complementary characters
			
			var posFound = []; //posFound[i] is the ith occurence of subString
			var count = 0; //number of times subString found

		<?php
			//stores enzyme name the user entered into local php variable
			$resEnzyme = addslashes( $_POST['resEnzyme'] );
			
			//sets javascript variable resEnzyme to the string stored in the php variable $resEnzyme=
			echo "resEnzyme=\"".$resEnzyme."\";\n";
		
			//stores gene ID the user entered into local php variable $geneID
			$geneID = addslashes( $_POST['geneID'] );
			echo "geneID=\"".$geneID."\";\n";
		?>	
		</script>
	</head>
	
	<body>
		<h1>OCDAP SubStringSearch Practice </h1>
		
		<script>
			//based on what enzyme typed in, decides what subString is and stores it
			var enzymeInfo = new selectSite(resEnzyme);
			subArray = enzymeInfo[0];
			subLength = enzymeInfo[1];
			bluntCut = enzymeInfo[2];
			beginCutIndex = enzymeInfo[3];
			endCutIndex = enzymeInfo[4];
			highlightWidth = enzymeInfo[5];
		
			//fxn from get_sequence.php
			//define bigArray as DNA sequence
			//bigLength is the length of the DNA sequence
			<?php 
				//gets sequence from NCBI
				//writes javascript that stores sequence into bigArray
				getSequence($geneID); 
				
				//echo bigLength . "\n";
			?>
			
			//fxn from make_comp.js
			//creates compArray from bigArray
			compArray = new makeComp(bigArray, bigLength);
			/*
			for (i=0; i<bigLength; i++)
			{
				document.write(compArray[i]);
			}
			document.write("<br/>\n");
			*/
			
			//fxn from select_find_cutsites.js
			//looks thru bigArray for all instances of subArray
			//stores starting index values of subString locations in indexFound[]
			posFound = new findSubString(subArray, bigLength, subLength);
			count = posFound.length;
			
			//fxn from display_results.js
			//displays subString and its instances indexes
			displayArrays(resEnzyme, subLength, subArray, posFound, count);
		</script>
		
		<!--separated fxns out so canvas would be made after document.write info, but before stuff actually want to draw-->
		<!--create canvas-->
		<!--border not required, but nice to see where it is for practice purposes-->
		<?php
			$spacingY=30; //amount of space in pixels b/w characters in original string versus complementary string
			$characterHeight=13; //assuming every character is about 13 pixels high
			$spacingLineGap=150; //amount of space in pixels between each of the rows in the sequence
			
			$canvasPosY=90; //y position relative to canvas of first character in sequence
			$canvasHeight=0; //canvas height
			$codonNumLine=93; //number of codons displayed per line (93, constant)
			$totalLineHeight; //total space each line (original sequence plus its complementary sequence, 
									//highlight boxes, symbols, and margins) takes up on canvas	

			//$spacingY/1.5 for space taken up by arrowheads (see drawUpperArrowhead() and drawLowerArrowhead in drawFound())
			//since $spacingLineGap technically includes the height of the lower arrowhead and the upper arrowhead of the next row,
			//there will always be some extra space after the last row with this calculation
			//$characterHeight*2 for the height of the characters in the row (original and complementary -> 13+13 = 26)
			//2nd $spacingY for the space in between the original and complementary strings (30)
			//$spacingLineGap/2 for "margin" space to distinguish one row from another; total margin = 150
			$totalLineHeight=(($spacingY/1.5) + ($characterHeight*2) + $spacingY + ($spacingLineGap/2)); //pixels
				
			//length of $rawString computed in get_sequence.php file
			global $rawLength;
			
			//rounds decimal to whole number
			//$rawLength/$codonNumLine -> calculate number of lines taken up by sequence's characters
			//($rawLength/$codonNumLine)*$totalLineHeight -> calculate total amount of space taken up by all the lines
			//add $canvasPosY to account for space taken up by text "Edited sequence:" (see drawFound())
			$canvasHeight = round($canvasPosY+(($rawLength/$codonNumLine)*$totalLineHeight)); 
			
			echo "<canvas id=\"searchCanvas\" width=\"1000\" height=\"".$canvasHeight."\" style=\"border:1px solid black;\"> </canvas>";
		?>
		
		<script>
			//fxn from display_results.js
			//draws generated sequence with highlight boxes and cuts to show where cut sites are
			drawFound(bigLength, posFound, bluntCut, beginCutIndex, endCutIndex, bigArray, compArray);
		</script>
	</body>
</html>