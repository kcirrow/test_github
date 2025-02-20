<?php
require('../../fpdf/fpdf.php');

include_once '../connection.php';
include_once '../class.php';
$object = new myclass;

$pdf = new FPDF('P','mm','Letter');

$object->islogin();

$data = json_decode($object->getPermitDetails($_GET['trcode'], $_GET['app'], "1"));


if (!$data->result) {
  exit();
  echo "<script>window.close()</script>";
}

$haha = $data->data;
$dtrel = date_create($haha->franchise_date);
$day = date_format($dtrel, "jS");
$month = date_format($dtrel, "F");
$year = date_format($dtrel, "Y");

function checkbox( $pdf, $checked = TRUE, $checkbox_size = 3 , $ori_font_family = 'Arial', $ori_font_size = '10', $ori_font_style = '' )
{
  if($checked == TRUE)
    $check = "4";
  else
    $check = "";

  $pdf->SetFont('ZapfDingbats','', $ori_font_size);
  $pdf->Cell($checkbox_size, $checkbox_size, $check, 1, 0);
  $pdf->SetFont( $ori_font_family, $ori_font_style, $ori_font_size);
}


$pdf->AddFont('Garamond','','Garamond.php');
$pdf->AddPage();



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




$pdf->AddFont('Garamond','','Garamond.php');
$pdf->SetMargins(15, 10 , 10);

$pdf->SetFont('Arial','B',12);
$pdf->cell(0,10,"MOTORIZED TRICYCLE OPERATOR'S PERMIT - APPLICATION FORM",0,1,'C');

if ($haha->appl_status == "NEW") {
  //NEW
  $pdf->SetXY(15,26);
  checkbox( $pdf, TRUE);

  //RENEW
  $pdf->SetXY(15,31);
  checkbox( $pdf, FALSE);
} else if ($haha->appl_status == "NEW") {
  //NEW
  $pdf->SetXY(15,26);
  checkbox( $pdf, FALSE);

  //RENEW
  $pdf->SetXY(15,31);
  checkbox( $pdf, TRUE);
}

$pdf->SetXY(20,25);
$pdf->SetFont('Garamond','',10);
$pdf->cell(40,5,'New',0,1,'L');


$pdf->SetXY(20,30);
$pdf->cell(20,5,'Renewal',0,1,'L');

$pdf->SetXY(130,30);
$pdf->SetFont('Arial','',9);
$pdf->cell(80,5,'Application Date: ___________________________',0,1,'L');

$pdf->SetXY(170,30);
$pdf->cell(20,5, $haha->dtreg,0,1,'L');


$pdf->SetY(40);
$pdf->SetFont('Arial','',10);
$pdf->cell(190,10,'Name of Operator :',1,1,'L');
$pdf->cell(110,10,'Complete Address :',1,0,'L');
$pdf->cell(80,10,'Contact No.:',1,1,'L');
$pdf->cell(190,4,'',1,1,'L');

$pdf->SetXY(50,40);
$pdf->cell(155,10,$haha->fullname,0,1,'L');

$pdf->SetXY(50,50);
$pdf->MultiCell(75,5,$haha->addr,0,'L',0);

$pdf->SetXY(150,50);
$pdf->cell(55,10,$haha->opcontact,0,1,'L');

$pdf->SetY(64);
$pdf->cell(27.5,10,'Age: ',1,0,'L');
$pdf->cell(27.5,10,$haha->age,1,0,'C');

$pdf->cell(27.5,10,'Birth Place: ',1,0,'L');
$pdf->cell(27.5,10,'',1,0,'C');

$pdf->cell(27.5,10,'Birth Date : ',1,0,'L');
$pdf->cell(52.5,10,$haha->birth_date,1,1,'C');

$pdf->SetY(74);
$pdf->cell(27.5,10,'Sex: ',1,0,'L');
$pdf->cell(27.5,10,$haha->sex,1,0,'C');

$pdf->cell(27.5,10,'Occupation : ',1,0,'L');
$pdf->cell(27.5,10,$haha->occupation,1,0,'C');

$pdf->cell(27.5,10,'Status : ',1,0,'L');
$pdf->cell(52.5,10,$haha->civil_status,1,1,'C');
$pdf->SetFont('Garamond','',10);
$pdf->cell(190,4,'MOTOR Information',1,1,'L');

$pdf->SetY(88);
$pdf->SetFont('Arial','',10);
$pdf->cell(27.5,10,'Make/Type: ',1,0,'L');
$pdf->cell(27.5,10,$haha->make,1,0,'C');

