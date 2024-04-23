<?php

// Include the main TCPDF library (search for installation path).
require_once(APPROOT.'/TCPDF/tcpdf.php');
// if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Background
        $background = APPROOT.'/helpers/prescription_background.jpg';
        $this->Image($background, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        $logo = 'logo.png';
        $this->Image($logo, 10, 10, 30, '', 'PNG', '', '', false, 300, '', false, false, 0);
        
        
        $this->SetFont('helvetica', 'B', 20);
        $this->SetTextColor(14, 14, 83);
        $this->Ln(40);
        $this->Cell(0, 19, 'Dr. Tony Stark', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', '', 12);
        $this->SetTextColor(14, 14, 83);
        $this->Ln(7); // Move down a bit
        $this->Cell(0, 10, 'Cardiologist', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', '', 11);
        $this->SetTextColor(14, 14, 83);
        $this->Ln(7); // Move down a bit
        $this->Cell(0, 10, 'SLMC No: 123456', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetAlpha(.1);

        
        // $this->Image($image_file, 60, 100, 100, 100, "watermark", '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
// if($is_encrypted == 1)
// $pdf->SetProtection(array('print', 'copy', 'read'), $password, null, 0, null);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HealthWave');
$pdf->SetTitle((isset($fullname) ? $fullname : "").'- Digital Prescription');
$pdf->SetSubject('Generated Digital Prescription');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, 50, '', '');

// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
$pdf->setImageScale(2.5);


// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 13);



// add a page
$pdf->AddPage();

$style = array(
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);


$pdf->write2DBarcode('www.tcpdf.org', 'QRCODE,L', 150, 220, 50, 50, $style, 'N');

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
ob_start();
?>
<br>
<br><br><br><br><br><br><br><br><br><br><br><br>

<div>
    <table>
        
        <tr >
            <td width="25%"><span> </span></td>
            <td width="35%"><span><?= $data['Name']?></span></td>
            <td width="15%"><span> </span></td>
            <td width="25%"><span style="border:1px"><?= $data['Date']?></span></td>
        </tr>
    </table>
    <table>
        <tr>
            <td><span> </span></td>
            <td colspan="3"><span style="border:1px"></span></td>
        </tr>
        <tr>
            <td width="22%"><span> </span></td>
            <td width="28%"><span style="border:1px"><?= $data['NIC']?></span></td>
            <td width="23%"><span>&nbsp;&nbsp;&nbsp;&nbsp;23 </span></td>
            <td width="27%"><span style="border:1px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $data['Gender']?></span></td>
        </tr>
    </table>
    <table>
        <br><br>
        <tr>
            <td width="19%"><span></span></td>
            <td width="75%"><span style="border:1px"> <?= !empty($data['Allergies']) ? $data['Allergies'] : " None " ?></span></td>
        </tr>
        <tr>
            <td width="19%"><span></span></td>
            <td width="75%"><span style="border:1px"><br><?= $data['Diagnosis']?></span></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table cellpadding="2">
        <tr>
            <td width="100%"><span></span></td>
        </tr>
        <tr>
            <td colspan="3"><span style="border:1px"></span></td>
        </tr>
    </table>
    
    <br>
    <hr>
    <br>
    <table cellpadding="2">
        <tr>
            <td width="100%"><span></span></td>
        </tr>
        <tr>
            
            <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I the undersigned, Doctor of Medicine</td>
        </tr>
    </table>
    
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table cellpadding="2">
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dr. <?= $data['Doc_Name']?></td>
        </tr>

    </table>    

</div>
<table width="100%" style="table-collapse:collapse" cellspacing="0" cellpadding="1">

</table>
<?php



$html = ob_get_clean();
// $html = file_get_contents('./contents/sample_101.html');

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
// $pdf->Output(base_app.$pfname, 'F');
$pdf->Output('Prescription.pdf', 'I');
unset($pdf);

//============================================================+
// END OF FILE
//============================================================+