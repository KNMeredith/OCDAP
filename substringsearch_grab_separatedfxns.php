<?php
	//php function files needed
	include ("clean_cutsite.php");
	include ("get_sequence.php");
?>

<html>
<!-- Main page from which functions are called -->
<!-- Actual page to be viewed is coded at bottom of file -->
	<head>
		<!-- javascript function files needed-->
		<script src="error.js"> </script>
		<script src="jquery-1.11.2.js"> </script>
		<script src="select_find_cutsites.js"></script>
		<script src="make_comp.js"></script>
		<script src="display_results.js"></script>
		
		<title> OCDAP Restriction Map </title>
		<script>
			//attribute list
			var resEnzyme = ""; //holds name of enzyme to use
			
			var startString = ""; //holds the initial cut site info sent from the form; contains "'"'s and "_"'s
			var subString = ""; //holds the "cleaned up" version of startString; does NOT contain "'"'s or "_"'s
			var subArray = []; //stores each character contained within subString as an array
			var subLength = 0; //holds how many indexes/characters subArray contains
			
			var bluntCut = 1; //if bluntCut = 1, enzyme produces blunt ends; if bluntCut = 0, enzyme produces sticky ends
			var beginCutIndex = 0; //index within subArray where beginning of cut is made
			var endCutIndex = 0; //index within subArray where end of cut made; different from beginCutIndex only if bluntCut = 0
			
			var bigString = ""; //holds String version of the desired DNA/gene sequence
			var bigArray = []; //stores each character of bigString as an array; will search for subString in here
			var bigLength = 0; //holds how many indexes/characters bigArray contains
			
			var compArray = []; //holds complementary characters (generated from desired gene sequence)
			
			var posFound = []; //posFound[i] is the ith occurence of subString
			var count = 0; //number of times subString found

		<?php
			//splits combined version of enzyme name and its cute site info selected into local php array variable
			$enzymeInfo = explode("|", $_POST['resEnzyme'] );
			//sets local php variables to either enzyme name or cut site info
			$startString = $enzymeInfo[0];
			$resEnzyme = $enzymeInfo[1];
			
			//sets javascript variable resEnzyme to the string stored in the php variable $resEnzyme
			//sets javascript variable startString to the string stored in the php variable $startString
			echo "resEnzyme=\"".$resEnzyme."\";\n";
			echo "startString=\"".$startString."\";\n";
		
			//stores gene ID the user entered into local php variable $geneID
			$geneID = addslashes( $_POST['geneID'] );
			
			//sets javascript variable geneID to the string stored in the php variable $geneID
			echo "geneID=\"".$geneID."\";\n";
		?>	
		</script>
	</head>
	
	<body>
		<h1>OCDAP Restriction Map </h1>
		
		<script>
			<?php
				//calls cleanCutSite fxn in clean_cutsite.php file
				//finds and sets javascript values for subString, subLength, beginCutIndex, endCutIndex, highlightWidth, and bluntCut
				//must send the startString as a parameter
				cleanCutSite($startString);
		 
				//calls getSequence fxn in get_sequence.php file
				//retrieves gene sequence info from NCBI
				//finds and sets javascript values for bigString, bigArray, and bigLength
				//must send the geneID as a parameter
				getSequence($geneID); 
			?>
			
			//calls makeComp fxn from make_comp.js
			//creates and sets an array object of nucleotides (compArray) that are complementary to those from bigArray
			//must send bigArray and bigLength as parameters
			compArray = new makeComp(bigArray, bigLength);
			
			//update subArray to hold all the characters within subString
			subArray = subString.split("");
			
			//calls findSubString fxn from select_find_cutsites.js
			//looks through bigArray for all instances of subArray
			//stores starting index values of subString locations in indexFound[]
			//must send subArray, bigLength, and subLength as parameters
			posFound = new findSubString(subArray, bigLength, subLength);
			
			//updates count to the length of posFound (the number of times subString was found)
			count = posFound.length;
			
			//calls displayArrays from display_results.js
			//displays subString and its instances' indexes
			//must send resEnzyme, subLength, subArray, posFound, and count as parameters
			displayArrays(resEnzyme, subLength, subArray, posFound, count);
		</script>
		
		<!--separated fxns out so canvas would be made after document.write info, but before stuff actually want to draw-->
		<!--create canvas-->
		<!--border not required, but nice to see where it is to see size of canvas-->
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
			
			//creates the canvas in javascript
			echo "<canvas id=\"searchCanvas\" width=\"1000\" height=\"".$canvasHeight."\" style=\"border:1px solid black;\"> </canvas>";
		?>
		
		<script>
			//calls the drawFound fxn from display_results.js
			//draws generated sequence with highlight boxes and cuts to show where cut sites are
			//must send bigLength, posFound, bluntCut, beginCutIndex, endCutIndex, bigArray, and compArray as parameters
			drawFound(bigLength, posFound, bluntCut, beginCutIndex, endCutIndex, bigArray, compArray);
		</script>
	</body>
</html>