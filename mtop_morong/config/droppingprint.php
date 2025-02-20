<?php
include_once 'connection.php';
include_once 'class.php';
$object = new myclass;
require('../fpdf/fpdf.php');

$object->islogin();

$data = json_decode($object->getdetDropReleaseforPrint($_GET['trcode']));
$drp = $data->data;
$dtrel = date_create($drp->date_released);
$dtrel = date_format($dtrel, "F jS, Y");

$pdf = new FPDF('P','mm','Letter');

$pdf->AddPage();

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



$pdf->SetMargins(25, 10 , 25);
#$pdf->SetXY(5,5);
#$pdf->SetFont('Arial','',10);$pdf->cell(50,5,'$date',0,1,'L');


$pdf->AddFont('Garamond','','Garamond.php');


$pdf->Image('../dist/img/bgcarmona.png',13,2,30,30);

$pdf->Image('../dist/img/mtfrblogo.jpg',170,2,30,30);

$pdf->SetXY(50,5);
$pdf->SetFont('Arial','',11);
$pdf->cell(100,5,'Republic of the Philippines',0,1,'L');
$pdf->SetX(50);
$pdf->cell(100,5,'Province of Cavite',0,1,'L');
$pdf->SetX(50);
$pdf->SetFont('Garamond','',11);
$pdf->cell(100,5,'MUNICIPAL GOVERNMENT OF CARMONA',0,1,'L');
$pdf->SetX(50);
$pdf->SetFont('Garamond','',14);
$pdf->cell(100,5,'MUNICIPAL TRICYCLE FRANCHISING',0,1,'L');
$pdf->SetX(50);
$pdf->SetFont('Garamond','',14);
$pdf->cell(100,5,'AND REGULATORY BOARD (MTFRB)',0,1,'L');


$pdf->Line(13, 35, 200, 35, $style3);


$pdf->SetXY(30,60);
$pdf->SetFont('Arial','BU',20);
$pdf->cell(0,7,'C E R T I F I C A T I O N',0,1,'C');
$pdf->SetFont('Arial','BU',10);
$pdf->SetTextColor(194,8,8);
$pdf->SetFont('Arial','',13);
$pdf->cell(0,7,$drp->trcode,0,1,'C');
$pdf->SetTextColor(000,000,000);


$pdf->SetFont('Arial','',13);


$pdf->SetXY(50,80);

$pdf->Write(8,'This is to certify that as per record of this office, permit to operate (Franchise) issued to '.$drp->fullname.' has been CANCELLED wich described as follows:');

$pdf->ln(15);

$pdf->SetX(70);
$pdf->cell(40,6,'Franchise No. ',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->cell(40,6,$drp->franchise_no,0,1,'L');
$pdf->SetX(70);
$pdf->SetFont('Arial','',13);
$pdf->cell(40,6,'Make',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->cell(40,6,$drp->make,0,1,'L');
$pdf->SetX(70);
$pdf->SetFont('Arial','',13);
$pdf->cell(40,6,'Chassis No.',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->cell(40,6,$drp->chassis,0,1,'L');
$pdf->SetX(70);
$pdf->SetFont('Arial','',13);
$pdf->cell(40,6,'Motor No. ',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->cell(40,6,$drp->engine,0,1,'L');
$pdf->SetX(70);
$pdf->SetFont('Arial','',13);
$pdf->cell(40,6,'Plate No. ',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->cell(40,6,$drp->plateno,0,1,'L');
$pdf->SetX(70);
$pdf->SetFont('Arial','',13);
$pdf->cell(40,6,'MV No. ',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->cell(40,6,$drp->mvno,0,1,'L');
$pdf->SetX(70);
$pdf->SetFont('Arial','',13);
$pdf->cell(40,6,'Reason ',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->cell(40,6,$drp->reason,0,1,'L');

#$pdf->SetXY(152,$y-1);
#$pdf->SetFont('Arial','B',9);$pdf->cell(20,10,'$1Q-2020',0,1,'L');

$pdf->ln(10);
$pdf->SetFont('Arial','',13);
$pdf->Write(8,'Issued this '.$dtrel.' , upon request of '.$drp->fullname.' for whatever legal purpose it may serve.');



$pdf->SetXY(112,190);
$pdf->SetFont('Arial','B',10);$pdf->cell(100,5,'SHELLA R. VILLAHERMOSA',0,1,'C');
$pdf->SetXY(112,195);
$pdf->SetFont('Arial','',9);$pdf->cell(100,5,'Administrative Assistant VI',0,1,'C');



$pdf->ln(30);

$pdf->SetFont('Arial','',10);$pdf->cell(33,5,'Paind under Or no. :',0,0,'L');
$pdf->SetFont('Arial','B',10);$pdf->cell(100,5,$drp->or_number,0,1,'L');

$pdf->SetFont('Arial','',10);$pdf->cell(28,5,'Ampount Paid :',0,0,'L');
$pdf->SetFont('Arial','B',10);$pdf->cell(100,5,$drp->AmtDue,0,1,'L');

$pdf->SetFont('Arial','',10);$pdf->cell(10,5,'Date :',0,0,'L');
$pdf->SetFont('Arial','B',10);$pdf->cell(15,5,$drp->or_date,0,1,'L');


$pdf->Output();


?>