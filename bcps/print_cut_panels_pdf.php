<?php
//============================================================+
// File name   : example_002.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 002 for TCPDF class
//               Removing Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

include "db_Class.php";
$obj = new db_class();
$obj->MySQL();


// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

class MYPDF extends TCPDF {

	//Page header
	/*public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo_example.jpg';
		//$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', '', 10);
		// Title
		$this->Cell(0, 5, 'Solid Part', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}*/

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-8);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		//$this->Cell(0, 1, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, '', 'M');
		
		//$this->Cell(10, 5, 'Solid Part', 0, false, 'L');
//$this->MultiCell(31, 4.5, 'Solid Part', 0, 'L', 0, 0, 50, 60, true, 0, false, true, 4.5, 'L', true);
$this->MultiCell(31, 4.5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 'L', 0, 0, 190, 289, true, 0, false, true, 4.5, 'L', true);
$this->MultiCell(31, 4.5, 'Solid Part', 0, 'L', 0, 0, 10, 289, true, 0, false, true, 4.5, 'L', true);
		
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// ---------------------------------------------------------

// set font
//$pdf->SetFont('times', 'BI', 10);
//$pdf->SetFont('times', '', 9);

// add a page
// $pdf->AddPage();

// set cell padding
//$pdf->setCellPaddings(1, 0, 0, 0);


// set some text to print
	/*$txt = <<<EOD
	Test By Liza
	EOD;*/
// print a block of text using Write()
	//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
	
		$date = new DateTime(null, new DateTimeZone('ASIA/Dhaka'));
		$date->modify('-3600 seconds');
		$date=$date->format("m-d-Y");
		// $datex=$datex->format("d-m-Y H:i:s");
		//$print_date = date('l, j-F-Y');
		
		$print_date = date('j-M-Y');
		
		$pf=$_GET['pf'];
		
		if($pf == '')
			{
				  $pf=$_POST['print_flag'];		
				  $decd_CutID=$_POST['cid'];
			  
				  $cnt = 1;
				  
				  /*$rowz = 0;
				  foreach($_POST['checkbox'] as $rowz=>$checkbox)
				  { $size_info[$cnt] = $_POST['size_info'][$rowz] ; $cnt = $cnt+1 ; $rowz ++ ;}*/
				  
				  foreach($_POST['size_info'] as $rowz=>$s_info)
				  { $size_info[$cnt] = $s_info ; $cnt = $cnt+1 ;
				  
				  //echo $s_info.'~';
				   }

				  
				  $size_infom = '';
				  for($i = 1; $i < $cnt; $i++)
				  {
					if($i == $cnt-1) { $size_infom .= "'".$size_info[$i]."'" ; }
					else { $size_infom .= "'".$size_info[$i]."', " ; }  
				  }
				  
	$SQL = "SELECT T0.PartName, T0.BundleNo, T0.RollNo, T0.Suff, T0.LotNo, T0.BundleRange, T0.Qty, T1.AutoCutID, T1.buyer, T1.StyleCode, T1.Color, T1.CutNo, T1.OrderNo FROM tb_vsfs_bundle_info T0 LEFT JOIN tb_vsfs_cut_info T1 ON T1.AutoCutID = T0.CutID WHERE T1.AutoCutID = '$decd_CutID' AND T0.print_flag = '$pf' AND T0.Suff IN (".$size_infom.") ORDER BY AutoBundleID ASC";
			 }
		else
		{
			$decd_CutID = base64_decode($_GET['cid']);
			$SQL = "SELECT T0.PartName, T0.BundleNo, T0.RollNo, T0.Suff, T0.LotNo, T0.BundleRange, T0.Qty, T1.AutoCutID, T1.buyer, T1.StyleCode, T1.Color, T1.CutNo, T1.OrderNo FROM tb_vsfs_bundle_info T0 LEFT JOIN tb_vsfs_cut_info T1 ON T1.AutoCutID = T0.CutID WHERE T1.AutoCutID = '$decd_CutID' AND T0.print_flag = '$pf' ORDER BY AutoBundleID ASC";
		}
		
	// die($SQL);
		
	$srl = 1;
	// The Query is defined above.
	
	// die($SQL);
		
	$results = $obj->sql($SQL);
    $num_rows=mysql_num_rows($results);
          while($row = mysql_fetch_array($results))
          { 
		  
		  $PartName[] = $row['PartName'];
		  $BundleNo[] = $row['BundleNo'];
		  $RollNo[] = $row['RollNo'];
		  $Suff[] = $row['Suff'];
		  $LotNo[] = $row['LotNo'];
		  $BundleRange[] = $row['BundleRange'];
		  $Qty[] = $row['Qty'];

		  $AutoCutID[] = $row['AutoCutID'];
		  $buyer[] = $row['buyer'];
		  $StyleCode[] = $row['StyleCode'];
		  $Color[] = $row['Color'];
		  $CutNo[] = $row['CutNo'];
		  $OrderNo[] = $row['OrderNo'];
		  
		  }		
			

