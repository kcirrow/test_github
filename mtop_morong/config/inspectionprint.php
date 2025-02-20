<?php
include_once 'connection.php';
include_once 'class.php';
$object = new myclass;
require('../fpdf/fpdf.php');

$object->islogin();

$data = json_decode($object->getdetInspectionforPrint($_GET['trcode']));
$ins = $data->data;

$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$pdf->AddFont('Garamond','','Garamond.php');
#$pdf->Image('soa_sample.jpg',0,0,216,280);
$pdf->SetMargins(15, 10 , 10);
$y = $pdf->GetY();
$x = $pdf->GetX();

//SHAPE AND LINES STYLE/////////////////////////////////////////////////
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
$style4 = array('L' => 0,
                'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
                'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
                'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
$style5 = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 255, 0));
$style7 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 0));


$pdf->SetY($y+6);
$pdf->SetFont('Garamond','',10);
$pdf->cell(0,4,'Republic of the Philippines ',0,1,'C');
$pdf->cell(0,4,'Province of Laguna ',0,1,'C');
$pdf->cell(0,4,'MUNICIPALITY OF MORONG ',0,1,'C');

$pdf->SetY($y+22);
$pdf->SetFont('Arial','B',12);
$pdf->cell(0,3,'MUNICIPAL TRICYCLE FRANCHISING AND REGULATORY BOARD',0,1,'C');


$pdf->SetY($y+32);
$pdf->SetFont('Garamond','',10);
$pdf->cell(0,3,'TECHNICAL INSPECTION REPORT',0,1,'C');


$pdf->SetY($y+39.5);
$pdf->cell(25,4,'Full Name of Applicant :',0,0,'L');

$pdf->SetY($y+46);
$pdf->SetFont('Arial','',9);
$pdf->cell(61,6,utf8_decode($ins->last_name),1,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(61,6,utf8_decode($ins->first_name),1,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(61,6,utf8_decode($ins->middle_name),1,1,'C');

$pdf->SetFont('Arial','I',9);
$pdf->cell(61,6,utf8_decode('Surname'),0,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(61,6,utf8_decode('First Name'),0,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(61,6,utf8_decode('Middle Name'),0,1,'C');


$pdf->SetY($y+59);
$pdf->SetFont('Garamond','',10);
$pdf->cell(25,4,'Full Address :',0,0,'L');

$pdf->SetY($y+65.5);
$pdf->SetFont('Arial','',9);
$pdf->cell(45,6,utf8_decode($ins->address_street_name),1,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(45,6,utf8_decode($ins->address_brgy),1,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(45,6,utf8_decode($ins->address_municipality),1,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(45,6,utf8_decode($ins->address_province),1,1,'C');

$pdf->SetFont('Arial','I',9);
$pdf->cell(45,6,utf8_decode('Number & Street '),0,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(45,6,utf8_decode('Barangay '),0,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(45,6,utf8_decode('City/Municipality '),0,0,'C');
$pdf->cell(3,3,'',0,0,'L');
$pdf->cell(45,6,utf8_decode('Province '),0,1,'C');


$pdf->SetY($y+83);
$pdf->SetFont('Garamond','',10);    
$pdf->cell(25,4,'Membership:',0,0,'L');
$pdf->SetXY($x+27,$y+82);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode($ins->toda),1,1,'C');
$pdf->SetFont('Arial','I',10);
$pdf->SetY($y+91);
$pdf->Write(5,utf8_decode('             This form indicates the complete Technical Inspection Report of all Motorcycle/tricycle applying for Franchising Clerance.'));

$pdf->SetY($y+102);
$pdf->SetFont('Garamond','',12); 
////////////////////////////////////////////////////////////////////////////////////////'
$pdf->cell(189,7,'DESCRIPTION OF MOTORCYCLE/TRICYCLE TO BE INSPECTED:',1,0,'C');
$pdf->SetY($y+112);
$pdf->cell(189,28,'',1,0,'C');

$pdf->SetXY($x+8,$y+114);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('1.  Make/Type : ________________________________ '),0,0,'L');
$pdf->SetXY($x+30,$y+114);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->make),0,0,'C');  



$pdf->SetXY($x+8,$y+120);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('2.  Engine No. : ________________________________ '),0,0,'L');
$pdf->SetXY($x+30,$y+120);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->engine),0,0,'C');  


$pdf->SetXY($x+8,$y+126);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('3.  Chasis No. : ________________________________ '),0,0,'L');
$pdf->SetXY($x+30,$y+126);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->chassis),0,0,'C');  

$pdf->SetXY($x+8,$y+132);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('4.  Body No.    : ________________________________ '),0,0,'L');
$pdf->SetXY($x+30,$y+132);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->bodyno),0,0,'C');  

