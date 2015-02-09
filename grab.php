<?php

   //$s = file_get_contents("http://www.ncbi.nlm.nih.gov/nuccore/242390096?report=fasta");
   //$s = file_get_contents("ftp://ftp.ncbi.nih.gov/genomes/ASSEMBLY_BACTERIA/Streptococcus_thermophilus/GCF_000011825/NC_006448.fna");
   $s = file_get_contents("http://www.ncbi.nlm.nih.gov/sviewer/viewer.fcgi?tool=portal&sendto=on&log$=seqview&db=nuccore&dopt=fasta&val=24182471&extrafeat=0&maxplex=1");
   echo "<html>\n";
   echo "<body>\n";
   
   echo " <h2> OK, we are seeing if we can get the data from a FASTA page at NCBI. </h2> \n";
   
   echo "length of raw file content string = ".strlen($s)."<br>\n";
   
   $s2 = stristr( $s, "complete cds" );
   echo "length past \"complete cds\" = ".strlen($s2)."<br>\n";
   //$s2 = stristr( $s, "AGTCTG" );
   //echo "length past \"AGTCTG\" = ".strlen($s2)."<br>\n";
   
   //$s3 = stristr( $s2, "TTTAGCTTGTTGAT", true );
   
   //echo "length of genome sort of = ".strlen($s3)."<br>\n";
   
   echo "yikes ".$s2." yikes\n";
   
   echo "</body>\n";
   echo "</html>\n";
?>

