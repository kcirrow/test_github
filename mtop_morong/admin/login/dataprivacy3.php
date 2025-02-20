<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Privacy</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="/bpl/source/main1/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/bpl/source/main1/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/bpl/source/main1/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
  <link rel="stylesheet" href="/bpl/source/main1/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/bpl/source/main1/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/bpl/source/main1/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/bpl/source/main1/plugins/summernote/summernote-bs4.min.css">
  <link href="/bpl/source/main/css/sweetalert2.min.css" rel="stylesheet" />

</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <!-- Navbar -->


    <div class="wrapper">
      <div class="content-wrapper">
        <div class="content" style="background-color: #fff;">
          <div class="container">

            <div class="row">
              <div class="col-md-3">
                <div style="padding-left: 110px;">
                  <img src="/bpl/source/login/img/bg.png" style="width: 142px;">
                </div>
              </div>
              <div class="col-md-6">
                <div style="text-align: center;">
                  <label class="m-0" style="font-weight: 700; font-size: 22px; line-height: 1.5;">
                    Republic Of The Philippines
                  </label>
                  <div>
                    <label class="m-0" style="font-weight: 700; font-size: 22px; line-height: 1;">
                      Province Of Cavite
                    </label>
                  </div>
                  <div>
                    <label class="m-0" style="font-weight: 700; font-size: 22px; line-height: 1;">
                      City of General Trias
                    </label>
                  </div>
                  <div class="mt-4">
                    <label class="m-0" style="font-weight: 700; font-size: 30px; line-height: 1;">
                      INTEGRATED LGU PERMIT
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div style="padding-right: 110px; padding-top: 35px; text-align: center;">
                  <div id="qrcode"></div>
                  <label class="m-0" style=" font-weight: 600; font-size: 15px;">
                  </label>
                </div>
              </div>
            </div>
            <div class="mt-1 text-center">
              <label class="m-0" style="font-weight: 700; font-size: 18px; line-height: 1;">
                BARANGAY BUSINESS CLEARANCE, SANITARY PERMIT AND BUSINESS PERMIT
              </label>
            </div>


            <div class="row mt-3">
              <div class="col-lg-12 p-0">
                <table class="table m-0 text-nowrap" style="width: 100%">
                  <thead style="border: 2px solid #5a5a5a !important;">
                    <tr>
                      <th style="border: 2px solid #5a5a5a !important;">Business ID</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Name Of Owner</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Name Of Business</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Nature of Business</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Address Of Business</th>
                    </tr>
                  </thead>
                  <tbody style="text-align: right; font-size: 18px !important;" id="assessment-table-body2">

                  </tbody>
                </table>
              </div>
            </div>

            <div class="row" style="margin-top: -2px;">
              <div class="col-lg-12 p-0">
                <table class="table m-0 text-nowrap" style="width: 100%">
                  <thead style="border: 2px solid #5a5a5a !important;">
                    <tr>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Application No</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Application Date</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Status</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Mode of Payment</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;"> Plate No</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;"> Type of Ownership</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;"> Processed by</th>
                    </tr>
                  </thead>
                  <tbody style="text-align: right; font-size: 18px !important;" id="assessment-table-body1">

                  </tbody>
                </table>
              </div>
            </div>

            <div class="row" style="margin-top: -2px;">
              <div class="col-lg-12 p-0">
                <table class="table m-0 text-nowrap" style="width: 100%">
                  <thead style="border: 2px solid #5a5a5a !important;">
                    <tr>
                      <th style="border: 2px solid #5a5a5a !important;">Assessment Fee's</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Tax Base</th>
                      <th style="text-align: center; border: 2px solid #5a5a5a !important;">Amount Due</th>
                    </tr>
                  </thead>
                  <tbody style="text-align: right; font-size: 18px !important;" id="assessment-table-body">
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row" style="margin-top: -2px; border: 2px solid #5a5a5a !important;">
              <div class="col-md-6 p-1 mt-3">
                <label class="m-0" style=" font-weight: 700; font-size: 18px;">
                  PAYMENT BREAKDOWN
                </label>
                <table class="table" style="text-align: left;">
                  <thead>
                    <tr>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important;">Mode</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Due Date</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Due Amount</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Penalty</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Total</th>
                    </tr>
                  </thead>
                  <tbody id="annual-table-body">

                  </tbody>
                </table>
                <table class="table" style="text-align: left;">
                  <thead>
                    <tr>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important;">Semi-Annual</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Due Date</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Due Amount</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Penalty</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Total</th>
                    </tr>
                  </thead>
                  <tbody id="semi-table-body">

                  </tbody>
                </table>
                <table class="table" style="text-align: left;">
                  <thead>
                    <tr>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important;">Quarterly</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Due Date</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Due Amount</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Penalty</th>
                      <th scope="col" style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: center;">Total</th>
                    </tr>
                  </thead>
                  <tbody id="quarterly-table-body">

                  </tbody>
                </table>
                <div class="row mt-2" style="margin-left: -6px !important;">
                  <div class="col-lg-12 p-0" style="margin-bottom: -6px;">
                    <table class="table m-0 text-nowrap" style="width: 100%">
                      <thead style="border: 2px solid #5a5a5a !important;">
                        <tr>
                          <th style="text-align: center; border: 2px solid #5a5a5a !important;"> FIRE SAFETY INSPECTION FEE : </th>
                          <th style="text-align: center; border: 2px solid #5a5a5a !important;">₱ 101,000.00 </th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>


              <div class="col-md-1">
              </div>
              <div class="col-md-5 mt-3">
                <label class="m-0" style=" font-weight: 700; font-size: 18px;">
                  COMPUTATION
                </label>
                <div class="row">
                  <div class="col-md-5 ml-4">
                    <div>
                      <label class="m-0" style=" font-weight: 500; font-size: 15px;">
                        Total Taxes & Fees:
                      </label>
                    </div>
                    <div>
                      <label class="m-0" style=" font-weight: 500; font-size: 15px;">
                        Surcharge:
                      </label>
                    </div>
                    <div>
                      <label class="m-0" style=" font-weight: 500; font-size: 15px;">
                        Interest:
                      </label>
                    </div>
                    <div>
                      <label class="m-0" style=" font-weight: 700; font-size: 15px;">
                        Grand Total:
                      </label>
                    </div>
                  </div>
                  <div class="col-md-5" style="text-align: right;">
                    <div>
                      <label class="m-0" style=" font-weight: 500; font-size: 15px;" id="total-tax">
                        2,306.00
                      </label>
                    </div>
                    <div>
                      <label class="m-0" style=" font-weight: 500; font-size: 15px;" id="total-surchage">
                        0.00
                      </label>
                    </div>
                    <div>
                      <label class="m-0" style=" font-weight: 500; font-size: 15px;" id="total-interest">
                        0.00
                      </label>
                    </div>
                    <div>
                      <label class="m-0" style=" font-weight: 700; font-size: 15px;" id="total-grand">
                        2,306.00
                      </label>
                    </div>
                  </div>
                </div>
                <div>
                  <label class="mt-5" style=" font-weight: 700; font-size: 15px;">
                    REMARKS:
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 p-0">
                <div class="p-2" style="border: 2px solid #5a5a5a !important; margin-top: -2px;">
                  <div class="m-1 text-center">
                    <label class="m-0" style="font-weight: 700; font-size: 18px; line-height: 1;">
                      REMINDERS
                    </label>
                  </div>
                  <ol>
                    <li>Please Pay the amount due at the Treasury Office on or before Nov 20, 2020</li>
                    <li>Delinquent payments are assessed a Surcharge of 25% and 2% Interest per Month.</li>
                    <li>For Business Retirement, all dues should be paid in full before retirement.</li>
                    <li>If Amount Due already paid, please disregard REMINDERS 1 & 2.</li>
                    <li>Must not be contrary to law, morals, good customs, public order or public policy.</li>
                    <li>Must be posted in plain view at the place herein indicated</li>
                    <li>Must be surrendered within thirty (30) days following the termination of the business.</li>
                    <li>It is not valid without the corresponding official receipt for prescribed taxes and fees.This permit expires on the date stated herein unless sooner revoked or cancelled. The business shall subject itself to inspection by authorized personnel of the City.</li>
                    <li>This permit is automatically REVOKED upon violation of pertinent Ordinance or Law.</li>
                    <li>In accordance with Section 1 of presidential decree no. 522/856, sanitary permit is subject to revocation if the owner, operator or manager fails to observe the rules and regulation in a manner satisfactory to the regional sanitation committee or its duly authorized representative.</li>
                  </ol>
                </div>
              </div>
              <div class="col-md-12 p-0">
                <div class="p-2" style="border: 2px solid #5a5a5a !important; margin-top: -2px;">
                  <div class="m-1 text-center">
                    <label class="m-0" style="font-weight: 600; font-size: 18px; line-height: 1;">
                      THIS BILL BECOMES YOUR BARANGAY BUSINESS CLEARANCE, SANITARY PERMIT AND MAYOR'S PERMIT FOR BUSINESS ONCE PAID AND SIGNED BY AUTHORIZED SIGNATORIES. NOT VALID WITHOUT DRY SEAL.
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 p-0">
                <div class="p-2" style="border: 2px solid #5a5a5a !important; margin-top: -2px;">
                  <div class="m-1 text-left">
                    <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                      For the Brgy. Clearance:
                    </label>
                  </div>
                  <div class="mt-5 text-center">
                    <label class="m-0" style="font-weight: 600; font-size: 18px; line-height: 1;">
                      RAMIL C. BARRIENTOS
                    </label>
                  </div>
                  <div class="text-center">
                    <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                      BRGY. CAPTAIN
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-4 p-0">
                <div class="p-2" style="border: 2px solid #5a5a5a !important; margin-top: -2px;">
                  <div class="m-1 text-left">
                    <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                      For the Sanitary Permit:
                    </label>
                  </div>
                  <div class="mt-5 text-center">
                    <label class="m-0" style="font-weight: 600; font-size: 18px; line-height: 1;">
                      JONATHAN P. LUSECO, MD
                    </label>
                  </div>
                  <div class="text-center">
                    <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                      CITY HEALTH OFFICER
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-4 p-0">
                <div class="p-2" style="border: 2px solid #5a5a5a !important; margin-top: -2px;">
                  <div class="m-1 text-left">
                    <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                      Approved :
                    </label>
                  </div>
                  <div class="mt-5 text-center">
                    <label class="m-0" style="font-weight: 600; font-size: 18px; line-height: 1;">
                      ANTONIO A. FERRER
                    </label>
                  </div>
                  <div class=" text-center">
                    <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                      CITY MAYOR
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                  dito yung qr
                </label>
              </div>
              <div class="col-md-3 p-0">
                <div class="mt-2 text-center">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    This Permit is valid until
                  </label>
                </div>
                <div class="text-center">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    Dec 31, 2020
                  </label>
                </div>
              </div>
              <div class="col-md-3 p-0">
                <div class="mt-2 text-left">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    Validated by : Office of the City Treasurer
                  </label>
                </div>
                <div class="text-left">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    OR # : 08987985
                  </label>
                </div>
                <div class=" text-left">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    OR Date : Dec 22, 2020
                  </label>
                </div>
                <div class="text-left">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    Amount Paid : ₱ 101,000.00
                  </label>
                </div>
              </div>
              <div class="col-md-3 p-0">
                <div class="mt-2 text-left">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    Received by : Roche Tolentino
                  </label>
                </div>
                <div class="text-left">
                  <label class="m-0" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    Date : Dec 22, 2020
                  </label>
                </div>
                <div class=" text-left">
                  <input type="checkbox" class="ml-2 form-check-input" id="cashto">
                  <label class="ml-4" for="cashto" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    Cash
                  </label>
                </div>
                <div class="text-left">
                  <input type="checkbox" class="ml-2 form-check-input" id="checkto">
                  <label class="ml-4" for="checkto" style="font-weight: 600; font-size: 15px; line-height: 1;">
                    Check
                  </label>
                </div>
              </div>



            </div>



          </div>
        </div>
      </div>
    </div>
    <div style="display:none;">
      <?php include_once 'includes/footer.php' ?>
    </div>
  </div>
  <script type="text/javascript">
    var formatter = new Intl.NumberFormat("en-US", {});

    var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

      for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
          return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
      }
    };

    $.ajax({
      url: "/bpladmin/admin/getDoneAssessment?pin=" + getUrlParameter('pin') + "&business_id=" + getUrlParameter('business_id'),
      method: "GET",
      dataType: "JSON",
      success: function(e) {
        var qrcode = new QRCode("qrcode", {
          text: "{['Pin':'" + e.result.applicationData.pin + "', 'Business Name':'" + e.result.applicationData.business_name + "','Business ID':'" + e.result.applicationData.business_id2 + "' ]}",
          width: 128,
          height: 128,
          colorDark: "#000000",
          colorLight: "#ffffff",
          correctLevel: QRCode.CorrectLevel.H
        });

        console.log(e);
        $("#application-date").html(e.result.applicationData.applicationDate);
        $("#application-no").html(e.result.applicationData.pin);
        $("#tax-payer").html(e.result.applicationData.owner_name);
        $("#business-name").html(e.result.applicationData.business_name);
        $("#business-location").html(e.result.applicationData.business_street);
        $("#status").html(e.result.applicationData.transaction + " / " + e.result.applicationData.for_year);

        for (i = 0; i < e.result.assessment.length; i++) {
          if (e.result.assessment[i].tfo_id == 8) {
            $("#assessment-table-body").append('<tr>' +
              '<td style="text-align: left !important; padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.assessment[i].tfodesc + ':</td>' +
              '<td style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.assessment[i].val1 + '</td>' +
              '<td style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.assessment[i].amount + '</td>' +
              '</tr>');
          } else {
            $("#assessment-table-body").append('<tr>' +
              '<td style="text-align: left !important; padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.assessment[i].tfodesc + ':</td>' +
              '<td style="padding: 0 !important; border-top: 1px solid #fff !important;"></td>' +
              '<td style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.assessment[i].amount + '</td>' +
              '</tr>');
          }
        }

        $("#annual-table-body").append('<tr>' +
          '<th scope="row" style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.payment[0].paymentmode + '</th>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[0].due_date + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[0].dueamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[0].penamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[0].totalduepen + '</td>' +
          '</tr>' +
          '<tr>' +
          '<th scope="row" style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important;">' + 'Total' + '</th>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;"></td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].dueamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].penamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].totalduepen + '</td>' +
          '</tr>');

        $("#semi-table-body").append('<tr>' +
          '<th scope="row" style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important;">' + e.result.payment[1].paymentmode + '</th>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[1].due_date + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[1].dueamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[1].penamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[1].totalduepen + '</td>' +
          '</tr>');

        $("#semi-table-body").append('<tr>' +
          '<th scope="row" style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.payment[2].paymentmode + '</th>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[2].due_date + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[2].dueamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[2].penamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[2].totalduepen + '</td>' +
          '</tr>' +
          '<tr>' +
          '<th scope="row" style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important;">' + 'Total' + '</th>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;"></td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].dueamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].penamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].totalduepen + '</td>' +
          '</tr>');

        $("#quarterly-table-body").append('<tr>' +
          '<th scope="row" style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.payment[3].paymentmode + '</th>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[3].due_date + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[3].dueamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[3].penamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[3].totalduepen + '</td>' +
          '</tr>');

        $("#quarterly-table-body").append('<tr>' +
          '<th scope="row" style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.payment[4].paymentmode + '</th>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[4].due_date + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[4].dueamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[4].penamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[4].totalduepen + '</td>' +
          '</tr>');

        $("#quarterly-table-body").append('<tr>' +
          '<th scope="row" style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.payment[5].paymentmode + '</th>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[5].due_date + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[5].dueamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[5].penamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[5].totalduepen + '</td>' +
          '</tr>');

        $("#quarterly-table-body").append('<tr>' +
          '<th scope="row" style="padding: 0 !important; border-top: 1px solid #fff !important;">' + e.result.payment[6].paymentmode + '</th>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[6].due_date + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[6].dueamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[6].penamt + '</td>' +
          '<td style="padding: 0 !important; border-top: 1px solid #fff !important; text-align: right;">' + e.result.payment[6].totalduepen + '</td>' +
          '</tr>' +
          '<tr>' +
          '<th scope="row" style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important;">' + 'Total' + '</th>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;"></td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].dueamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].penamt + '</td>' +
          '<td style="padding: 0 !important; padding-top: 3px !important; border-top: 2px solid #dee2e6 !important; text-align: right;">' + e.result.payment[0].totalduepen + '</td>' +
          '</tr>');

        $("#total-tax").html(e.result.total.dueamt);
        $("#total-interest").html(e.result.total.peninterest);
        $("#total-surchage").html(e.result.total.pensurcharge);
        $("#total-grand").html(e.result.total.grandTotal);

      }
    });
  </script>

</body>

</html>