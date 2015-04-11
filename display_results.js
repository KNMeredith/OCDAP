//This file contains the displayArrays fxn, drawFound fxn, drawUpperArrowhead fxn, and drawLowerArrowhead fxn
	//displays enzyme 
	//displays subString and its instances indexes
	//takes resEnzyme, subLength, subArray, posFound, and count
	function displayArrays(resEnzyme, subLength, subArray, posFound, count)
	{
		document.writeln("Your restriction enzyme: <br />" + resEnzyme + "<br /> <br />");
	
		document.writeln("Your cut site:<br />");
		
		//goes through length of subArray[]
		for (h=0; h<subLength; h++)
		{
			document.write(subArray[h]); //writes the current character of the loop
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
																	//writes the current position of the loop
			}
		}
		
		//if no instances of the subString are found
		else
		{
			//tells the user the enzyme could not cut anywhere in the DNA sequence
			document.writeln("No instances of the subString were found in the sequence below.");
		}
		
		document.writeln("<br /><br />");
	}
	
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
	
	//draws generated sequence with highlight boxes to show where sub-string instances are
	//draws cut as instances drawn
	//takes bigLength, posFound, bluntCut, beginCutIndex, endCutIndex, bigArray, compArray
	function drawFound(bigLength, posFound, bluntCut, beginCutIndex, endCutIndex, bigArray, compArray)
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
				if (bluntCut == 1)
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