$pdf->SetXY($x+108,$y+114);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('5.  Plate No.   : _________________________________ '),0,0,'L');
$pdf->SetXY($x+130,$y+114);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->plateno),0,0,'C');  

$pdf->SetXY($x+108,$y+120);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('6.  Fuel        : __________________________________ '),0,0,'L');
$pdf->SetXY($x+130,$y+120);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->fuel),0,0,'C');  

$pdf->SetXY($x+108,$y+126);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('7.  Model       : _________________________________ '),0,0,'L');
$pdf->SetXY($x+130,$y+126);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->model),0,0,'C');  

$pdf->SetXY($x+108,$y+132);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('8.  Year Acquired : ______________________________ '),0,0,'L');
$pdf->SetXY($x+135,$y+132);
$pdf->SetFont('Arial','B',9);
$pdf->cell(55,6,utf8_decode($ins->yearacquired),0,0,'C');  

//////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////


$pdf->SetY($y+143);
$pdf->SetFont('Garamond','',12); 
$pdf->cell(189,7,'OTHER ACCESSORIES TO BE INSPECTED',1,0,'C');
$pdf->SetY($y+153);
$pdf->cell(189,28,'',1,0,'C');

$pdf->SetXY($x+8,$y+155);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('1. Head Light : _________________________________ '),0,0,'L');
$pdf->SetXY($x+30,$y+155);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->headlight),0,0,'C');

$pdf->SetXY($x+8,$y+161);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('2. Signal Light : ________________________________ '),0,0,'L');
$pdf->SetXY($x+30,$y+161);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->signallight),0,0,'C');

$pdf->SetXY($x+8,$y+167);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('3. Stop Light : __________________________________ '),0,0,'L');
$pdf->SetXY($x+30,$y+167);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->stoplight),0,0,'C');

$pdf->SetXY($x+8,$y+173);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('4. Hand and Foot Break : _________________________ '),0,0,'L');
$pdf->SetXY($x+45,$y+173);
$pdf->SetFont('Arial','B',9);
$pdf->cell(45,6,utf8_decode($ins->handfootbrake),0,0,'C');

$pdf->SetXY($x+108,$y+155);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('5. Light insede the car : __________________________ '),0,0,'L');
$pdf->SetXY($x+140,$y+155);
$pdf->SetFont('Arial','B',9);
$pdf->cell(50,6,utf8_decode($ins->lightinsidecar),0,0,'C');

$pdf->SetXY($x+108,$y+161);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('6. Trash Can inside the car : ______________________ '),0,0,'L');
$pdf->SetXY($x+150,$y+161);
$pdf->SetFont('Arial','B',9);
$pdf->cell(40,6,utf8_decode($ins->trashcan),0,0,'C');

$pdf->SetXY($x+108,$y+167);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode('7. Plate Number : _______________________________'),0,0,'L');
$pdf->SetXY($x+135,$y+167);
$pdf->SetFont('Arial','B',9);
$pdf->cell(55,6,utf8_decode($ins->plate),0,0,'C');

$pdf->SetXY($x+108,$y+173);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode("8. Drivers's License : ____________________________ "),0,0,'L');
$pdf->SetXY($x+140,$y+173);
$pdf->SetFont('Arial','B',9);
$pdf->cell(50,6,utf8_decode($ins->drivlis),0,0,'C');

////////////////////////////////////////////////////////////////////////////////////////////

$pdf->SetY($y+184);
$pdf->SetFont('Garamond','',12); 
$pdf->cell(94.5,8,'STENCIL (MOTOR NUBMER)',1,0,'C');
$pdf->cell(94.5,8,'STENCIL (CHASIS NUMBER)',1,1,'C');
$pdf->cell(189,16,'',1,0,'C');

$pdf->SetXY($x+10,$y+215);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode("Inspected by :"),0,0,'L');

$pdf->SetXY($x+10,$y+223);
$pdf->SetFont('Arial','',9);
$pdf->cell(50,6,utf8_decode("______________________________"),0,0,'L');
$pdf->SetXY($x+10,$y+223);
$pdf->SetFont('Arial','B',9);
$pdf->cell(55,6,utf8_decode($ins->inspectedby),0,0,'C');

$pdf->SetXY($x+115,$y+215);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,6,utf8_decode("Approved for insurance:"),0,0,'L');

$pdf->SetXY($x+105,$y+223);
$pdf->SetFont('Garamond','',9);
$pdf->cell(60,6,utf8_decode("_____________________________________"),0,1,'L');
$pdf->SetXY($x+105,$y+228);
$pdf->cell(60,6,utf8_decode("INSPECTOR"),0,1,'C');

$pdf->SetXY($x+105,$y+223);
$pdf->SetFont('Arial','B',9);
$pdf->cell(60,6,utf8_decode($ins->approvedby),0,0,'C');

$pdf->Output();

?>