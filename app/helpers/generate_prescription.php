<?php

// Include the main TCPDF library (search for installation path).
require_once(APPROOT.'/TCPDF/tcpdf.php');
class MYPDF extends TCPDF {

    public $docName;
    public $hospitalName;
    public $spec;
    public $slmc;

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
        $this->Cell(0, 19, $this->docName , 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', '', 12);
        $this->SetTextColor(14, 14, 83);
        $this->Ln(7); // Move down a bit
        $this->Cell(0, 10, $this->spec , 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', '', 11);
        $this->SetTextColor(14, 14, 83);
        $this->Ln(6); // Move down a bit
        $this->Cell(0, 10, $this->slmc , 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', '', 11);
        $this->SetTextColor(14, 14, 83);
        $this->Ln(6); // Move down a bit
        $this->Cell(0, 10, $this->hospitalName , 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', 'b', 15);
        $this->SetTextColor(14, 14, 83);
        $this->SetXY(30, 247);
        $this->Cell(0, 10, $this->docName, 0, false, 'L', 0, '', 0, false, 'M', 'M');
    
        

        $this->SetAlpha(.1);

        
    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->docName = 'Dr. '.$data['Doc_Name'];
$pdf->hospitalName = $data['Hospital_Name']. ", " . $data['Contact_No'];
$pdf->spec = $data['Specialization'];
$pdf->slmc = 'SLMC No: '.$data['SLMC_Reg_No'];


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HealthWave');
$pdf->SetTitle( $data['Name'] .'- Digital Prescription');
$pdf->SetSubject('Generated Digital Prescription');

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


// set font
$pdf->SetFont('dejavusans', '', 13);



// add a page
$pdf->AddPage();



// create some HTML content
ob_start();
?>
<br><br>
<br><br><br><br><br><br><br><br><br><br>

<div>
    <table>

        <tr>
            <td width="25%"><span> </span></td>
            <td width="35%"><span></span></td>
            <td width="20%"><span> </span></td>
            <td width="20%"><span style="border:1px"><?= $data['Prescription_ID']?></span></td>
        </tr><br>
        
        <tr>
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
            <td width="22%"><span></span></td>
            <td width="28%"><span style="border:1px"><?= $data['NIC']?></span></td>
            <td width="23%"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;23 </span></td>
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
            <td width="18%"><span></span></td>
            <td width="72%"><span style="border:1px"><br><?= $data['Diagnosis']?></span></td>
        </tr>
    </table>
    <br><br><br><br>
</div>
<table width="100%" style="table-collapse:collapse" cellspacing="0" cellpadding="1">

</table>
<?php



$html = ob_get_clean();


// Decode drug details JSON string
$drugDetails = $data['Drugs'];
$testDetails = $data['Tests'];
if (!empty($testDetails)) {
    // Begin drug details table HTML
    $drugTableHtml = '<div style="display: flex; justify-content: center;">';
    $drugTableHtml .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<table cellpadding="5" cellspacing="0" border="1" style="width: 90%;  margin: auto; text-align: center;">';
    $drugTableHtml .= '<tr><th><b>Drug Name</b></th><th><b>Amount</b></th><th><b>Amount Unit</b></th><th><b>Frequency</b></th><th><b>Duration</b></th></tr>';

    // Populate drug details table rows
    foreach ($drugDetails as $detail) {
        $drugTableHtml .= '<tr>';
        $drugTableHtml .= '<td>' . $detail['drug_name'] . '</td>';
        $drugTableHtml .= '<td>' . $detail['amount'] . '</td>';
        $drugTableHtml .= '<td>' . $detail['amount_unit'] . '</td>';
        $drugTableHtml .= '<td>' . $detail['frequency'] . '</td>';
        $drugTableHtml .= '<td>' . $detail['duration'] . '</td>';
        $drugTableHtml .= '</tr>';
    }

    // End drug details table HTML
    $drugTableHtml .= '</table>';
    $drugTableHtml .= '</div>';

    // Append drug details table HTML to the existing HTML content
    $html .= $drugTableHtml;
}

if (!empty($testDetails)) {
    
    // $testNamesHtml .= '<div style="display: flex; justify-content: center;">'; // Center the div
    $testNamesHtml = '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recommended Tests: '; // Paragraph to contain the test names

    // Iterate through the test names array and concatenate them with commas
    $testCount = count($testDetails);
    foreach ($testDetails as $index => $testName) {
        $testNamesHtml .= $testName;
        if ($index < $testCount - 1) {
            // Add a comma after each test name except the last one
            $testNamesHtml .= ', ';
        }
    }

    $testNamesHtml .= '</p>'; // End of paragraph
    $testNamesHtml .= '<p>';
    $testNamesHtml .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Refarrals: ' . $data['Referral'];   
    $testNamesHtml .= '</p>'; // End of paragraph

    // Append the test names HTML to the existing HTML content
    $html .= $testNamesHtml;
}

// Output the HTML content with drug details table to the PDF
$pdf->writeHTML($html, true, false, true, false, '');


$style = array(
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, 
    'module_width' => 1, 
    'module_height' => 1 
);

$validation_url = "http://localhost/healthwave/prescription/validate?id=".$data['Prescription_ID'];
$pdf->write2DBarcode($validation_url, 'QRCODE,L', 145, 220, 50, 50, $style, 'N');


// reset pointer to the last page
$pdf->lastPage();


//Close and output PDF document
$pdf->Output('Prescription-'. $data["Name"] . '-' . $data["Date"] . '-' . $data["Prescription_ID"]  .'.pdf', 'I');
unset($pdf);
