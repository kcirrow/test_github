<?php 

  include_once '../config/connection.php';
  include_once '../config/class.php';
  $object = new myclass;

  $det = $object->getPermitDetails($_GET['trcode'], $_GET['app']);

  if ($det['data']['target_path'] == "") {
    $img = '../dist/img/operator.jpg';
  } else {
    $img = $det['data']['target_path'];
  }

  $date = new DateTime(date('d-m-Y'));

  $day = date_format($date, "jS");
  $month = date_format($date, "F");
  $year = date_format($date, "Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "../config/links.php"; ?>
  <style type="text/css">
    p {
      margin: 0px;
    }
    .container {
      margin-top: 50px !important;
      padding-right: 100px !important;
      padding-left: 100px !important;
      background: url('../dist/img/dasma_logobg.jpg') no-repeat center;
      background-size: 900px 900px;
    }
    @media print {
      body {-webkit-print-color-adjust: exact;}
    }
    @page {
        size:legal;
        margin-left: 0px;
        margin-right: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
        margin: 0;
        -webkit-print-color-adjust: exact;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row">
      <div class="col-sm-9">
        <img src="<?php echo $img; ?>" style="width: 200px !important; height: 200px !important;">
      </div>
      <div class="col-sm-3 float-right">
        <p>Valid Until: <?php echo $det['data']['dtexprd']; ?></p>
        <p>MTP #: <?php echo $det['data']['franchise_no']; ?></p>
        <p>******</p>
        <p>******</p>
      </div>
    </div>
    
    <br>

    <div class="row">
      <div class="col-xs-12 text-center">
        <p>Province of Cavite</p>
        <p>City of Dasmariñas</p>
        <p><b>CITY TRICYCLE FRANCHISING AND REGULATORY BOARD</b></p>
        <p style="font-size: 22px !important; font-weight: bold;">MOTORIZED TRICYCLE OPERATOR'S PERMIT</p>
        <p style="text-indent: 50px; text-align: justify;">Pursuant to Tax Ordinance 1-s-2014 known as "the Revised Revenue Code of the City of Dasmariñas, Cavite " <strong>AUTHORITY TO OPERATE</strong> a Motorized Tricycle-For-Hire covering the tricycle until described below is hereby granted to:</p>
        <br>
        <p style="font-size: 30px !important; font-weight: bold;"><?php echo $det['data']['fullname']; ?></p>
        <p style="font-size: 22px !important;"><?php echo $det['data']['addr']; ?></p>
        <br>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <p><label>MAKE: <?php echo $det['data']['mo2']; ?></label></p>
        <p><label>ENGINE: <?php echo $det['data']['mo7']; ?></label></p>
        <p><label>CHASSIS: <?php echo $det['data']['mo5']; ?></label></p>
      </div>
      <div class="col-sm-6">
        <p><label>LTO PLATE NO: <?php echo $det['data']['mo6']; ?></label></p>
        <p><label>TODA NAME: <?php echo $det['data']['mo1']; ?></label></p>
        <p><label>BODY NO: <?php echo $det['data']['f1']; ?></label></p>
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-sm-12 text-center">
        <p>That this <strong>PERMIT/FRANCHISE</strong> is subject to the following CTFRB terms and conditions:</p>
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-sm-6">
        <p style="text-align: justify;">1. Granted only to resident who are registered voters of Dasmariñas and with valid registration papers of the unit from the LTO.</p>
        <p style="text-align: justify;">2. A motorized tricycle operator's permit (franchise) shall be limited to a single zone of operation only and shall expire every December 31 of this year.</p>
        <p style="text-align: justify;">3. Motorized Tricycle Operator's Permit shall be renewed every year. There shall be penalty impose for late payment and late renewal. Failure to renew shall mean cancellation of franchise.</p>
        <p style="text-align: justify;">4. Franchise is non-transferable and cannot be sold, alienated, encumbered or disposed of in any manner but can be transferred by hereditary succession.</p>
        <p style="text-align: justify;">5. Holder shall charge only the rate fare approved by the CTFRB.</p>
      </div>
      <div class="col-sm-6">
        <p style="text-align: justify;">6. Holder shall only employ a driver with a professional driver's license and with Tricycle Driver's Permit issued by the CTFRB.</p>
        <p style="text-align: justify;">7. The tricycle unit must be registered as FOR HIRE with the Land Transportation Office of <?php echo $det['data']['f3']; ?></p>
        <p style="text-align: justify;">8. No tricycle-for-hire shall be allowed to operate on National Highway unless there exist an unusual occurrence of event or force majeure involving urgent rerouting of traffic where the use of national highway is indispensable to public transportation.</p>
        <p style="text-align: justify;">9. Motorized Tricycle Operator's Permit, Tricycle Driver's Permit and original Fare Matrix must be displayed prominently inside the unit.</p>
        <p style="text-align: justify;">10. This Franchise shall be revoked and/or cancelled for and in violations of CTFRB rules and regulations.</p>
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-sm-12 text-center">
        <p>Issued this <?php echo $day; ?> day of <?php echo $month; ?>, <?php echo $year; ?> at the City of Dasmariñas, Cavite</p>
      </div>
    </div>
    
    <br>

    <div class="row">
      <div class="col-sm-12">
        <p>Not valid without seal</p>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 text-center">
        <strong>Approved By:</strong>
        <br>
        <strong><?php echo $det['data']['app_name']; ?></strong>
        <br>
        <strong><?php echo $det['data']['app_pos']; ?></strong>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <p>Amount Paid: <?php echo $det['data']['total']; ?></p>
        <p>OR #: <?php echo $det['data']['or_number']; ?></p>
        <p>Date: <?php echo $det['data']['or_date']; ?></p>
      </div>
    </div>
  </div>

<!-- <script type="text/javascript" src="js/report.js"></script> -->

</body>
</html>