$line = '_______________________________________________________';
//$line = '__________________________________________________________';
$dash = '---------------------------------------------------------------------------';
// output the HTML content

/*$x1 = 5;
$x2 = 25;*/
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// 		  <td>Qty: '.$Qty[$j].' / '.$PartName[$j].'</td>

	// $num_rows = 50;
	$pblnce = $num_rows;
	$div2 = 1; // it is for Track wether the 2nd div is requires to proceed or not.
	$ttl_page = ceil($num_rows/22);
	$prange = 11;
	$start = 0;
	for($i=1; $i<=$ttl_page; $i++)
	{
		
		$top = 0.2;
		$left = 4;
		$right = 26; 		
		
$pdf->AddPage();

		if($pblnce < 11) {$prange = $start+$pblnce; $div2 = 0;}
			else { $pblnce = $pblnce-11; }
			
			
			for($j=$start; $j<$prange; $j++) {
				
				$pdf->SetFont('times', '', 9);

$marge_head='P. DT. '.$print_date.'&nbsp;&nbsp;&nbsp;&nbsp;Buyer: <strong>'.$buyer[$j].'</strong> &nbsp;&nbsp;&nbsp;&nbsp;VIYELLATEX LTD.';

$style2 = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));

$pdf->writeHTMLCell(92, 0, 0.2, $top, $line, 0, 1, 0, true, '', true);
//$pdf->writeHTMLCell(90, 0, 1.2, $top, $marge_head, 0, 1, 0, true, '', true);


