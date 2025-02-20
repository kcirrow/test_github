<?php

include_once '../connection.php';
include_once '../class.php';
$object = new myclass;
require('../../fpdf/fpdf.php');

$pdf = new FPDF('P','mm','Legal');

$object->islogin();

$data = json_decode($object->getPermitDetails($_GET['trcode'], $_GET['app'], $_GET['approve']));


if (!$data->result) {
  exit();
  echo "<script>window.close()</script>";
}
$haha = $data->data;
$dtrel = date_create($haha->franchise_date);
$day = date_format($dtrel, "jS");
$month = date_format($dtrel, "F");
$year = date_format($dtrel, "Y");



$original_date = date_create($haha->or_date);
//  $original_date = or_date;
$timestamp = strtotime($original_date);
$new_date = date("m-d-Y", $timestamp);
// echo $new_date; // Outputs: 31-03-2019


function checkbox( $pdf, $checked = TRUE, $checkbox_size = 3 , $ori_font_2family = 'Arial', $ori_font_size = '10', $ori_font_style = '' )
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
$pdf->Image('renewal.jpg',0,0,215.9,355.6);



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
$pdf->SetMargins(35, 10 , 18);
$pdf->SetFont('Garamond','',10);
#$pdf->cell(0,10,'CERTIFICATION',0,1,'C');


$pdf->SetXY(8,2.5);
$pdf->SetFont('Arial','B',7);
// $pdf->cell(30,8,$haha->trcode,0,1,'C');

$pdf->SetTextColor(194,8,8);
$pdf->SetXY(8,16);
$pdf->SetFont('Arial','B',20);
$pdf->cell(30,8,$haha->franchise_no,0,1,'C');


$pdf->SetXY(8,30);
$pdf->SetFont('Arial','B',12);
$pdf->cell(30,8,$haha->appl_status,0,1,'C');

$pdf->SetTextColor(0,0,0);

$pdf->SetY(42);
$pdf->SetFont('Arial','B',10);
// $pdf->cell(90,6,$haha->fullname,0,1,'C');
$pdf->cell(90,6,utf8_decode($haha->fullname),0,1,'C');


$pdf->SetY(48);
$pdf->SetFont('Arial','B',8);
// $pdf->cell(90,6,$haha->addr,0,1,'C');
$pdf->cell(90,6,utf8_decode($haha->addr),0,1,'C');


$pdf->SetY(54);
$pdf->SetFont('Arial','B',10);
$pdf->cell(90,6,$haha->occupation,0,1,'C');

$pdf->SetY(60);
$pdf->cell(90,6,$haha->certno,0,1,'C');

$pdf->SetY(66);
$pdf->cell(90,6,$haha->certat,0,1,'C');

$pdf->SetY(72);
$pdf->cell(90,6,$haha->certon,0,1,'C');


$pdf->SetY(91);
$pdf->cell(90,6,$haha->make,0,1,'C');

$pdf->SetY(97);
$pdf->cell(90,6,$haha->yearmodel,0,1,'C');

$pdf->SetY(103);
$pdf->cell(90,6,$haha->engine,0,1,'C');

$pdf->SetY(109);
$pdf->cell(90,6,$haha->chassis,0,1,'C');

$pdf->SetY(115);
$pdf->cell(90,6,$haha->plateno,0,1,'C');

$pdf->SetY(121);
$pdf->cell(90,6,$haha->toda,0,1,'C');



$pdf->SetFont('Arial','B',12);
$pdf->SetY(140);
$pdf->cell(90,6,$haha->app_name,0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetY(147);
$pdf->cell(90,6,$haha->app_pos,0,1,'C');


$tot = 0;
$py = 66;
foreach ($haha->payment as $key => $value) {
  $pdf->SetFont('Arial','',10);
  
  $pdf->SetXY(158, $py);
  $pdf->cell(50,6, $value->dueamt,0,1,'R');

  $pdf->SetXY(130, $py);
  $pdf->cell(50,6, $value->Fees,0,1,'L');
  $py += 6;
  $tot += floatval($value->dueamt);

  $pdf->SetXY(150,109);
  $pdf->cell(50,6, $value->or_number,0,1,'C');

  $pdf->SetXY(150,115);
  $pdf->cell(50,6, $value->or_date,0,1,'C');
}

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(158,97);
$pdf->cell(50,6,'TOTAL FEE      PHP '.$tot,0,1,'R');

$pdf->SetXY(145,141);
$pdf->cell(50,6,$haha->enc,0,1,'C');

#$pdf->Line(15, 36, 208, 36, $style3);
$pdf->SetFont('Arial','',9);
$pdf->SetXY(23,175);
$pdf->cell(63,6,'Morong, Rizal, '.$day.' day of '.$month.', '.$year.'.',0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->SetXY(64,190);
$pdf->cell(63,6,"SUBSCRIBED AND SWORN to before me this ".$day." day of ".$month.", ".$year." at Morong, Rizal",0,1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(126,173);
$pdf->cell(63,6,$haha->fullname,0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(115,203);
$pdf->cell(90,6,$haha->app_name,0,1,'C');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(115,209);
$pdf->cell(90,6,$haha->app_pos,0,1,'C');


$pdf->SetFont('Arial','',8.5);
$pdf->SetXY(64,274);
$pdf->cell(73,6," ".$year."",0,1,'C');

$pdf->SetAutoPageBreak(false);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(22,314);
$pdf->cell(90,6,'Morong, Rizal, '.$day.' day of '.$month.', '.$year.'.',0,1,'L');

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(60,329);
$pdf->cell(90,6,$haha->app_name,0,0,'C');


$pdf->SetFont('Arial','',10);
$pdf->SetXY(60,335);
$pdf->cell(90,6,$haha->app_pos,0,0,'C');

$pdf->Output();


?>