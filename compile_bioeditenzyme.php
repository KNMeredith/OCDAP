<?php
//Retrieves enzyme information from bioedit_enzyme-2.tab file
//Creates enzymeBigArray, an array of enzyme elements (name, its cut site, etc. = one element)
//Separates each element of enzymeBigArray into smallerArray (name = one element, its cut site = another element)
//Calls addEnzyme function with name and cuteSite as parameters

	//sets variable to the name of the file to be read
	$file_to_read = "bioedit_enzyme-2.tab";
	
	//stores text contents of $file_to_read into $enzymeFullText 
	$enzymeFullText = file_get_contents($file_to_read);
	
	//finds all text starting at and onward from "AarI" in $file_to_read's text -> only the restriction enzyme information we need
	//stores resulting text from search above into $enzymeRelevantText
	$enzymeRelevantText = stristr($enzymeFullText, "AarI");
	
	//replaces all random amounts of spaces between characters with just one space -> creates an easier separator
	$enzymeWorkableText = preg_replace('/\s+/', ' ', $enzymeRelevantText);

	//creates an array of enzyme elements from the workable text using a space as the separator
	//stores array into $enzymeBigArray
	$enzymeBigArray = explode(";",$enzymeWorkableText);
	
	//goes through each element, one at a time, until $enzymeBigArray runs out
	foreach ($enzymeBigArray as $element)
	{
		//makes current element from $enzymeBigArray into an array of smaller elements
		$smallerArray = explode(" ",$element);
		//stores enzyme's name (first item in smallerArray) into the public $name variable from enzyme_table.php
		$name = $smallerArray[0];
		//stores enzyme's cut site (third item in smallerArray) into the public $cutSite variable from enzyme_table.php
		$cutSite = $smallerArray[2];
		
		//calls addEnzyme function in javascript, using the above two variables as parameters
		//prints out results of function; is called for each element in $enzymeBigArray
		echo "addEnzyme(\"$name\", \"$cutSite\");<br/>\n";
	}
?>