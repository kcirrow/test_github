<?php
require('../../fpdf/fpdf.php');

include_once '../connection.php';
include_once '../class.php';
$object = new myclass;

$pdf = new FPDF('P','mm','Letter');

$object->islogin();

$data = json_decode($object->getPermitDetails($_GET['trcode'], $_GET['app'], "1"));



if (!$data->result) {
  var_dump($data);
  exit();
  echo "<script>window.close()</script>";
}

$haha = $data->data;
$dtrel = date_create($haha->date_released);
$day = date_format($dtrel, "jS");
$month = date_format($dtrel, "F");
$year = date_format($dtrel, "Y");

$pdf->AddFont('Garamond','','Garamond.php');
$pdf->AddPage();
$pdf->Image('logo.png',87,2,35,35);

$pdf->AddFont('Garamond','','Garamond.php');
$pdf->SetFont('Garamond','',10);


$pdf->SetMargins(20, 10 , 20);

$pdf->SetY(40);
$pdf->SetFont('Garamond','',11);
$pdf->cell(0,5,"Republic of the Philippines",0,1,'C');
$pdf->cell(0,5,"Province of Rizal",0,1,'C');
$pdf->SetFont('Garamond','',13);
$pdf->cell(0,10,"MUNICIPALITY OF MORONG",0,1,'C');

$pdf->SetY(62);
$pdf->cell(0,5,"OFFICE OF THE MUNICIPAL PLANNING & DEVELOPMENT",0,1,'C');
$pdf->cell(0,5,"COORDINATOR",0,1,'C');

$pdf->SetY(78);
$pdf->SetFont('Arial','B',12);
$pdf->cell(0,5,"DROPPING OF FRANCHISE",0,1,'C');

$pdf->SetXY(40,90);
$pdf->SetFont('Arial','',10);
$pdf->Write(5,utf8_decode('Dropping of Franchise is hereby granted to '.$haha->fullname.' verified registered of one (1) unit of motorcycle classified as Tricycle as per LTO Registration No. '.$haha->mvno.' issued to LTO Binangonan Extension Office.'));
$pdf->SetXY(40,110);
$pdf->cell(0,10,"With the following descriptions : ",0,1,'L');



$pdf->SetX(40);
$pdf->cell(60,7,"Motor No  ",0,0,'C');
$pdf->cell(2,7,": ",0,0,'C');
$pdf->cell(60,7,$haha->engine,0,1,'C');

$pdf->SetX(40);
$pdf->cell(60,7,"Chasis No  ",0,0,'C');
$pdf->cell(2,7,": ",0,0,'C');
$pdf->cell(60,7,$haha->chassis,0,1,'C');

$pdf->SetX(40);
$pdf->cell(60,7,"Type   ",0,0,'C');
$pdf->cell(2,7,": ",0,0,'C');
$pdf->cell(60,7,$haha->make . " - " . $haha->yearmodel,0,1,'C');

$pdf->SetX(40);
$pdf->cell(60,7,"Plate No  ",0,0,'C');
$pdf->cell(2,7,": ",0,0,'C');
$pdf->cell(60,7,$haha->plateno,0,1,'C');

$pdf->SetX(40);
$pdf->cell(60,7,"Mun. Plate  ",0,0,'C');
$pdf->cell(2,7,": ",0,0,'C');
$pdf->cell(60,7,$haha->munplateno,0,1,'C');


$pdf->SetX(40);
$pdf->cell(60,7,"TODA   ",0,0,'C');
$pdf->cell(2,7,": ",0,0,'C');
$pdf->cell(60,7,$haha->toda,0,1,'C');

$pdf->SetY(175);
$pdf->cell(60,7,"Prepared by :   ",0,0,'L');

$pdf->SetXY(120,175);
$pdf->cell(60,7,"Date",0,0,'L');

$pdf->SetY(182);
$pdf->SetFont('Arial','B',10);
$pdf->cell(60,7,$haha->enc,0,0,'L');

$pdf->SetXY(120,182);
$pdf->SetFont('Arial','B',10);
$pdf->cell(60,7,date_format($dtrel, "F j, Y"),0,0,'');

$pdf->SetY(200);
$pdf->SetFont('Arial','',10);
$pdf->cell(60,7,"Approved by :   ",0,0,'L');

$pdf->SetY(220);
$pdf->SetFont('Arial','B',10);
$pdf->cell(60,7,'MARIBETH C. FELIX, EnP.',0,1,'L');
$pdf->cell(60,7,'MPDC',0,1,'L');


$pdf->SetXY(120,200);
$pdf->SetFont('Arial','',10);
$pdf->cell(60,7,"Noted by :   ",0,0,'L');

$pdf->SetXY(120,220);
$pdf->SetFont('Arial','B',10);
$pdf->cell(60,7,'SIDNEY B. SORIANO',0,1,'L');
$pdf->SetXY(120,227);
$pdf->cell(60,7,'Municipal Mayor',0,1,'L');

$pdf->Output();


?>