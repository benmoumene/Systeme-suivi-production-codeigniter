<?php
$cut_tracking_no = $_GET['cut_tracking_no'];

require_once('comon_pts.php');
require_once('comon.php');

$datex = new DateTime(date('H:i:s'));
$datex->modify('+18000 seconds');
$date_time=$datex->format('Y-m-d H:i:s');

$cut_tracking_no = $_GET['cut_tracking_no'];


// Include the main TCPDF library (search for installation path).
require_once('bcps/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('dejavusans', '', 10);


$SQL="SELECT * FROM efl_db_pts.`tb_bundle_cut_detail` WHERE cut_tracking_no='%$cut_tracking_no%'";    //table name
$result = $obj_pts->sql_pts($SQL);

while($row = mysql_fetch_array($result))
{
    $pc_tracking_no = $row['pc_tracking_no'];
    $purchase_order = $row['purchase_order'];
    $item = $row['item'];
    $quality = $row['quality'];
    $style_no = $row['style_no'];
    $style_name = $row['style_name'];
    $brand = $row['brand'];
    $size = $row['size'];
    $cut_no = $row['cut_no'];
    $cut_tracking_no = $row['cut_tracking_no'];
    $bundle_no = $row['bundle_no'];
    $bundle_tracking_no = $row['bundle_tracking_no'];
    $bundle_range = $row['bundle_range'];

//    echo '<pre>';
//    print_r($pc_tracking_no);
//    echo '</pre>';

// add a page
    $pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content

    $html = '
<div id="result" style="margin-left: 5px; width: 120px; height: 540px;">
<p>'.$pc_tracking_no.'</p>
<p>B PO:'.$po_no.'</p>
<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $pc_tracking_no .'" title="QR Code Image!"></center>
Some special characters: &lt; € &euro; &#8364; &amp; è &egrave; &copy; &gt;
<h2>List</h2>
</div>';

// output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

}
// reset pointer to the last page
$pdf->lastPage();

// Print some HTML Cells
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Generated Care Labels.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>