$pdf->cell(27.5,10,'Year Model: ',1,0,'L');
$pdf->cell(27.5,10,$haha->yearmodel,1,0,'C');
$pdf->SetFont('Arial','',9);
$pdf->cell(27.5,10,'Motor/Engine No. : ',1,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->cell(52.5,10,$haha->engine,1,1,'C');

$pdf->SetY(98);
$pdf->SetFont('Arial','',10);
$pdf->cell(27.5,10,'Chasis No.: ',1,0,'L');
$pdf->cell(27.5,10,$haha->chassis,1,0,'C');

$pdf->cell(27.5,10,'LTO Plate : ',1,0,'L');
$pdf->cell(27.5,10,$haha->plateno,1,0,'C');

$pdf->cell(27.5,10,'Mun. Plate : ',1,0,'L');
$pdf->cell(52.5,10,$haha->munplateno,1,1,'C');
$pdf->SetFont('Garamond','',10);
$pdf->cell(190,4,"Driver's Information",1,1,'L');


$pdf->SetY(112);
$pdf->SetFont('Arial','',10);
$pdf->cell(82.5,10,'Name : ',1,0,'L');
$pdf->cell(107.5,10,'Address :',1,1,'L');
$pdf->cell(82.5,10,'Birthdate : ',1,0,'L');
$pdf->cell(107.5,10,'Age :',1,1,'L');
$pdf->SetFont('Garamond','',10);
$pdf->cell(190,4,"In case of Emergency Driver",1,1,'L');

$pdf->SetXY(30,112);
$pdf->SetFont('Arial','',10);
$pdf->cell(67.5,10,$haha->drivername,0,1,'L');

$pdf->SetXY(115,112);
// $pdf->cell(90,10,$haha->driveraddr,0,1,'L');
$pdf->MultiCell(90,5,$haha->addr,0,'L',0);

$pdf->SetXY(35,122);
$pdf->cell(62.5,10,$haha->driverbirthday,0,1,'L');

$pdf->SetXY(115,122);
$pdf->cell(90,10,$haha->driverage,0,1,'L');


$pdf->SetY(136);
$pdf->SetFont('Arial','',10);
$pdf->cell(190,10,'Name of Operator :',1,1,'L');
$pdf->cell(82.5,10,'Contact No. : ',1,0,'L');
$pdf->cell(107.5,10,'Address :',1,1,'L');

$pdf->SetXY(50,136);
$pdf->cell(155,10,$haha->conperson,0,1,'L');

$pdf->SetXY(40,146);
$pdf->cell(57.5,10,$haha->conconnum,0,1,'L');

$pdf->SetXY(115,146);
$pdf->cell(90,10,$haha->conaddress,0,1,'L');

$pdf->SetY(161);
$pdf->SetFont('Garamond','',11);
$pdf->cell(190,4,"Requirements:",0,1,'L');


$pdf->SetFont('Arial','',9);
$pdf->SetXY(20,166);
$pdf->cell(40,5,'Community Tax Certificate (CEDULA)',0,1,'L');
$pdf->SetXY(15,167);
checkbox( $pdf, TRUE);


$pdf->SetXY(20,171);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'Original Receipt (OR)/Certificate of Registration (CR)',0,1,'L');
$pdf->SetXY(15,172);
checkbox( $pdf, TRUE);

$pdf->SetXY(20,176);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'Barangay Clearance that indicates residency',0,1,'L');
$pdf->SetXY(15,177);
checkbox( $pdf, TRUE);

$pdf->SetXY(20,181);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'Certification from Federation of all TODA',0,1,'L');
$pdf->SetXY(15,182);
checkbox( $pdf, TRUE);

$pdf->SetXY(20,186);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'Certification of membership from TODA)',0,1,'L');
$pdf->SetXY(15,187);
checkbox( $pdf, TRUE);

$pdf->SetXY(20,191);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,"Photocopy of Driver's License",0,1,'L');
$pdf->SetXY(15,192);
checkbox( $pdf, TRUE);

$pdf->SetXY(20,196);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'Notarized Deed of Sale (if any)',0,1,'L');
$pdf->SetXY(15,197);
checkbox( $pdf, TRUE);

$pdf->SetXY(20,201);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'Previous Permit (for Renewal)',0,1,'L');
$pdf->SetXY(15,202);
checkbox( $pdf, TRUE);


$pdf->SetXY(122,161);
$pdf->SetFont('Garamond','',11);
$pdf->cell(190,4,"Checklist:",0,1,'L');


$pdf->SetFont('Arial','',9);
$pdf->SetXY(120,166);
$pdf->cell(40,5,"1. Head light ()",0,1,'L');

$pdf->SetXY(120,171);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,"2. Signal light L (), R ()",0,1,'L');

$pdf->SetXY(120,176);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,"3. Stop light () & tail light ()",0,1,'L');

$pdf->SetXY(120,181);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,"4. Passenger Light ()",0,1,'L');

$pdf->SetXY(120,186);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'5. Windshield',0,1,'L');

$pdf->SetXY(120,191);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,"6. Garbage Plastic",0,1,'L');

$pdf->SetXY(120,196);
$pdf->SetFont('Arial','',9);
$pdf->cell(40,5,'7. Chain cover',0,1,'L');



$pdf->SetY(210);
$pdf->SetFont('Garamond','',11);
$pdf->cell(40,5,'Inspected By     : ________________________________',0,1,'L');

$pdf->SetXY(44,210);
$pdf->SetFont('Arial','',9);
$pdf->cell(63,5,$haha->encoded_by,0,1,'L');


$pdf->SetY(215);
$pdf->SetFont('Garamond','',11);
$pdf->cell(40,5,'Date                   : ________________________________',0,1,'L');

$pdf->SetXY(44,215);
$pdf->SetFont('Arial','',9);
$pdf->cell(63,5,date("Y-m-d"),0,1,'L');

$pdf->SetY(220);
$pdf->SetFont('Garamond','',11);
$pdf->cell(40,5,'Time                  : ________________________________',0,1,'L');

$pdf->SetXY(44,220);
$pdf->SetFont('Arial','',9);
$pdf->cell(63,5,date("H:i:s"),0,1,'L');

$pdf->SetY(225);
$pdf->SetFont('Garamond','',11);
$pdf->cell(40,5,'Remarks            : ________________________________',0,1,'L');
$pdf->SetXY(44,225);
$pdf->SetFont('Arial','',9);
$pdf->cell(63,5,'',0,1,'L');

$pdf->Output();


?>