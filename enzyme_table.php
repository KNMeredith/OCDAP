<?php
//Enzyme name and cut site information copied and pasted from addEnzyme function call in compile_bioeditenzyme.php
//Stores name and cut site of each enzyme into the enzymeList array using the keys "name" and "cutSite" with the addEnzyme function
	class Enzyme
	{
		public $name;
		public $cutSite;
	}

	$enzymeList = array();
	global $enzymeList;
	
	//counter to track index use in array
	$enzymeCount = 0;
	global $enzymeCount;
	
	//creates new enzyme object in $enzymeList array
	function addEnzyme($n, $cs)
	{
		//echo "name is $n, cutsite is $cs";
		
		global $enzymeCount;
		global $enzymeList;
		
		//using a smaller variable name so it doesn't get confused
		$e = new Enzyme;
		$e -> name = $n;
		$e -> cutSite = $cs;
		
		$enzymeList[$enzymeCount] = $e;
		
		$enzymeCount++;
	}
	
	function enzymeMenu()
	{
		global $enzymeCount;
		global $enzymeList;
		
		echo "<select>\n";
		
		//goes through all the enzymes
		for ($i=0; $i<$enzymeCount; $i++)
		{
			$e = $enzymeList[$i];
			
			//sets as true (funny characters in the cut site) or false (no funny characters in the cut site)
			$funnyStatus = findFunny($e->cutSite);
			
			//need to check if enzyme cutsite has funny stuff in it other than apostrophes
			if ($funnyStatus == false)
			{
				//if no funny characters are in the cut site, can present it as an option in the drop down menu
				echo "<option value=".$i.">".$e->name."</option>\n";
			}
		}
		
		echo "</select>\n";
	}
	
	//check current enzyme to see if has funny characters
	//return true if have funny characters, false if not
	function findFunny($cutInfo)
	{
		//not looking for _ right now
		//we want to look for these characters
		$funnyList = ();
		$funnyList[0] = "r";
		$funnyList[1] = "y";
		$funnyList[2] = "m";
		$funnyList[3] = "k";
		$funnyList[4] = "s";
		$funnyList[5] = "w";
		$funnyList[6] = "b";
		$funnyList[7] = "d";
		$funnyList[8] = "h";
		$funnyList[9] = "v";
		$funnyList[10] = "n";
		
		//stores length of funnyList, should be 11
		$funnyListLength = $funnyList.length;
		
		//goes through all the funny characters and looks for the first instance of them in the cut site
		for ($i=0; $i<$funnyListLength; $i++)
		{
			$f = $funnyList[$i];
			//looks for first instance of current funny character
			$funnyPos = strpos($cutInfo, $f);
			
			if ($funnyPos !== false)
			{
				//if the current funny character is in the cut site, return true
				return true;
				//breaks the loop because once a funny character has been found, don't need to look at the other ones
				break;
			}
			
			else
			{
				//if the current funny character isn't found in the cut site, return false;
				//could probably put this part outside of the for loop
				return false;
			}
		}
		
		//not looking for _ right now
		//$numFunnyChar = strspn($cutInfo,"rymkswbdhvn");
		/*
		echo "funnyChar = ".$funnyChar." ";
		echo "cutsite is ".$cutInfo." ";
		*/
		/*
		if ($funnyStatus != 0)
		{
			return true;
		}
		
		else
		{
			return false;
		}
		*/
	}
	
	addEnzyme("AarI", "CACCTGCnnnn'nnnn_");
	addEnzyme("AasI", "GACnn_nn'nnGTC");
	addEnzyme("AatI", "AGG'CCT");
	addEnzyme("AatII", "G_ACGT'C");
	addEnzyme("AauI", "T'GTAC_A");
	addEnzyme("AccI", "GT'mk_AC");
	addEnzyme("AccII", "CG'CG");
	addEnzyme("AccIII", "T'CCGG_A");
	addEnzyme("Acc16I", "TGC'GCA");
	addEnzyme("Acc36I", "ACCTGCnnnn'nnnn_");
	addEnzyme("Acc65I", "G'GTAC_C");
	addEnzyme("Acc113I", "AGT'ACT");
	addEnzyme("AccB1I", "G'GyrC_C");
	addEnzyme("AccB7I", "CCAn_nnn'nTGG");
	addEnzyme("AccBSI", "CCG'CTC");
	addEnzyme("AceIII", "CAGCTCnnnnnnn'nnnn_");
	addEnzyme("AciI", "C'CG_C");
	addEnzyme("AclI", "AA'CG_TT");
	addEnzyme("AclWI", "GGATCnnnn'n_");
	addEnzyme("AcsI", "r'AATT_y");
	addEnzyme("AcuI", "CTGAAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("AcvI", "CAC'GTG");
	addEnzyme("AcyI", "Gr'CG_yC");
	addEnzyme("AdeI", "CAC_nnn'GTG");
	addEnzyme("AfaI", "GT'AC");
	addEnzyme("AfeI", "AGC'GCT");
	addEnzyme("AflI", "G'GwC_C");
	addEnzyme("AflII", "C'TTAA_G");
	addEnzyme("AflIII", "A'CryG_T");
	addEnzyme("AgeI", "A'CCGG_T");
	addEnzyme("AhaIII", "TTT'AAA");
	addEnzyme("AhdI", "GACnn_n'nnGTC");
	addEnzyme("AhlI", "A'CTAG_T");
	addEnzyme("AleI", "CACnn'nnGTG");
	addEnzyme("AloI", "GAACnnnnnnTCCnnnnnnn_nnnnn'");
	addEnzyme("AloI", "GGAnnnnnnGTTCnnnnnnn_nnnnn'");
	addEnzyme("AluI", "AG'CT");
	addEnzyme("AlwI", "GGATCnnnn'n_");
	addEnzyme("Alw21I", "G_wGCw'C");
	addEnzyme("Alw26I", "GTCTCn'nnnn_");
	addEnzyme("Alw44I", "G'TGCA_C");
	addEnzyme("AlwNI", "CAG_nnn'CTG");
	addEnzyme("Ama87I", "C'yCGr_G");
	addEnzyme("AocI", "CC'TnA_GG");
	addEnzyme("Aor51HI", "AGC'GCT");
	addEnzyme("ApaI", "G_GGCC'C");
	addEnzyme("ApaBI", "GCA_nnnnn'TGC");
	addEnzyme("ApaLI", "G'TGCA_C");
	addEnzyme("ApoI", "r'AATT_y");
	addEnzyme("AscI", "GG'CGCG_CC");
	addEnzyme("AseI", "AT'TA_AT");
	addEnzyme("AsiAI", "A'CCGG_T");
	addEnzyme("AsiSI", "GCG_AT'CGC");
	addEnzyme("AsnI", "AT'TA_AT");
	addEnzyme("AspI", "GACn'n_nGTC");
	addEnzyme("Asp700I", "GAAnn'nnTTC");
	addEnzyme("Asp718I", "G'GTAC_C");
	addEnzyme("AspEI", "GACnn_n'nnGTC");
	addEnzyme("AspHI", "G_wGCw'C");
	addEnzyme("AspLEI", "G_CG'C");
	addEnzyme("AspS9I", "G'GnC_C");
	addEnzyme("AsuI", "G'GnC_C");
	addEnzyme("AsuII", "TT'CG_AA");
	addEnzyme("AsuC2I", "CC's_GG");
	addEnzyme("AsuHPI", "GGTGAnnnnnnn_n'");
	addEnzyme("AsuNHI", "G'CTAG_C");
	addEnzyme("AvaI", "C'yCGr_G");
	addEnzyme("AvaII", "G'GwC_C");
	addEnzyme("AvaIII", "ATGCAT");
	addEnzyme("AviII", "TGC'GCA");
	addEnzyme("AvrII", "C'CTAG_G");
	addEnzyme("AxyI", "CC'TnA_GG");
	addEnzyme("BaeI", "ACnnnnGTAyCnnnnnnn_nnnnn'");
	addEnzyme("BaeI", "GrTACnnnnGTnnnnnnnnnn_nnnnn'");
	addEnzyme("BalI", "TGG'CCA");
	addEnzyme("BamHI", "G'GATC_C");
	addEnzyme("BanI", "G'GyrC_C");
	addEnzyme("BanII", "G_rGCy'C");
	addEnzyme("BanIII", "AT'CG_AT");
	addEnzyme("BbeI", "G_GCGC'C");
	addEnzyme("Bbr7I", "GAAGACnnnnnnn'nnnn_");
	addEnzyme("BbrPI", "CAC'GTG");
	addEnzyme("BbsI", "GAAGACnn'nnnn_");
	addEnzyme("BbuI", "G_CATG'C");
	addEnzyme("BbvI", "GCAGCnnnnnnnn'nnnn_");
	addEnzyme("BbvII", "GAAGACnn'nnnn_");
	addEnzyme("Bbv12I", "G_wGCw'C");
	addEnzyme("BbvCI", "CC'TCA_GC");
	addEnzyme("BccI", "CCATCnnnn'n_");
	addEnzyme("Bce83I", "CTTGAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("BceAI", "ACGGCnnnnnnnnnnnn'nn_");
	addEnzyme("BcefI", "ACGGCnnnnnnnnnnnn'n_");
	addEnzyme("BcgI", "CGAnnnnnnTGCnnnnnnnnnn_nn'");
	addEnzyme("BcgI", "GCAnnnnnnTCGnnnnnnnnnn_nn'");
	addEnzyme("BciVI", "GTATCCnnnnn_n'");
	addEnzyme("BclI", "T'GATC_A");
	addEnzyme("BcnI", "CC's_GG");
	addEnzyme("BcoI", "C'yCGr_G");
	addEnzyme("BcuI", "A'CTAG_T");
	addEnzyme("BetI", "w'CCGG_w");
	addEnzyme("BfaI", "C'TA_G");
	addEnzyme("BfiI", "ACTGGGnnnn_n'");
	addEnzyme("BfmI", "C'TryA_G");
	addEnzyme("BfrI", "C'TTAA_G");
	addEnzyme("BfrBI", "ATG'CAT");
	addEnzyme("BfuI", "GTATCCnnnnn_n'");
	addEnzyme("BfuAI", "ACCTGCnnnn'nnnn_");
	addEnzyme("BfuCI", "'GATC_");
	addEnzyme("BglI", "GCCn_nnn'nGGC");
	addEnzyme("BglII", "A'GATC_T");
	addEnzyme("BinI", "GGATCnnnn'n_");
	addEnzyme("BlnI", "C'CTAG_G");
	addEnzyme("BlpI", "GC'TnA_GC");
	addEnzyme("Bme18I", "G'GwC_C");
	addEnzyme("Bme1390I", "CC'n_GG");
	addEnzyme("Bme1580I", "G_kGCm'C");
	addEnzyme("BmgI", "GkGCCC");
	addEnzyme("BmgBI", "CAC'GTC");
	addEnzyme("BmrI", "ACTGGGnnnn_n'");
	addEnzyme("BmtI", "G_CTAG'C");
	addEnzyme("BmyI", "G_dGCh'C");
	addEnzyme("BoxI", "GACnn'nnGTC");
	addEnzyme("BpiI", "GAAGACnn'nnnn_");
	addEnzyme("BplI", "GAGnnnnnCTCnnnnnnnn_nnnnn'");
	addEnzyme("BpmI", "CTGGAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("Bpu10I", "CC'TnA_GC");
	addEnzyme("Bpu14I", "TT'CG_AA");
	addEnzyme("Bpu1102I", "GC'TnA_GC");
	addEnzyme("BpuAI", "GAAGACnn'nnnn_");
	addEnzyme("BpuEI", "CTTGAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("BsaI", "GGTCTCn'nnnn_");
	addEnzyme("Bsa29I", "AT'CG_AT");
	addEnzyme("BsaAI", "yAC'GTr");
	addEnzyme("BsaBI", "GATnn'nnATC");
	addEnzyme("BsaHI", "Gr'CG_yC");
	addEnzyme("BsaJI", "C'CnnG_G");
	addEnzyme("BsaMI", "GAATG_Cn'");
	addEnzyme("BsaOI", "CG_ry'CG");
	addEnzyme("BsaWI", "w'CCGG_w");
	addEnzyme("BsaXI", "ACnnnnnCTCCnnnnnnn_nnn'");
	addEnzyme("BsaXI", "GGAGnnnnnGTnnnnnnnnn_nnn'");
	addEnzyme("BsbI", "CAACAC");
	addEnzyme("Bsc4I", "CCnn_nnn'nnGG");
	addEnzyme("BscAI", "GCATCnnnn'nn_");
	addEnzyme("BscBI", "GGn'nCC");
	addEnzyme("BscCI", "GAATG_Cn'");
	addEnzyme("BscFI", "'GATC_");
	addEnzyme("BscGI", "CCCGT");
	addEnzyme("Bse1I", "ACTG_Gn'");
	addEnzyme("Bse8I", "GATnn'nnATC");
	addEnzyme("Bse21I", "CC'TnA_GG");
	addEnzyme("Bse118I", "r'CCGG_y");
	addEnzyme("BseAI", "T'CCGG_A");
	addEnzyme("BseBI", "CC'w_GG");
	addEnzyme("BseCI", "AT'CG_AT");
	addEnzyme("BseDI", "C'CnnG_G");
	addEnzyme("Bse3DI", "GCAATG_nn'");
	addEnzyme("BseGI", "GGATG_nn'");
	addEnzyme("BseJI", "GATnn'nnATC");
	addEnzyme("BseLI", "CCnn_nnn'nnGG");
	addEnzyme("BseMI", "GCAATG_nn'");
	addEnzyme("BseMII", "CTCAGnnnnnnnn_nn'");
	addEnzyme("BseNI", "ACTG_Gn'");
	addEnzyme("BsePI", "G'CGCG_C");
	addEnzyme("BseRI", "GAGGAGnnnnnnnn_nn'");
	addEnzyme("BseSI", "G_kGCm'C");
	addEnzyme("BseXI", "GCAGCnnnnnnnn'nnnn_");
	addEnzyme("BseX3I", "C'GGCC_G");
	addEnzyme("BseYI", "C'CCAG_C");
	addEnzyme("BsgI", "GTGCAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("BshI", "GG'CC");
	addEnzyme("Bsh1236I", "CG'CG");
	addEnzyme("Bsh1285I", "CG_ry'CG");
	addEnzyme("BshFI", "GG'CC");
	addEnzyme("BshNI", "G'GyrC_C");
	addEnzyme("BshTI", "A'CCGG_T");
	addEnzyme("BsiI", "C'ACGA_G");
	addEnzyme("BsiBI", "GATnn'nnATC");
	addEnzyme("BsiCI", "TT'CG_AA");
	addEnzyme("BsiEI", "CG_ry'CG");
	addEnzyme("BsiHKAI", "G_wGCw'C");
	addEnzyme("BsiHKCI", "C'yCGr_G");
	addEnzyme("BsiLI", "CC'w_GG");
	addEnzyme("BsiMI", "T'CCGG_A");
	addEnzyme("BsiQI", "T'GATC_A");
	addEnzyme("BsiSI", "C'CG_G");
	addEnzyme("BsiWI", "C'GTAC_G");
	addEnzyme("BsiXI", "AT'CG_AT");
	addEnzyme("BsiYI", "CCnn_nnn'nnGG");
	addEnzyme("BsiZI", "G'GnC_C");
	addEnzyme("BslI", "CCnn_nnn'nnGG");
	addEnzyme("BsmI", "GAATG_Cn'");
	addEnzyme("BsmAI", "GTCTCn'nnnn_");
	addEnzyme("BsmBI", "CGTCTCn'nnnn_");
	addEnzyme("BsmFI", "GGGACnnnnnnnnnn'nnnn_");
	addEnzyme("Bso31I", "GGTCTCn'nnnn_");
	addEnzyme("BsoBI", "C'yCGr_G");
	addEnzyme("BsoMAI", "GTCTCn'nnnn_");
	addEnzyme("Bsp13I", "T'CCGG_A");
	addEnzyme("Bsp19I", "C'CATG_G");
	addEnzyme("Bsp24I", "GACnnnnnnTGGnnnnnnn_nnnnn'");
	addEnzyme("Bsp24I", "CCAnnnnnnGTCnnnnnnnn_nnnnn'");
	addEnzyme("Bsp68I", "TCG'CGA");
	addEnzyme("Bsp106I", "AT'CG_AT");
	addEnzyme("Bsp119I", "TT'CG_AA");
	addEnzyme("Bsp120I", "G'GGCC_C");
	addEnzyme("Bsp143I", "'GATC_");
	addEnzyme("Bsp143II", "r_GCGC'y");
	addEnzyme("Bsp1286I", "G_dGCh'C");
	addEnzyme("Bsp1407I", "T'GTAC_A");
	addEnzyme("Bsp1720I", "GC'TnA_GC");
	addEnzyme("BspA2I", "C'CTAG_G");
	addEnzyme("BspCI", "CG_AT'CG");
	addEnzyme("BspCNI", "CTCAGnnnnnnn_nn'");
	addEnzyme("BspDI", "AT'CG_AT");
	addEnzyme("BspEI", "T'CCGG_A");
	addEnzyme("BspGI", "CTGGAC");
	addEnzyme("BspHI", "T'CATG_A");
	addEnzyme("BspLI", "GGn'nCC");
	addEnzyme("BspLU11I", "A'CATG_T");
	addEnzyme("BspMI", "ACCTGCnnnn'nnnn_");
	addEnzyme("BspMII", "T'CCGG_A");
	addEnzyme("BspNCI", "CCAGA");
	addEnzyme("BspPI", "GGATCnnnn'n_");
	addEnzyme("BspTI", "C'TTAA_G");
	addEnzyme("BspT104I", "TT'CG_AA");
	addEnzyme("BspT107I", "G'GyrC_C");
	addEnzyme("BspTNI", "GGTCTCn'nnnn_");
	addEnzyme("BspXI", "AT'CG_AT");
	addEnzyme("BsrI", "ACTG_Gn'");
	addEnzyme("BsrBI", "CCG'CTC");
	addEnzyme("BsrBRI", "GATnn'nnATC");
	addEnzyme("BsrDI", "GCAATG_nn'");
	addEnzyme("BsrFI", "r'CCGG_y");
	addEnzyme("BsrGI", "T'GTAC_A");
	addEnzyme("BsrSI", "ACTG_Gn'");
	addEnzyme("BssAI", "r'CCGG_y");
	addEnzyme("BssECI", "C'CnnG_G");
	addEnzyme("BssHI", "C'TCGA_G");
	addEnzyme("BssHII", "G'CGCG_C");
	addEnzyme("BssKI", "'CCnGG_");
	addEnzyme("BssNAI", "GTA'TAC");
	addEnzyme("BssSI", "C'ACGA_G");
	addEnzyme("BssT1I", "C'CwwG_G");
	addEnzyme("Bst6I", "CTCTTCn'nnn_");
	addEnzyme("Bst71I", "GCAGCnnnnnnnn'nnnn_");
	addEnzyme("Bst98I", "C'TTAA_G");
	addEnzyme("Bst1107I", "GTA'TAC");
	addEnzyme("BstACI", "Gr'CG_yC");
	addEnzyme("BstAPI", "GCAn_nnn'nTGC");
	addEnzyme("BstBI", "TT'CG_AA");
	addEnzyme("Bst2BI", "C'ACGA_G");
	addEnzyme("BstBAI", "yAC'GTr");
	addEnzyme("Bst4CI", "AC_n'GT");
	addEnzyme("BstC8I", "GCn'nGC");
	addEnzyme("BstDEI", "C'TnA_G");
	addEnzyme("BstDSI", "C'CryG_G");
	addEnzyme("BstEII", "G'GTnAC_C");
	addEnzyme("BstENI", "CCTnn'n_nnAGG");
	addEnzyme("BstENII", "'GATC_");
	addEnzyme("BstF5I", "GGATG_nn'");
	addEnzyme("BstFNI", "CG'CG");
	addEnzyme("BstH2I", "r_GCGC'y");
	addEnzyme("BstHHI", "G_CG'C");
	addEnzyme("BstHPI", "GTT'AAC");
	addEnzyme("BstKTI", "G_AT'C");
	addEnzyme("BstMAI", "C_TGCA'G");
	addEnzyme("BstMCI", "CG_ry'CG");
	addEnzyme("BstMWI", "GCnn_nnn'nnGC");
	addEnzyme("BstNI", "CC'w_GG");
	addEnzyme("BstNSI", "r_CATG'y");
	addEnzyme("BstOI", "CC'w_GG");
	addEnzyme("BstPI", "G'GTnAC_C");
	addEnzyme("BstPAI", "GACnn'nnGTC");
	addEnzyme("BstSCI", "'CCnGG_");
	addEnzyme("BstSFI", "C'TryA_G");
	addEnzyme("BstSNI", "TAC'GTA");
	addEnzyme("BstUI", "CG'CG");
	addEnzyme("Bst2UI", "CC'w_GG");
	addEnzyme("BstV1I", "GCAGCnnnnnnnn'nnnn_");
	addEnzyme("BstV2I", "GAAGACnn'nnnn_");
	addEnzyme("BstXI", "CCAn_nnnn'nTGG");
	addEnzyme("BstX2I", "r'GATC_y");
	addEnzyme("BstYI", "r'GATC_y");
	addEnzyme("BstZI", "C'GGCC_G");
	addEnzyme("BstZ17I", "GTA'TAC");
	addEnzyme("Bsu15I", "AT'CG_AT");
	addEnzyme("Bsu36I", "CC'TnA_GG");
	addEnzyme("BsuRI", "GG'CC");
	addEnzyme("BsuTUI", "AT'CG_AT");
	addEnzyme("BtgI", "C'CryG_G");
	addEnzyme("BthCI", "G_CnG'C");
	addEnzyme("BtrI", "CAC'GTC");
	addEnzyme("BtsI", "GCAGTG_nn'");
	addEnzyme("Cac8I", "GCn'nGC");
	addEnzyme("CaiI", "CAG_nnn'CTG");
	addEnzyme("CauII", "CC's_GG");
	addEnzyme("CciNI", "GC'GGCC_GC");
	addEnzyme("CdiI", "CATCG");
	addEnzyme("CelII", "GC'TnA_GC");
	addEnzyme("CfoI", "G_CG'C");
	addEnzyme("CfrI", "y'GGCC_r");
	addEnzyme("Cfr9I", "C'CCGG_G");
	addEnzyme("Cfr10I", "r'CCGG_y");
	addEnzyme("Cfr13I", "G'GnC_C");
	addEnzyme("Cfr42I", "CC_GC'GG");
	addEnzyme("ChaI", "_GATC'");
	addEnzyme("CjeI", "CCAnnnnnnGTnnnnnnnnn_nnnnnn'");
	addEnzyme("CjeI", "ACnnnnnnTGGnnnnnnnn_nnnnnn'");
	addEnzyme("CjePI", "CCAnnnnnnnTCnnnnnnnn_nnnnnn'");
	addEnzyme("CjePI", "GAnnnnnnnTGGnnnnnnn_nnnnnn'");
	addEnzyme("ClaI", "AT'CG_AT");
	addEnzyme("CpoI", "CG'GwC_CG");
	addEnzyme("CspI", "CG'GwC_CG");
	addEnzyme("Csp6I", "G'TA_C");
	addEnzyme("Csp45I", "TT'CG_AA");
	addEnzyme("CspAI", "A'CCGG_T");
	addEnzyme("CviAII", "C'AT_G");
	addEnzyme("CviJI", "rG'Cy");
	addEnzyme("CviRI", "TG'CA");
	addEnzyme("CviTI", "rG'Cy");
	addEnzyme("CvnI", "CC'TnA_GG");
	addEnzyme("DdeI", "C'TnA_G");
	addEnzyme("DpnI", "GA'TC");
	addEnzyme("DpnII", "'GATC_");
	addEnzyme("DraI", "TTT'AAA");
	addEnzyme("DraII", "rG'GnC_Cy");
	addEnzyme("DraIII", "CAC_nnn'GTG");
	addEnzyme("DrdI", "GACnn_nn'nnGTC");
	addEnzyme("DrdII", "GAACCA");
	addEnzyme("DsaI", "C'CryG_G");
	addEnzyme("DseDI", "GACnn_nn'nnGTC");
	addEnzyme("EaeI", "y'GGCC_r");
	addEnzyme("EagI", "C'GGCC_G");
	addEnzyme("Eam1104I", "CTCTTCn'nnn_");
	addEnzyme("Eam1105I", "GACnn_n'nnGTC");
	addEnzyme("EarI", "CTCTTCn'nnn_");
	addEnzyme("EciI", "GGCGGAnnnnnnnnn_nn'");
	addEnzyme("Ecl136II", "GAG'CTC");
	addEnzyme("EclHKI", "GACnn_n'nnGTC");
	addEnzyme("EclXI", "C'GGCC_G");
	addEnzyme("Eco24I", "G_rGCy'C");
	addEnzyme("Eco31I", "GGTCTCn'nnnn_");
	addEnzyme("Eco32I", "GAT'ATC");
	addEnzyme("Eco47I", "G'GwC_C");
	addEnzyme("Eco47III", "AGC'GCT");
	addEnzyme("Eco52I", "C'GGCC_G");
	addEnzyme("Eco57I", "CTGAAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("Eco72I", "CAC'GTG");
	addEnzyme("Eco81I", "CC'TnA_GG");
	addEnzyme("Eco88I", "C'yCGr_G");
	addEnzyme("Eco91I", "G'GTnAC_C");
	addEnzyme("Eco105I", "TAC'GTA");
	addEnzyme("Eco130I", "C'CwwG_G");
	addEnzyme("Eco147I", "AGG'CCT");
	addEnzyme("EcoHI", "'CCsGG_");
	addEnzyme("EcoICRI", "GAG'CTC");
	addEnzyme("Eco57MI", "CTGrAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("EcoNI", "CCTnn'n_nnAGG");
	addEnzyme("EcoO65I", "G'GTnAC_C");
	addEnzyme("EcoO109I", "rG'GnC_Cy");
	addEnzyme("EcoRI", "G'AATT_C");
	addEnzyme("EcoRII", "'CCwGG_");
	addEnzyme("EcoRV", "GAT'ATC");
	addEnzyme("EcoT14I", "C'CwwG_G");
	addEnzyme("EcoT22I", "A_TGCA'T");
	addEnzyme("EcoT38I", "G_rGCy'C");
	addEnzyme("EgeI", "GGC'GCC");
	addEnzyme("EheI", "GGC'GCC");
	addEnzyme("ErhI", "C'CwwG_G");
	addEnzyme("EsaBC3I", "TC'GA");
	addEnzyme("EspI", "GC'TnA_GC");
	addEnzyme("Esp3I", "CGTCTCn'nnnn_");
	addEnzyme("FalI", "AAGnnnnnCTTnnnnnnnn_nnnnn'");
	addEnzyme("FatI", "'CATG_");
	addEnzyme("FauI", "CCCGCnnnn'nn_");
	addEnzyme("FauNDI", "CA'TA_TG");
	addEnzyme("FbaI", "T'GATC_A");
	addEnzyme("FblI", "GT'mk_AC");
	addEnzyme("FinI", "GGGAC");
	addEnzyme("FmuI", "G_GnC'C");
	addEnzyme("FnuDII", "CG'CG");
	addEnzyme("Fnu4HI", "GC'n_GC");
	addEnzyme("FokI", "GGATGnnnnnnnnn'nnnn_");
	addEnzyme("FriOI", "G_rGCy'C");
	addEnzyme("FseI", "GG_CCGG'CC");
	addEnzyme("FspI", "TGC'GCA");
	addEnzyme("FspAI", "rTGC'GCAy");
	addEnzyme("Fsp4HI", "GC'n_GC");
	addEnzyme("FunI", "AGC'GCT");
	addEnzyme("FunII", "G'AATT_C");
	addEnzyme("GdiII", "C'GGCC_r");
	addEnzyme("GsuI", "CTGGAGnnnnnnnnnnnnnn_nn'");
	addEnzyme("HaeI", "wGG'CCw");
	addEnzyme("HaeII", "r_GCGC'y");
	addEnzyme("HaeIII", "GG'CC");
	addEnzyme("HaeIV", "GAynnnnnrTCnnnnnnnnn_nnnnn'");
	addEnzyme("HaeIV", "GAynnnnnrTCnnnnnnn_nnnnnn'");
	addEnzyme("HapII", "C'CG_G");
	addEnzyme("HgaI", "GACGCnnnnn'nnnnn_");
	addEnzyme("HgiAI", "G_wGCw'C");
	addEnzyme("HgiCI", "G'GyrC_C");
	addEnzyme("HgiEII", "ACCnnnnnnGGT");
	addEnzyme("HgiJII", "G_rGCy'C");
	addEnzyme("HhaI", "G_CG'C");
	addEnzyme("Hin1I", "Gr'CG_yC");
	addEnzyme("Hin4I", "GAynnnnnvTCnnnnnnnn_nnnnn'");
	addEnzyme("Hin4I", "GAbnnnnnrTCnnnnnnnn_nnnnn'");
	addEnzyme("Hin4II", "CCTTC");
	addEnzyme("Hin6I", "G'CG_C");
	addEnzyme("HinP1I", "G'CG_C");
	addEnzyme("HincII", "GTy'rAC");
	addEnzyme("HindII", "GTy'rAC");
	addEnzyme("HindIII", "A'AGCT_T");
	addEnzyme("HinfI", "G'AnT_C");
	addEnzyme("HpaI", "GTT'AAC");
	addEnzyme("HpaII", "C'CG_G");
	addEnzyme("HphI", "GGTGAnnnnnnn_n'");
	addEnzyme("Hpy8I", "GTn'nAC");
	addEnzyme("Hpy99I", "_CGwCG'");
	addEnzyme("Hpy178III", "TC'nn_GA");
	addEnzyme("Hpy188I", "TC_n'GA");
	addEnzyme("Hpy188III", "TC'nn_GA");
	addEnzyme("HpyAV", "CCTTCnnnnn_n'");
	addEnzyme("HpyCH4I", "C_AT'G");
	addEnzyme("HpyCH4III", "AC_n'GT");
	addEnzyme("HpyCH4IV", "A'CG_T");
	addEnzyme("HpyCH4V", "TG'CA");
	addEnzyme("HpyF10VI", "GCn_nnnnn'nGC");
	addEnzyme("Hsp92I", "Gr'CG_yC");
	addEnzyme("Hsp92II", "_CATG'");
	addEnzyme("HspAI", "G'CG_C");
	addEnzyme("ItaI", "GC'n_GC");
	addEnzyme("KasI", "G'GCGC_C");
	addEnzyme("KpnI", "G_GTAC'C");
	addEnzyme("Kpn2I", "T'CCGG_A");
	addEnzyme("KspI", "CC_GC'GG");
	addEnzyme("Ksp22I", "T'GATC_A");
	addEnzyme("Ksp632I", "CTCTTCn'nnn_");
	addEnzyme("KspAI", "GTT'AAC");
	addEnzyme("Kzo9I", "'GATC_");
	addEnzyme("LpnI", "rGC'GCy");
	addEnzyme("LweI", "GCATCnnnnn'nnnn_");
	addEnzyme("MabI", "A'CCwGG_T");
	addEnzyme("MaeI", "C'TA_G");
	addEnzyme("MaeII", "A'CG_T");
	addEnzyme("MaeIII", "'GTnAC_");
	addEnzyme("MamI", "GATnn'nnATC");
	addEnzyme("MbiI", "CCG'CTC");
	addEnzyme("MboI", "'GATC_");
	addEnzyme("MboII", "GAAGAnnnnnnn_n'");
	addEnzyme("McrI", "CG_ry'CG");
	addEnzyme("MfeI", "C'AATT_G");
	addEnzyme("MflI", "r'GATC_y");
	addEnzyme("MhlI", "G_dGCh'C");
	addEnzyme("MjaIV", "GTnnAC");
	addEnzyme("MlsI", "TGG'CCA");
	addEnzyme("MluI", "A'CGCG_T");
	addEnzyme("MluNI", "TGG'CCA");
	addEnzyme("MlyI", "GAGTCnnnnn'");
	addEnzyme("Mly113I", "GG'CG_CC");
	addEnzyme("MmeI", "TCCrACnnnnnnnnnnnnnnnnnn_nn'");
	addEnzyme("MnlI", "CCTCnnnnnn_n'");
	addEnzyme("Mph1103I", "A_TGCA'T");
	addEnzyme("MroI", "T'CCGG_A");
	addEnzyme("MroNI", "G'CCGG_C");
	addEnzyme("MroXI", "GAAnn'nnTTC");
	addEnzyme("MscI", "TGG'CCA");
	addEnzyme("MseI", "T'TA_A");
	addEnzyme("MslI", "CAynn'nnrTG");
	addEnzyme("MspI", "C'CG_G");
	addEnzyme("Msp20I", "TGG'CCA");
	addEnzyme("MspA1I", "CmG'CkG");
	addEnzyme("MspCI", "C'TTAA_G");
	addEnzyme("MspR9I", "CC'n_GG");
	addEnzyme("MssI", "GTTT'AAAC");
	addEnzyme("MstI", "TGC'GCA");
	addEnzyme("MunI", "C'AATT_G");
	addEnzyme("MvaI", "CC'w_GG");
	addEnzyme("Mva1269I", "GAATG_Cn'");
	addEnzyme("MvnI", "CG'CG");
	addEnzyme("MwoI", "GCnn_nnn'nnGC");
	addEnzyme("NaeI", "GCC'GGC");
	addEnzyme("NarI", "GG'CG_CC");
	addEnzyme("NciI", "CC's_GG");
	addEnzyme("NcoI", "C'CATG_G");
	addEnzyme("NdeI", "CA'TA_TG");
	addEnzyme("NdeII", "'GATC_");
	addEnzyme("NgoAIV", "G'CCGG_C");
	addEnzyme("NgoMIV", "G'CCGG_C");
	addEnzyme("NheI", "G'CTAG_C");
	addEnzyme("NlaIII", "_CATG'");
	addEnzyme("NlaIV", "GGn'nCC");
	addEnzyme("Nli3877I", "C_yCGr'G");
	addEnzyme("NmuCI", "'GTsAC_");
	addEnzyme("NotI", "GC'GGCC_GC");
	addEnzyme("NruI", "TCG'CGA");
	addEnzyme("NruGI", "GACnn_n'nnGTC");
	addEnzyme("NsbI", "TGC'GCA");
	addEnzyme("NsiI", "A_TGCA'T");
	addEnzyme("NspI", "r_CATG'y");
	addEnzyme("NspIII", "C'yCGr_G");
	addEnzyme("NspV", "TT'CG_AA");
	addEnzyme("NspBII", "CmG'CkG");
	addEnzyme("OliI", "CACnn'nnGTG");
	addEnzyme("PacI", "TTA_AT'TAA");
	addEnzyme("PaeI", "G_CATG'C");
	addEnzyme("PaeR7I", "C'TCGA_G");
	addEnzyme("PagI", "T'CATG_A");
	addEnzyme("PalI", "GG'CC");
	addEnzyme("PauI", "G'CGCG_C");
	addEnzyme("PceI", "AGG'CCT");
	addEnzyme("PciI", "A'CATG_T");
	addEnzyme("PctI", "GAATG_Cn'");
	addEnzyme("PdiI", "GCC'GGC");
	addEnzyme("PdmI", "GAAnn'nnTTC");
	addEnzyme("Pfl23II", "C'GTAC_G");
	addEnzyme("Pfl1108I", "TCGTAG");
	addEnzyme("PflBI", "CCAn_nnn'nTGG");
	addEnzyme("PflFI", "GACn'n_nGTC");
	addEnzyme("PflMI", "CCAn_nnn'nTGG");
	addEnzyme("PfoI", "T'CCnGG_A");
	addEnzyme("PinAI", "A'CCGG_T");
	addEnzyme("PleI", "GAGTCnnnn'n_");
	addEnzyme("Ple19I", "CG_AT'CG");
	addEnzyme("PmaCI", "CAC'GTG");
	addEnzyme("PmeI", "GTTT'AAAC");
	addEnzyme("PmlI", "CAC'GTG");
	addEnzyme("PpiI", "GAACnnnnnCTCnnnnnnnn_nnnnn'");
	addEnzyme("PpiI", "GAGnnnnnGTTCnnnnnnn_nnnnn'");
	addEnzyme("PpsI", "GAGTCnnnn'n_");
	addEnzyme("Ppu10I", "A'TGCA_T");
	addEnzyme("PpuMI", "rG'GwC_Cy");
	addEnzyme("PpuXI", "rG'GwC_Cy");
	addEnzyme("PshAI", "GACnn'nnGTC");
	addEnzyme("PshBI", "AT'TA_AT");
	addEnzyme("PsiI", "TTA'TAA");
	addEnzyme("Psp03I", "G_GwC'C");
	addEnzyme("Psp5II", "rG'GwC_Cy");
	addEnzyme("Psp6I", "'CCwGG_");
	addEnzyme("Psp1406I", "AA'CG_TT");
	addEnzyme("PspAI", "C'CCGG_G");
	addEnzyme("Psp124BI", "G_AGCT'C");
	addEnzyme("PspEI", "G'GTnAC_C");
	addEnzyme("PspGI", "'CCwGG_");
	addEnzyme("PspLI", "C'GTAC_G");
	addEnzyme("PspN4I", "GGn'nCC");
	addEnzyme("PspOMI", "G'GGCC_C");
	addEnzyme("PspPI", "G'GnC_C");
	addEnzyme("PspPPI", "rG'GwC_Cy");
	addEnzyme("PsrI", "GAACnnnnnnTACnnnnnnn_nnnnn'");
	addEnzyme("PsrI", "GTAnnnnnnGTTCnnnnnnn_nnnnn'");
	addEnzyme("PssI", "rG_GnC'Cy");
	addEnzyme("PstI", "C_TGCA'G");
	addEnzyme("PsuI", "r'GATC_y");
	addEnzyme("PsyI", "GACn'n_nGTC");
	addEnzyme("PvuI", "CG_AT'CG");
	addEnzyme("PvuII", "CAG'CTG");
	addEnzyme("RcaI", "T'CATG_A");
	addEnzyme("RleAI", "CCCACAnnnnnnnnn_nnn'");
	addEnzyme("RsaI", "GT'AC");
	addEnzyme("RsrII", "CG'GwC_CG");
	addEnzyme("Rsr2I", "CG'GwC_CG");
	addEnzyme("SacI", "G_AGCT'C");
	addEnzyme("SacII", "CC_GC'GG");
	addEnzyme("SalI", "G'TCGA_C");
	addEnzyme("SanDI", "GG'GwC_CC");
	addEnzyme("SapI", "GCTCTTCn'nnn_");
	addEnzyme("SatI", "GC'n_GC");
	addEnzyme("SauI", "CC'TnA_GG");
	addEnzyme("Sau96I", "G'GnC_C");
	addEnzyme("Sau3AI", "'GATC_");
	addEnzyme("SbfI", "CC_TGCA'GG");
	addEnzyme("ScaI", "AGT'ACT");
	addEnzyme("SchI", "GAGTCnnnnn'");
	addEnzyme("SciI", "CTC'GAG");
	addEnzyme("ScrFI", "CC'n_GG");
	addEnzyme("SdaI", "CC_TGCA'GG");
	addEnzyme("SduI", "G_dGCh'C");
	addEnzyme("SecI", "C'CnnG_G");
	addEnzyme("SelI", "'CGCG_");
	addEnzyme("SexAI", "A'CCwGG_T");
	addEnzyme("SfaNI", "GCATCnnnnn'nnnn_");
	addEnzyme("SfcI", "C'TryA_G");
	addEnzyme("SfeI", "C'TryA_G");
	addEnzyme("SfiI", "GGCCn_nnn'nGGCC");
	addEnzyme("SfoI", "GGC'GCC");
	addEnzyme("Sfr274I", "C'TCGA_G");
	addEnzyme("Sfr303I", "CC_GC'GG");
	addEnzyme("SfuI", "TT'CG_AA");
	addEnzyme("SgfI", "GCG_AT'CGC");
	addEnzyme("SgrAI", "Cr'CCGG_yG");
	addEnzyme("SgrBI", "CC_GC'GG");
	addEnzyme("SimI", "GG'GTC_");
	addEnzyme("SinI", "G'GwC_C");
	addEnzyme("SlaI", "C'TCGA_G");
	addEnzyme("SmaI", "CCC'GGG");
	addEnzyme("SmiI", "ATTT'AAAT");
	addEnzyme("SmiMI", "CAynn'nnrTG");
	addEnzyme("SmlI", "C'TyrA_G");
	addEnzyme("SmuI", "CCCGCnnnn'nn_");
	addEnzyme("SnaI", "GTATAC");
	addEnzyme("SnaBI", "TAC'GTA");
	addEnzyme("SpaHI", "G_CATG'C");
	addEnzyme("SpeI", "A'CTAG_T");
	addEnzyme("SphI", "G_CATG'C");
	addEnzyme("SplI", "C'GTAC_G");
	addEnzyme("SrfI", "GCCC'GGGC");
	addEnzyme("Sse9I", "'AATT_");
	addEnzyme("Sse232I", "CG'CCGG_CG");
	addEnzyme("Sse8387I", "CC_TGCA'GG");
	addEnzyme("Sse8647I", "AG'GwC_CT");
	addEnzyme("SseBI", "AGG'CCT");
	addEnzyme("SspI", "AAT'ATT");
	addEnzyme("SspBI", "T'GTAC_A");
	addEnzyme("SspD5I", "GGTGAnnnnnnnn'");
	addEnzyme("SstI", "G_AGCT'C");
	addEnzyme("SstII", "CC_GC'GG");
	addEnzyme("Sth132I", "CCCGnnnn'nnnn_");
	addEnzyme("StsI", "GGATGnnnnnnnnnn'nnnn_");
	addEnzyme("StuI", "AGG'CCT");
	addEnzyme("StyI", "C'CwwG_G");
	addEnzyme("StyD4I", "'CCnGG_");
	addEnzyme("SunI", "C'GTAC_G");
	addEnzyme("SwaI", "ATTT'AAAT");
	addEnzyme("TaaI", "AC_n'GT");
	addEnzyme("TaiI", "_ACGT'");
	addEnzyme("TaqI", "T'CG_A");
	addEnzyme("TaqII", "GACCGAnnnnnnnnn_nn'");
	addEnzyme("TaqII", "CACCCAnnnnnnnnn_nn'");
	addEnzyme("TasI", "'AATT_");
	addEnzyme("TatI", "w'GTAC_w");
	addEnzyme("TauI", "G_CsG'C");
	addEnzyme("TelI", "GACn'n_nGTC");
	addEnzyme("TfiI", "G'AwT_C");
	addEnzyme("ThaI", "CG'CG");
	addEnzyme("TliI", "C'TCGA_G");
	addEnzyme("Tru1I", "T'TA_A");
	addEnzyme("Tru9I", "T'TA_A");
	addEnzyme("TscI", "_ACGT'");
	addEnzyme("TseI", "G'CwG_C");
	addEnzyme("Tsp45I", "'GTsAC_");
	addEnzyme("Tsp509I", "'AATT_");
	addEnzyme("Tsp4CI", "AC_n'GT");
	addEnzyme("TspDTI", "ATGAAnnnnnnnnn_nn'");
	addEnzyme("TspEI", "'AATT_");
	addEnzyme("TspGWI", "ACGGAnnnnnnnnn_nn'");
	addEnzyme("TspRI", "_nnCAsTGnn'");
	addEnzyme("Tth111I", "GACn'n_nGTC");
	addEnzyme("Tth111II", "CAArCAnnnnnnnnn_nn'");
	addEnzyme("TthHB8I", "T'CG_A");
	addEnzyme("UbaHI", "GCAnnnnnnTGC");
	addEnzyme("UbaPI", "CGAACG");
	addEnzyme("UnbI", "'GGnCC_");
	addEnzyme("Van91I", "CCAn_nnn'nTGG");
	addEnzyme("Vha464I", "C'TTAA_G");
	addEnzyme("VneI", "G'TGCA_C");
	addEnzyme("VpaK11AI", "'GGwCC_");
	addEnzyme("VpaK11BI", "G'GwC_C");
	addEnzyme("VspI", "AT'TA_AT");
	addEnzyme("XagI", "CCTnn'n_nnAGG");
	addEnzyme("XapI", "r'AATT_y");
	addEnzyme("XbaI", "T'CTAG_A");
	addEnzyme("XceI", "r_CATG'y");
	addEnzyme("XcmI", "CCAnnnn_n'nnnnTGG");
	addEnzyme("XhoI", "C'TCGA_G");
	addEnzyme("XhoII", "r'GATC_y");
	addEnzyme("XmaI", "C'CCGG_G");
	addEnzyme("XmaIII", "C'GGCC_G");
	addEnzyme("XmaCI", "C'CCGG_G");
	addEnzyme("XmaJI", "C'CTAG_G");
	addEnzyme("XmiI", "GT'mk_AC");
	addEnzyme("XmnI", "GAAnn'nnTTC");
	addEnzyme("XspI", "C'TA_G");
	addEnzyme("ZhoI", "AT'CG_AT");
	addEnzyme("ZraI", "GAC'GTC");
	addEnzyme("Zsp2I", "A_TGCA'T");
?>