$top = $top+4;
	$pdf->MultiCell(25, 4.5, 'P. DT. '.$print_date, 0, 'L', 0, 0, 1.2, $top, true, 0, false, true, 4.5, 'L', true);
	
	$pdf->SetFont('times', 'B', 9);
	$pdf->MultiCell(35, 4.5, 'Buyer: '.$buyer[$j], 0, 'L', 0, 0, 34, $top, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(32, 4.5, 'Size: '.$Suff[$j], 0, 'L', 0, 0, 64.5, $top, true, 0, false, true, 4.5, 'L', true);

$top = $top+4.3;
	$pdf->MultiCell(35, 4.5, $PartName[$j], 0, 'L', 0, 0, 1.2, $top, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(25, 4.5, 'Bundle No: '.$BundleNo[$j], 0, 'L', 0, 0, 34, $top, true, 0, false, true, 4.5, 'L', true);
	
	$pdf->SetFont('times', '', 9);
	$pdf->MultiCell(32, 4.5, 'Gmt: '.$BundleRange[$j], 0, 'L', 0, 0, 64.5, $top, true, 0, false, true, 4.5, 'L', true);

	$pdf->SetFont('times', 'B', 9);
$top = $top+4.3;
	$pdf->MultiCell(67, 4.5, 'Style: '.$StyleCode[$j], 0, 'L', 0, 0, 1.2, $top, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(25, 4.5, 'Qty: '.$Qty[$j], 0, 'L', 0, 0, 64.5, $top, true, 0, false, true, 4.5, 'L', true);


$top = $top+4.3;
	$pdf->MultiCell(35, 4.5, 'Lot No: '.$LotNo[$j].'/ R - '.$RollNo[$j], 0, 'L', 0, 0, 1.2, $top, true, 0, false, true, 4.5, 'L', true);
	$pdf->SetFont('times', '', 9);
	$pdf->MultiCell(57, 4.5, 'Clr: '.$Color[$j], 0, 'L', 0, 0, 34, $top, true, 0, false, true, 4.5, 'L', true);


$top = $top+4.3;
	$pdf->MultiCell(35, 4.5, 'A.CutID: '.$AutoCutID[$j], 0, 'L', 0, 0, 1.2, $top, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(32, 4.5, 'Ordr No: '.$OrderNo[$j], 0, 'L', 0, 0, 34, $top, true, 0, false, true, 4.5, 'L', true);
	
	$pdf->SetFont('times', 'B', 9);
	$pdf->MultiCell(25, 4.5, 'Cut No: '.$CutNo[$j], 0, 'L', 0, 0, 64.5, $top, true, 0, false, true, 4.5, 'L', true);


$top = $top+1;
	$pdf->writeHTMLCell(92, 0, 0.2, $top, $line, 0, 1, 0, true, '', true);

if($j+1 != $prange) {
$top = $top+3;
	$pdf->writeHTMLCell(92, 0, 5, $top, $dash, 0, 1, 0, true, '', true);
}
	

$top = $top+1; // It is for starting of next new line of next Table.
	$pdf->Line(1.2, $left, 1.2, $right, $style2);
	$pdf->Line(88.4, $left, 88.4, $right, $style2);
	
$left = $right+4;
$right = $left+22.2;
				
				
				} $start = $prange; $prange = $prange+11;
			
	if($div2 != 0) { 
	
		$top2 = 0.2;
		$left = 4;
		$right = 26; 



		if($pblnce < 11) {$prange = $start+$pblnce;}
			else { $pblnce = $pblnce-11; }

			for($j=$start; $j<$prange; $j++) {
				
				$pdf->SetFont('times', '', 9);

	$pdf->writeHTMLCell(92, 0, 109, $top2, $line, 0, 1, 0, true, '', true);
	//$pdf->writeHTMLCell(90, 0, 110, $top2, $marge_head, 0, 1, 0, true, '', true);
	


$top2 = $top2+4;
	$pdf->MultiCell(25, 4.5, 'P. DT. '.$print_date, 0, 'L', 0, 0, 110, $top2, true, 0, false, true, 4.5, 'L', true);
	
	$pdf->SetFont('times', 'B', 9);
	$pdf->MultiCell(35, 4.5, 'Buyer: '.$buyer[$j], 0, 'L', 0, 0, 142.8, $top2, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(32, 4.5, 'Size: '.$Suff[$j], 0, 'L', 0, 0, 173.3, $top2, true, 0, false, true, 4.5, 'L', true);

$top2 = $top2+4.3;
	$pdf->MultiCell(35, 4.5, $PartName[$j], 0, 'L', 0, 0, 110, $top2, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(25, 4.5, 'Bundle No: '.$BundleNo[$j], 0, 'L', 0, 0, 142.8, $top2, true, 0, false, true, 4.5, 'L', true);
	
	$pdf->SetFont('times', '', 9);
	$pdf->MultiCell(32, 4.5, 'Gmt: '.$BundleRange[$j], 0, 'L', 0, 0, 173.3, $top2, true, 0, false, true, 4.5, 'L', true);

	$pdf->SetFont('times', 'B', 9);
$top2 = $top2+4.3;
	$pdf->MultiCell(67, 4.5, 'Style: '.$StyleCode[$j], 0, 'L', 0, 0, 110, $top2, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(25, 4.5, 'Qty: '.$Qty[$j], 0, 'L', 0, 0, 173.3, $top2, true, 0, false, true, 4.5, 'L', true);


$top2 = $top2+4.3;
	$pdf->MultiCell(35, 4.5, 'Lot No: '.$LotNo[$j].'/ R - '.$RollNo[$j], 0, 'L', 0, 0, 110, $top2, true, 0, false, true, 4.5, 'L', true);
	$pdf->SetFont('times', '', 9);
	$pdf->MultiCell(57, 4.5, 'Clr: '.$Color[$j], 0, 'L', 0, 0, 142.8, $top2, true, 0, false, true, 4.5, 'L', true);


$top2 = $top2+4.3;
	$pdf->MultiCell(35, 4.5, 'A.CutID: '.$AutoCutID[$j], 0, 'L', 0, 0, 110, $top2, true, 0, false, true, 4.5, 'L', true);
	$pdf->MultiCell(32, 4.5, 'Ordr No: '.$OrderNo[$j], 0, 'L', 0, 0, 142.8, $top2, true, 0, false, true, 4.5, 'L', true);
	
	$pdf->SetFont('times', 'B', 9);
	$pdf->MultiCell(25, 4.5, 'Cut No: '.$CutNo[$j], 0, 'L', 0, 0, 173.3, $top2, true, 0, false, true, 4.5, 'L', true);


$top2 = $top2+1;
	$pdf->writeHTMLCell(92, 0, 109, $top2, $line, 0, 1, 0, true, '', true);

if($j+1 != $prange) {
$top2 = $top2+3;
	$pdf->writeHTMLCell(92, 0, 112, $top2, $dash, 0, 1, 0, true, '', true);
}

$top2 = $top2+1; // It is for starting of next new line of next Table.
	
	$pdf->Line(110, $left, 110, $right, $style2);
	$pdf->Line(197.4, $left, 197.4, $right, $style2);
	
	
$left = $right+4;
$right = $left+22.2;
				
				
				} $start = $prange; $prange = $prange+11; 
			
	}

//$pdf->Ln(8);
$pdf->lastPage();



	}


//Close and output PDF document
$pdf->Output('print_cut_panels.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
