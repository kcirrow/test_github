var reader = new FileReader();

reader.onload = function (e) {
    $('#operator_image').attr('src', e.target.result);
}
   
function readURL(input) {
    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
        console.log(input.files[0]);
    }
}

var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split("&"),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split("=");

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined
        ? true
        : decodeURIComponent(sParameterName[1]);
    }
  }
};

function GetTodayDate() {
   var tdate = new Date();
   var dd = tdate.getDate(); //yields day
   var MM = tdate.getMonth(); //yields month
   var yyyy = tdate.getFullYear(); //yields year
   var currentDate= yyyy + "-" +( MM+1) + "-" + dd;
   return currentDate;
}


$("#image_selector").change(function(){
    readURL(this);
});

function getDataOP(cb_func) {
  $.ajax({
    url: "../config/includes.php?var=getoperators",
    method: "POST",
    success: cb_func
  });
}

function getDrivers(cb_func) {
  $.ajax({
    url: "../config/includes.php?var=getdrivers",
    method: "POST",
    success: cb_func
  });
}

function getDropList(cb_func) {
  $.ajax({
    url: "../config/includes.php?var=getdroplist",
    method: "POST",
    success: cb_func
  });
}

function getDataMotor(cb_func) {
  $.ajax({
    url: "../config/includes.php?var=getmotor",
    method: "POST",
    success: cb_func
  });
}

function getDrop(cb_func) {
  $.ajax({
    url: "../config/includes.php?var=getdrop",
    method: "POST",
    data: {
      yr: $("#dropyr").val(),
      trstats: $("#droptrstats").val()
    },
    success: cb_func
  });
}

function getDataFranchise(cb_func) {
  $.ajax({
    url: "../config/includes.php?var=getfranchise",
    method: "POST",
    data: {
      yr: $("#franyr").val(),
      trstats: $("#frantrstats").val()
    },
    success: cb_func
  });
}

function callgetOperators(){
    getDataOP(function( data ) {
        var columns = [
          {data: "0"},
          {data: "1"},
          {data: "2"}                
        ];
      data = JSON.parse(data);
      $('#operatortable').DataTable().destroy();
      $('#operatortable').DataTable({
          data: data,
          columns: columns
      });
      // $("#selectop").attr("disabled", false);
  });
}

function callgetDrivers(){
    getDrivers(function( data ) {
        var columns = [
          {data: "0"},
          {data: "1"}               
        ];
      data = JSON.parse(data);
      $('#drivertable').DataTable().destroy();
      $('#drivertable').DataTable({
          data: data,
          columns: columns
      });
  });
}

function callgetFranchise(){
    getDataFranchise(function( data ) {
        var columns = [
          {data: "trcode"},
          {data: "fullname"},
          {data: "franchise_no"},                
          {data: "appl_status"},                
          {data: "Tags"},                
          {data: "addr"}                
        ];
      data = JSON.parse(data);
      $('#franchisetable').DataTable().destroy();
      $('#franchisetable').DataTable({
          responsive: true,
          data: data,
          columns: columns,
          order: [0, "desc"]
      });
  });
}

function callgetDropping(){
    getDrop(function( data ) {
        var columns = [
          {data: "trcode"},
          {data: "applicant"},               
          {data: "mo1"},                
          {data: "mo7"},                
          {data: "mo6"},                
          {data: "reason"},                
          {data: "trans_status"}                            
        ];
      data = JSON.parse(data);
      $('#droppingtable').DataTable().destroy();
      $('#droppingtable').DataTable({
          responsive: true,
          data: data,
          columns: columns,
          order: [0, "desc"]
      });
  });
}

function callgetDropList(){
    getDropList(function( data ) {
        var columns = [
          {data: "motorid"},
          {data: "appcode"},
          {data: "applicant"},
          {data: "opercode"},               
          {data: "operator"},                
          {data: "mo1"},                
          {data: "mo7"},                
          {data: "mo6"}                       
        ];
      data = JSON.parse(data);
      $('#droplisttable').DataTable().destroy();
      $('#droplisttable').DataTable({
          responsive: true,
          data: data,
          columns: columns
      });
  });
}

function callgetMotor(){
      getDataMotor(function( data ) {
          var columns = [
            {data: "motorid"},
            {data: "cname"},
            {data: "todabody"},
            {data: "mo7"},
            {data: "mo6"},
            {data: "opercode"},
            {data: "dname"},
            {data: "mo9"}      
          ];
        data = JSON.parse(data);
        $('#motortable').DataTable().destroy();
        $('#motortable').DataTable({
            data: data,
            columns: columns
        });
        $("#addmotor").attr("disabled", false);
    });
  } 

function clearbox() {
  $("#opercode, #firstname, #midinit, #lastname, #bday, #age, #hse, #blk, #lot, #st, #subd, #brgy, #mun, #prov, #drivlic, #drivissue, #drivplace, #contact, #ctc, #ctcissue, #ctcplace, #emername, #emercontact, #emeraddr, #remarks, #image_selector").val("");
  $("#drivecode, #drivefname, #drivemname, #drivelname, #drivectcno, #drivectcat, #drivectcon").val("");
  $("#operator_image").attr("src", "images/user.png");
}

function notif (title, text, type) {
  new PNotify({
      title: title,
      text: text,
      type: type,
      styling: 'bootstrap3',
      delay: 3000
  });
}

function getURL (url) {
  var baseurl = url.slice(0, 33);
  var cmpurl = url.slice(33, url.length);
  var pathname = window.location.pathname.split('/');

  if (cmpurl.includes("franchise-table.php")) {
    callgetFranchise();
  } else if (pathname[3] == "franchise.php") {
    if (cmpurl.includes("xre")) {
      $.ajax({
        url: "../config/includes.php?var=getdetfranchise",
        method: "POST",
        data: {trcode: getUrlParameter("xre")},
        dataType: "json",
        success: function(data){
          if (data) {
            $("#selectop, #selectdr, #addmotor").remove();

            $("#opcode").val(data["file_id"]);
            $("#opfullname").val(data["fullname"]);
            $("#opaddress").val(data["addr"]);
            $("#opcontact").val(data["cont_no"]);
            $("#opmotorcode").val(data["motorid"]);
            $("#optodabody").val(data["tbody"]);
            $("#opmake").val(data["mo2"]);
            $("#opengine").val(data["mo7"]);
            $("#opchassis").val(data["mo5"]);
            $("#opplate").val(data["mo6"]);
            $("#oplastrenew").val(data["last_renew"]);
            $("#trcode").val(data["trcode"]);
            $("#applstatus").val(data["appl_status"]);
            $("#drfullname").val(data['drname']);
            $("#drcode").val(data['drivercode']);
            if (data["file_name"] == "") {
              $("#operimg").attr("src", "images/user.png");
            } else {
              $("#operimg").attr("src", data["file_name"]);
            }
            $("#applyr").val(data["yr"]);
          }
        }
      });
    }

    window.setInterval(function(){
      $.ajax({
        url: "../config/includes.php?var=getdetassrelease",
        method: "POST",
        data: {trcode: $('#trcode').val()},
        dataType: "json",
        async: false,
        success: function (data) {
            $(".assappend").remove();
          for (var i = 0; i < data.length; i++) {
            $('.asstable').append("<tr class='assappend'>" + "<td>"+data[i]['Fees']+"</td>" + "<td>"+data[i]['AmtDue']+"</td>" + "<td>"+data[i]['or_number']+"</td>" + "<td>"+data[i]['or_date']+"</td>" + "</tr>");
          }
            // $("#relmtp").val(data[0]["franchise_no"]);
        }
      });
    }, 5000);

  } else if (cmpurl.includes("drop-table.php")) {
    callgetDropping();
  } else if (cmpurl.includes("dropping.php")) {
    var zen = $("#dasd").val(); 
    var cod = $("#dzen").val();
    // $.ajax({
    //   url: "../config/includes.php?var=getdetdrop",
    //   method: "POST",
    //   data: {
    //     code: cod,
    //     zen: zen
    //   },
    //   dataType: "text",
    //   success: function (data) {
    //     $("#dopcode").val(data["appcode"]);
    //     $("#dopfullname").val(data["applicant"]);

    //     $("#ddrcode").val(data['opercode']);
    //     $("#ddrfullname").val(data['operator']);

    //     $("#dopmotorcode").val(data["motorid"]);
    //     $("#doptodabody").val(data["mo1"]);
    //     $("#dopmake").val(data["mo2"]);
    //     $("#dopengine").val(data["mo7"]);
    //     $("#dopchassis").val(data["mo5"]);
    //     $("#dopplate").val(data["mo6"]);

    //   }
    // });

    window.setInterval(function(){
      $.ajax({
        url: "../config/includes.php?var=getdetdropassrelease",
        method: "POST",
        data: {trcode: $('#dtrcode').val()},
        dataType: "json",
        async: false,
        success: function (data) {
          $(".dropassappend").remove();
          for (var i = 0; i < data.length; i++) {
            $('.dropasstable').append("<tr class='dropassappend'>" + "<td>"+data[i]['Fees']+"</td>" + "<td>"+data[i]['AmtDue']+"</td>" + "<td>"+data[i]['or_number']+"</td>" + "<td>"+data[i]['or_date']+"</td>" + "</tr>");
          }
          $("#releasedrop").attr('disabled', false);
        }
      });
    }, 5000);
  } else if (cmpurl.includes("report-approved-franchise.php")) {
    $.ajax({
      url: "../config/includes.php?var=getcountapptodas",
      method: "POST",
      data: {yr:$("#rptfranyr").val()},
      dataType: "json",
      async: false,
      success: function (data) {
        $(".rptappend").remove();
        for (var i = 0; i < data.length; i++) {
          $('.rpttable').append("<tr class='rptappend'>" + "<td>"+data[i]['mo1']+"</td>" + "<td>"+data[i]['nn']+"</td>" + "<td>"+data[i]['rn']+"</td>" + "<td>"+data[i]['tot']+"</td>" + "</tr>");
        }
      }
    });
  } else if (cmpurl.includes("report-masterlist-franchise.php")) {
    $("#from").val("2021-01-01");
    $("#to").val("2021-12-31");

    $("#masterlist-franchise-datatable").DataTable({
      ajax: {
        url: "../config/includes.php?var=getmasterlistfran",
        method: "POST",
        data: {from:$("#from").val(), to:$("#to").val()},
        dataType: "json",
      },
      dom: "Blfrtip",
      buttons: [
      {
        extend: "copy",
        className: "btn-sm"
      },
      {
        extend: "csv",
        className: "btn-sm"
      },
      {
        extend: "excel",
        className: "btn-sm"
      },
      {
        extend: "pdfHtml5",
        className: "btn-sm"
      },
      {
        extend: "print",
        className: "btn-sm"
      },
      ],
      columns: [
        {data: "trcode"},
        {data: "appl_status"},
        {data: "mo1"},
        {data: "own_fn"},
        {data: "mo2"},
        {data: "mo7"},
        {data: "mo5"},
        {data: "mo6"},
        {data: "brgy"},
      ],
    });
  }
}

$(document).ready(function(){
  var ctrl = "";

  clearbox();
  // callgetOperators();
  // callgetMotor();
  // callgetFranchise();
  getURL(window.location.href);

  $("#franpreview").click(function () {
    callgetFranchise();
  });

  $("#frannew").click(function () {
    window.location.href = "franchise.php";
  });

  $("#franview").click(function(){
    if ($("#frantrcode").val() != "") {
      window.location.href = "franchise.php?xre=" + $("#frantrcode").val();
    } else {
      notif("Warning", "Select a transaction before viewing..", "warning");
    }
  });

  $("#release").click(function(){
    $("#reltrcode").val($("#trcode").val());
    $("#relfullname").val($("#opfullname").val());
    $("#reltbody").val($("#optodabody").val());
    $("#relapplstatus").val($("#applstatus").val());
    $.ajax({
      url: "../config/includes.php?var=getdetassrelease",
      method: "POST",
      data: {trcode: $('#trcode').val()},
      dataType: "json",
      async: false,
      success: function (data) {
          $(".assappend").remove();
        for (var i = 0; i < data.length; i++) {
          $('.asstable').append("<tr class='assappend'>" + "<td>"+data[i]['Fees']+"</td>" + "<td>"+data[i]['AmtDue']+"</td>" + "<td>"+data[i]['or_number']+"</td>" + "<td>"+data[i]['or_date']+"</td>" + "</tr>");
        }
          $("#relmtp").val(data[0]["franchise_no"]);
          $("#relfranexp").val(data[0]["dtexprd"]);
          $("#relprovi").val(data[0]["isprovi"]);
          $("#relissticker").val(data[0]["issticker"]);
          $("#relsticker").val(data[0]["stickerno"]);
      }
    });
    $("#releasing").modal('show');
  });

  $("#releasedrop").click(function(){
    $("#dreltrcode").val($("#dtrcode").val());
    $("#drelfullname").val($("#dopfullname").val());
    $("#dreltbody").val($("#doptodabody").val());
    $("#drelapplstatus").val('DROPPING');
    $("#releasingdrop").modal('show');
  });

  $("#printassess").click(function () {
    var win = window.open("print-assessment.php?xre="+$("#asstrcode").val());
    if (win) {
      win.focus();
    } else {
      alert("Please allow pop-ups for this website.");
    }
  });

  $("#printrelease").click(function () {
    var win = window.open("print-release.php?xre="+$("#reltrcode").val());
    if (win) {
      win.focus();
    } else {
      alert("Please allow pop-ups for this website.");
    }
  });

  $("#printdroprelease").click(function () {
    var win = window.open("print-release-drop.php?xre="+$("#dtrcode").val());
    if (win) {
      win.focus();
    } else {
      alert("Please allow pop-ups for this website.");
    }
  });

  $("#rptprint").click(function () {
    var win = window.open("print-rpt-franchise.php?yr="+$("#rptfranyr").val());
    if (win) {
      win.focus();
    } else {
      alert("Please allow pop-ups for this website.");
    }
  });

  //=====================================================================================================
  // Buttons click and forms saving
  //=====================================================================================================

  $("#new").click(function(){
    ctrl = "new";
    clearbox();
    $("#opercode, #firstname, #midinit, #lastname, #bday, #age, #gender, #civstats, #hse, #blk, #lot, #st, #subd, #brgy, #mun, #prov, #drivlic, #drivissue, #drivplace, #contact, #ctc, #ctcissue, #ctcplace, #emername, #emercontact, #emeraddr, #remarks, #save, #cancel, #image_selector").attr("disabled", false);
    $("#gender").val("Male");
    $("#civstats").val("Single");
    $("#new, #edit, #delete, #select").attr("disabled", true);
  });

  $("#dnew").click(function(){
    ctrl = "new";
    clearbox();
    $("#dsave, #dcancel, #drivefname, #drivemname, #drivelname, #drivectcno, #drivectcat, #drivectcon").attr("disabled", false);
    $("#dnew, #dedit, #ddelete, #dselect").attr("disabled", true);
  });

  $("#mnew").click(function(){
    ctrl = "new";
    $("#mopcode, #mname, #maddress, #mplate, #mmtop, #mid, #mbody, #mtoda, #mmake, #mengine, #mchassis, #myrmodel, #mcolor, #mmtpyr, #mcert, #mdtissue").val("");
    $("#msave, #mcancel, #mopcode, #mbody, #mtoda, #mmake, #mengine, #mchassis, #myrmodel, #mcolor, #mmtpyr, #mcert, #mdtissue, #mplate, #magency, #mremarks").attr("disabled", false);
    $("#mnew, #medit, #mdelete, #mselect").attr("disabled", true);
  });

  $("#dcancel").click(function(){
    if (ctrl == "add") {
      clearbox();
    }
    ctrl = "";
    $("#dsave, #dcancel, #drivefname, #drivemname, #drivelname, #drivectcno, #drivectcat, #drivectcon").attr("disabled", true);
    $("#dnew, #dedit, #ddelete, #dselect").attr("disabled", false);
    $("#dedit").html('<i class="fa fa-pencil-square-o"></i> Edit');
  });

  $("#cancel").click(function(){
    if (ctrl == "add") {
      clearbox();
    }
    ctrl = "";
    $("#opercode, #firstname, #midinit, #lastname, #bday, #age, #gender, #civstats, #hse, #blk, #lot, #st, #subd, #brgy, #mun, #prov, #drivlic, #drivissue, #drivplace, #contact, #ctc, #ctcissue, #ctcplace, #emername, #emercontact, #emeraddr, #remarks, #save, #cancel, #image_selector").attr("disabled", true);
    $("#new, #edit, #delete, #select").attr("disabled", false);
    $("#edit").html('<i class="fa fa-pencil-square-o"></i> Edit');
  });

  $("#mcancel").click(function(){
    if (ctrl == "new") {
      clearbox();
    }
    ctrl = "";
    $("#msave, #mcancel, #mopcode, #mbody, #mtoda, #mmake, #mengine, #mchassis, #myrmodel, #mcolor, #mmtpyr, #mcert, #mdtissue, #mplate, #magency, #mremarks").attr("disabled", true);
    $("#mnew, #medit, #mdelete, #mselect").attr("disabled", false);
    $("#medit").html('<i class="fa fa-pencil-square-o"></i> Edit');
  });

   $("#formshit").submit(function(e){
    e.preventDefault();
    url = $(this).attr("action");
    type = $(this).attr("method");
    var data = new FormData($(this)[0]);
    data.append('id', $(this).attr('id'));
    $.ajax({
      url:url,
      type:type,
      data: data,
      processData: false,
      contentType: false,
      success: function (answer) {
        if (answer == 1) {
            callgetOperators();
             new PNotify({
                title: 'Successful',
                text: 'Record has been successfully saved to the system.',
                type: 'success',
                styling: 'bootstrap3',
                delay: 3000
            });
            $("#opercode, #firstname, #midinit, #lastname, #bday, #age, #gender, #civstats, #hse, #blk, #lot, #st, #subd, #brgy, #mun, #prov, #drivlic, #drivissue, #drivplace, #contact, #ctc, #ctcissue, #ctcplace, #emername, #emercontact, #emeraddr, #remarks, #save, #cancel").attr("disabled", true);
            $("#new, #edit, #delete, #select").attr("disabled", false);
            ctrl = "";
            clearbox();
          } else {
            new PNotify({
                title: 'Error',
                text: 'Firstname and Lastname is the minimum requirement for me to save it.',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000
            });
          }
      }
    });
   });

   $("#formfuck").submit(function(e){
    e.preventDefault();
    url = $(this).attr("action");
    type = $(this).attr("method");
    var data = new FormData($(this)[0]);
    data.append('id', $(this).attr('id'));
    $.ajax({
      url:url,
      type:type,
      data: data,
      processData: false,
      contentType: false,
      success: function (answer) {
        if (answer == 1) {
            callgetDrivers();
             new PNotify({
                title: 'Successful',
                text: 'Record has been successfully saved to the system.',
                type: 'success',
                styling: 'bootstrap3',
                delay: 3000
            });
            $("#dsave, #dcancel, #drivefname, #drivemname, #drivelname, #drivectcno, #drivectcat, #drivectcon").attr("disabled", true);
            $("#dnew, #dedit, #ddelete, #dselect").attr("disabled", false);
            ctrl = "";
            clearbox();
          } else {
            new PNotify({
                title: 'Error',
                text: 'Firstname and Lastname is the minimum requirement for me to save it.',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000
            });
          }
      }
    });
   });


  $("#msave").click(function () {
    $.ajax({
      url: "../config/includes.php?var=savemotor",
      method: "POST",
      data: {
        mopcode: $("#mopcode").val(),
        mbody: $("#mbody").val(),
        mtoda: $("#mtoda").val(),
        mmake: $("#mmake").val(),
        mengine: $("#mengine").val(),
        mchassis: $("#mchassis").val(),
        myrmodel: $("#myrmodel").val(),
        mcolor: $("#mcolor").val(),
        mmtpyr: $("#mmtpyr").val(),
        mcert: $("#mcert").val(),
        mdtissue: $("#mdtissue").val(),
        mplate: $("#mplate").val(),
        magency: $("#magency").val(),
        mremarks: $("#mremarks").val(),
      },
      dataType: "JSON",
      success: function (data) {
        if (data.result) {
          $("#mid").val(data.motorid);
          $("#msave, #mcancel, #mopcode, #mbody, #mtoda, #mmake, #mengine, #mchassis, #myrmodel, #mcolor, #mmtpyr, #mcert, #mdtissue, #mplate, #magency, #mremarks").attr("disabled", true);
          $("#mnew, #medit, #mdelete, #mselect").attr("disabled", false);
          callgetMotor();
          notif("Save", data.msg, "success");
        } else {
          notif("Error", data.msg, "danger");
        }
      }
    });
  });

  $("#delete").click(function () {
    $.ajax({
      url: "../config/includes.php?var=deleteoperator",
      method: "POST",
      data: {opcode: $("#opercode").val()},
      dataType: "JSON",
      success: function (data) {
        if (data.result) {
          clearbox();
          notif("Delete", data.msg, "success");
          callgetOperators();
        }
      }
    });
  });

  $("#mdelete").click(function () {
    $.ajax({
      url: "../config/includes.php?var=deletemotor",
      method: "POST",
      data: {mid: $("#mid").val()},
      dataType: "JSON",
      success: function (data) {
        if (data.result) {
          clearbox();
          notif("Delete", data.msg, "success");
          callgetMotor();
        }
      }
    });
  });

  $("#medit").click(function(){
    if ($("#mid").val() == "") {
      new PNotify({
        title: 'Warning',
        text: 'Select a Motor in order to use the edit button.',
        styling: 'bootstrap3',
        delay: 3000
      });
      return;
    }

    ctrl = "edit";

    if ($(this).html() == '<i class="fa fa-pencil-square-o"></i> Edit') {
      $(this).html('<i class="fa fa-pencil-square"></i> Update');
      $("#mnew, #mdelete, #msave , #mselect").attr("disabled", true);
      $("#mcancel, #mopcode, #mbody, #mtoda, #mmake, #mengine, #mchassis, #myrmodel, #mcolor, #mmtpyr, #mcert, #mdtissue, #mplate, #magency, #mremarks").attr("disabled", false);
    } else if ($(this).html() == '<i class="fa fa-pencil-square"></i> Update') {
      $.ajax({
        url: "../config/includes.php?var=updatemotor",
        method: "POST",
        data: {
          mopcode: $("#mopcode").val(),
          mid: $("#mid").val(),
          mbody: $("#mbody").val(),
          mtoda: $("#mtoda").val(),
          mmake: $("#mmake").val(),
          mengine: $("#mengine").val(),
          mchassis: $("#mchassis").val(),
          myrmodel: $("#myrmodel").val(),
          mcolor: $("#mcolor").val(),
          mmtpyr: $("#mmtpyr").val(),
          mcert: $("#mcert").val(),
          mdtissue: $("#mdtissue").val(),
          mplate: $("#mplate").val(),
          magency: $("#magency").val(),
          mremarks: $("#mremarks").val(),
        },
        dataType: "JSON",
        success: function (answer) {
          if (answer.result) {
           $("#medit").html('<i class="fa fa-pencil-square-o"></i> Edit');
            callgetMotor();
             new PNotify({
                title: 'Successful',
                text: answer.msg,
                type: 'success',
                styling: 'bootstrap3',
                delay: 3000
            });
            $("#mcancel, #mopcode, #mbody, #mtoda, #mmake, #mengine, #mchassis, #myrmodel, #mcolor, #mmtpyr, #mcert, #mdtissue, #mplate, #magency, #mremarks").attr("disabled", true);
            $("#mnew, #mdelete, #mselect").attr("disabled", false);
            ctrl = "";
          } else {
            new PNotify({
                title: 'Error',
                text: answer.msg,
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000
            });
          }
        }
      });
    } else {
      return;
    }
  });

//====================================================================================================
//  Puro form at saving sa taas pero di lahat
//=====================================================================================================

//===================================================================================================
// For assessment function
//=====================================================================================================
  
  totamt = 0;
  sur = 0;
  function comptot(){
    totamt = 0;
    for (var i = 0; i < $(".prz").length; i++) {
      if ($('#fees'+i).is(":checked")) {
        // console.log($("label[for='coll"+i+"']").text());
        if ($("label[for='coll"+i+"']").text() != "62") {
          // console.log($("label[for='prz"+i+"']").text());
          totamt += parseFloat($("label[for='prz"+i+"']").text());
        }
      }
    }
    // console.log(totamt);
  }

  function penalty_computation (month) {
    if (month > 3 && month <= 6) {
      return 25.00;
    } else if (month > 6 && month <= 9) {
      return 50.00;
    } else if (month > 9 && month <= 12) {
      return 75.00;
    }
  }

  var assessmenttable = "";
  $("#assess").click(function(){
    $("#asstrcode").val($("#trcode").val());
    $("#assfullname").val($("#opfullname").val());
    $("#asstbody").val($("#optodabody").val());
    $("#assapplstatus").val($("#applstatus").val());
    $("#assessment-datatable").DataTable().destroy();
    assessmenttable = $("#assessment-datatable").DataTable({
      ajax: {
        url: "/mtop_pila/config/includes.php?var=getassfees&type=FRAN",
        method: "GET"
      },
      columns: [
        {data: null, defaultContent: "<input type='checkbox' id='selectpay'>", className: "text-center"},
        {data: "Fees"},
        {data: "AmtDue"}
      ],
      filter: false,
      bInfo: false,
      sort: false,
      paging: false,
      initComplete: function (setting, json){
        var date = new Date();
        var month = date.getMonth() + 1;
        var i = 0
        $.map(json.data, function (item) {
          if (item.collnature == "62") {
            assessmenttable.cell(i, 2).data(penalty_computation(month)).draw();
            console.log(penalty_computation(month))
          }
          i++;
        });
      }
    });
    $("#assessment").modal('show');
  });


  $("#assessment-datatable tbody").on("click", "#selectpay", function () {
    var tr = $(this).closest("tr");
    var idx = assessmenttable.row(tr).index();
    var data = assessmenttable.row(tr).data();
    if ($(this).is(":checked")) {
      $("#assessment-datatable tbody tr:eq(" + idx + ")").addClass("selected");
      totamt += parseFloat(data.AmtDue);
    } else {  
      $("#assessment-datatable tbody tr:eq(" + idx + ")").removeClass("selected");
      totamt -= parseFloat(data.AmtDue);
    }
    $("#total-assess").html(totamt);
  });


  $("#saveass").click(function () {
    var data = assessmenttable.rows('.selected').data();
    var spay = [];
    $.map(data, function (item) {
      spay.push(item);
    });

    if (spay.length == 0) {
      notif("Warning", "No fees checked has been detected. Please select fees.", "warning");
      return;
    }


    $.ajax({
      url: "/mtop_pila/config/includes.php?var=saveassessment",
      method: "POST",
      data:{spay: spay, trcode: $("#asstrcode").val()},
      dataType: "json",
      success: function (data) {
        if (data['result']) {
          notif("Assessment Successful", data['msg'], "success");
        } else if (!data['result']) {
          notif("Error occured", data['msg'], "error");
        } else {
          notif("Error occured", "Call the administrator, QUICKLY!!!", "error");
        }
      }
    });
  });




//=====================================================================================================
// Random stuff below
//=====================================================================================================

  $("#select").click(function(){
    var addr = "";
    $("#opcode").val($("#opercode").val());
    $("#opfullname").val($("#firstname").val() + " " + $("#lastname").val());
    // ($("#hse").val() == "") ? "" : addr = addr + $("#hse").val() + " ";
    // ($("#blk").val() == "") ? "" : addr = addr + $("#blk").val() + " ";
    // ($("#lot").val() == "") ? "" : addr = addr + $("#lot").val() + " ";
    // ($("#st").val() == "") ? "" : addr = addr + $("#st").val() + " ";
    // ($("#subd").val() == "") ? "" : addr = addr + $("#subd").val() + " ";
    // ($("#brgy").val() == "") ? "" : addr = addr + $("#brgy").val() + " ";
    // ($("#mun").val() == "") ? "" : addr = addr + $("#mun").val() + " ";
    // ($("#prov").val() == "") ? "" : addr = addr + $("#prov").val();
    $("#opaddress").val($("#subd").val());
    $("#opcontact").val($("#contact").val());
    $("#operimg").attr("src", $("#operator_image").attr("src"))
    $("#opdriver").modal('hide');
  });

  $("#dselect").click(function() {
    if ($("#drivecode").val() == "") {
      notif("Warning", "Pick an operator to proceed..");
      return;
    }
    $("#drcode").val($("#drivecode").val());
    $("#drfullname").val($("#drivefname").val() + " " + $("#drivelname").val());
    $("#drivers").modal('hide');
  });

  $("#mselect").click(function(){
    $("#opmotorcode").val($("#mid").val());
    $("#optodabody").val($("#mtoda").val() + " - #" + $("#mbody").val());
    $("#opmake").val($("#mmake").val());
    $("#opengine").val($("#mengine").val());
    $("#opchassis").val($("#mchassis").val());
    $("#opplate").val($("#mplate").val());
    $("#motor").modal('hide');
  });

  $("#mopcode").change(function(){
    if ($(this).val() != "") {
      $.ajax({
        url: "../config/includes.php?var=getopmotor",
        method: "POST",
        data: {code:$(this).val()},
        dataType: "json",
        success: function(data){
          if (data != "") {
            $("#mname").val(data[0]['fullname']);
            $("#maddress").val(data[0]['addr']);
          } else {
            $("#mname").val('');
            $("#maddress").val('');
            alert("Walang record.");
          }
        }
      });
    }
  });

  $("#selectop").click(function(){
    callgetOperators();
    $("#opdriver").modal('show');
    clearbox();
  });

  $("#selectdr").click(function(){
    $("#drivers").modal('show');
    callgetDrivers();
    clearbox();
  });


  $("#addmotor").click(function(){
    callgetMotor();
    $("#motor").modal('show');
    clearbox();
  });

  $("#edit").click(function(){
    if ($("#opercode").val() == "") {
      new PNotify({
        title: 'Warning',
        text: 'Select an Applicant in order to use the edit button.',
        styling: 'bootstrap3',
        delay: 3000
      });
      return;
    }

    ctrl = "edit";

    if ($("#gender").val() == "" || $("#gender").val() == null) {
      $("#gender").val("Male");
    }
    if ($("#civstats").val() == "" || $("#civstats").val() == null) {
      $("#civstats").val("Single");
    }
    if ($(this).html() == '<i class="fa fa-pencil-square-o"></i> Edit') {
      $(this).html('<i class="fa fa-pencil-square"></i> Update');
      $("#new, #delete, #save, #select").attr("disabled", true);
      $("#opercode, #firstname, #midinit, #lastname, #bday, #age, #gender, #civstats, #hse, #blk, #lot, #st, #subd, #brgy, #mun, #prov, #drivlic, #drivissue, #drivplace, #contact, #ctc, #ctcissue, #ctcplace, #emername, #emercontact, #emeraddr, #remarks, #cancel, #image_selector").attr("disabled", false);
    } else if ($(this).html() == '<i class="fa fa-pencil-square"></i> Update') {
      url = "../config/includes.php?var=updateoperator";
      type = "POST";
      var data = new FormData($("#formshit")[0]);
      data.append('id', $("#formshit").attr('id'));
      $.ajax({
        url:url,
        type:type,
        data: data,
        processData: false,
        contentType: false,
        success: function (answer) {
          if (answer == 1) {
             $("#edit").html('<i class="fa fa-pencil-square-o"></i> Edit');
              callgetOperators();
               new PNotify({
                  title: 'Successful',
                  text: 'Record has been updated successfully.',
                  type: 'success',
                  styling: 'bootstrap3',
                  delay: 3000
              });
              $("#opercode, #firstname, #midinit, #lastname, #bday, #age, #gender, #civstats, #hse, #blk, #lot, #st, #subd, #brgy, #mun, #prov, #drivlic, #drivissue, #drivplace, #contact, #ctc, #ctcissue, #ctcplace, #emername, #emercontact, #emeraddr, #remarks, #save, #cancel").attr("disabled", true);
              $("#new, #edit, #delete, #select").attr("disabled", false);
              ctrl = "";
            } else {
              new PNotify({
                  title: 'Error',
                  text: 'Firstname and Lastname is the minimum requirement for me to save it.',
                  type: 'error',
                  styling: 'bootstrap3',
                  delay: 3000
              });
            }
        }
      });
    } else {
      return;
    }
  });

  $("#dedit").click(function(){
    if ($("#drivecode").val() == "") {
      new PNotify({
        title: 'Warning',
        text: 'Select an Operator in order to use the edit button.',
        styling: 'bootstrap3',
        delay: 3000
      });
      return;
    }

    ctrl = "edit";
    if ($(this).html() == '<i class="fa fa-pencil-square-o"></i> Edit') {
      $(this).html('<i class="fa fa-pencil-square"></i> Update');
      $("#dnew, #ddelete, #dsave, #dselect").attr("disabled", true);
       $("#dcancel, #drivefname, #drivemname, #drivelname, #drivectcno, #drivectcat, #drivectcon").attr("disabled", false);
    } else if ($(this).html() == '<i class="fa fa-pencil-square"></i> Update') {
      url = "../config/includes.php?var=updatedriver";
      type = "POST";
      var data = new FormData($("#formfuck")[0]);
      data.append('id', $("#formfuck").attr('id'));
      $.ajax({
        url:url,
        type:type,
        data: data,
        processData: false,
        contentType: false,
        success: function (answer) {
          if (answer == 1) {
             $("#dedit").html('<i class="fa fa-pencil-square-o"></i> Edit');
              callgetDrivers();
               new PNotify({
                  title: 'Successful',
                  text: 'Record has been updated successfully.',
                  type: 'success',
                  styling: 'bootstrap3',
                  delay: 3000
              });
              $("#dsave, #dcancel, #drivefname, #drivemname, #drivelname, #drivectcno, #drivectcat, #drivectcon").attr("disabled", true);
              $("#dnew, #dedit, #ddelete, #dselect").attr("disabled", false);
              ctrl = "";
            } else {
              new PNotify({
                  title: 'Error',
                  text: 'Firstname and Lastname is the minimum requirement for me to save it.',
                  type: 'error',
                  styling: 'bootstrap3',
                  delay: 3000
              });
            }
        }
      });
    } else {
      return;
    }
  });

  $("#franchisetable").on('click', 'tr', function(){
    var data_row = $("#franchisetable").DataTable().row($(this).closest('tr')).data();
    $("#frantrcode").val(data_row[0]);
  });

  $("#droplisttable").on('click', 'tr', function(){
    var data_row = $("#droplisttable").DataTable().row($(this).closest('tr')).data();
    $("#dropmotorcode").val(data_row['motorid']);
  });

  $("#droppingtable").on('click', 'tr', function(){
    var data_row = $("#droppingtable").DataTable().row($(this).closest('tr')).data();
    $("#droptrcode").val(data_row[0]);
  });

  $('#operatortable tbody').on( 'click', 'tr', function () {
    if (ctrl == "") {
      var data_row = $("#operatortable").DataTable().row($(this).closest('tr')).data();
      $.ajax({
        url: "../config/includes.php?var=getdetoperator",
        method: "POST",
        data: {code:data_row[0]},
        dataType: "json",
        success: function(data){
          console.log(data)
          $("#opercode").val(data[0]['file_id']);
          $("#firstname").val(data[0]['own_fn']);
          $("#midinit").val(data[0]['own_mi']);
          $("#lastname").val(data[0]['own_ln']);
          $("#bday").val(data[0]['bday']);
          $("#age").val(data[0]['age']);
          $("#gender").val(data[0]['gender']);
          $("#civstats").val(data[0]['civilstat']);
          $("#hse").val(data[0]['hse_no']);
          $("#blk").val(data[0]['blk_no']);
          $("#lot").val(data[0]['lot_no']);
          $("#st").val(data[0]['st']);
          $("#brgy").val(data[0]['brgy']);
          $("#subd").val(data[0]['subdivision']);
          $("#prov").val(data[0]['prov']);
          $("#mun").val(data[0]['Mun']);
          $("#drivlic").val(data[0]['drivlis']);
          $("#drivissue").val(data[0]['dateissued']);
          $("#drivplace").val(data[0]['placeissued']);
          $("#contact").val(data[0]['cont_no']);
          $("#ctc").val(data[0]['certno']);
          $("#ctcissue").val(data[0]['certon']);
          $("#ctcplace").val(data[0]['certat']);
          $("#remarks").val(data[0]['remarks']);
          $("#emername").val(data[0]['conperson']);
          $("#emercontact").val(data[0]['conconnum']);
          $("#emeraddr").val(data[0]['conadress']);
          $("#operator_image").attr("src",data[0]['file_name']);
          $("#image_selector").val("");
          $("#hiddenimage").val(data[0]['opdr']);
        },
        error: function (data) {
          console.log(data);
        }
      });
    }
  }); 


  $('#drivertable tbody').on( 'click', 'tr', function () {
    if (ctrl == "") {
      var data_row = $("#drivertable").DataTable().row($(this).closest('tr')).data();
      $.ajax({
        url: "../config/includes.php?var=getdetdriver",
        method: "POST",
        data: {code:data_row[0]},
        dataType: "json",
        success: function(data){
          console.log(data)
          $("#drivecode").val(data[0]['file_id']);
          $("#drivefname").val(data[0]['own_fn']);
          $("#drivemname").val(data[0]['own_mi']);
          $("#drivelname").val(data[0]['own_ln']);
          $("#drivectcno").val(data[0]['certno']);
          $("#drivectcat").val(data[0]['certat']);
          $("#drivectcon").val(Date.parse(data[0]['certon']).toString('yyyy-MM-dd'));
        },
        error: function (data) {
          console.log(data);
        }
      });
    }
  });

  $('#motortable tbody').on( 'click', 'tr', function () {
    if (ctrl == "") {
      var data_row = $("#motortable").DataTable().row($(this).closest('tr')).data();
      $.ajax({
        url: "../config/includes.php?var=getdetmotor",
        method: "POST",
        data: {motorid:data_row[0]},
        contenType: false,
        dataType: "json",
        success: function(data){
          $("#mopcode").val(data_row[7]);
          $("#mopcode").change();
          $("#mid").val(data['motorid']);
          $("#mbody").val(data['f1']);
          $("#mtoda").val(data['mo1']);
          $("#mmtop").val(data['franchise_no']);
          $("#mmake").val(data['mo2']);
          $("#mavailable").val(data['mo9']);
          $("#mengine").val(data['mo7']);
          $("#mchassis").val(data['mo5']);
          $("#myrmodel").val(data['mo3']);
          $("#mcolor").val(data['mo11']);
          $("#mmtpyr").val(data['foryear']);
          $("#mcert").val(data['creg']);
          $("#mdtissue").val(data['crdate']);
          $("#mplate").val(data['mo6']);
          $("#magency").val(data['f3']);
          $("#mremarks").val(data['remarks']);
        }
      });
    }
  });


  $("#submitapp").click(function(){
    if ($("#opmotorcode").val() == "" && $("#opcode").val() == "" && $("#drcode").val() == "") {
      notif("Error occured", "You must select an operator/motor to submit the form.", "error");
      return;
    }

    $.ajax({
      url: "../config/includes.php?var=submitfranchise",
      method: "POST",
      data: {
        opcode: $("#opcode").val(),
        drcode: $("#drcode").val(),
        opmotor: $("#opmotorcode").val(),
        yr: $("#applyr").val(),
        applstatus: $("#applstatus").val()
      },
      dataType: "json",
      success: function (data) {
        if (data['result']) {
          $("#trcode").val(data['trcode']);
          notif("Application Successful", data['msg'], "success");
          window.location.href = "franchise.php?xre="+data['trcode'];
        } else {
          notif("Error occured", data['msg'], "error");
        }
      }
    });
    
  });

  $("#submitdrop").click(function(){
    if ($("#dopmotorcode").val() == "" && $("#dopcode").val() == "" && $("#ddrcode").val() == "") {
      notif("Error occured", "You must select an operator/motor to submit the form.", "error");
      return;
    }

    if ($("#dreason").val() == "") {
      notif("Error occured", "Reason is a must..", "error");
      $("#dreason").focus();
      return;
    }

    $.ajax({
      url: "../config/includes.php?var=submitdrop",
      method: "POST",
      data: {
        opercode: $("#dopcode").val(),
        drivercode: $("#ddrcode").val(),
        motorcode: $("#dopmotorcode").val(),
        yr: $("#dapplyr").val(),
        reason: $("#dreason").val(),
        mtp: $("#dmtp").val()
      },
      dataType: "json",
      success: function (data) {
        if (data['result']) {
          $("#dtrcode").val(data['trcode']);
          notif("Application Successful", data['msg'], "success");
          window.location.href = "dropping.php?zed="+data['trcode']+"&asd=true";
        } else {
          notif("Error occured", data['msg'], "error");
        }
      }
    });
    
  });


  $("#saverelease").click(function () {
    $.ajax({
      url: "../config/includes.php?var=saverelease",
      method: "POST",
      data: {
        mtp: $("#relmtp").val(),
        mtpdt: $("#reldtissue").val(),
        dtexp: $("#relfranexp").val(),
        trcode: $("#reltrcode").val(),
        provi: $("#relprovi").val(),
        sticker: $("#relsticker").val(),
        dtissuestk: $("#reldtissuesticker").val(),
        stkexp: $("#relstickerexp").val(),
        isstk: $("#relissticker").val()
      },
      dataType: "json",
      success: function (data) {
        if (data['result']) {
          notif("Released Successful", data['msg'], "success");
        } else {
          notif("Error occured", data['msg'], "error");
        }
      }
    });
  });

  $("#dropnew").click(function(){
    callgetDropList();
    $("#droplist").modal('show');
  });

  $("#dropselect").click(function() {
    window.location.href = "dropping.php?zed="+$("#dropmotorcode").val()+"&asd=false";
  });

  $("#dropview").click(function(){
    window.location.href = "dropping.php?zed="+$("#droptrcode").val()+"&asd=true";
  });

  $("#savedroprelease").click(function(){
    $.ajax({
      url: "../config/includes.php?var=savedroprelease",
      method: "POST",
      data: {trcode: $("#dtrcode").val()},
      dataType: "json",
      success: function (data) {
        if (data['result']) {
          notif("Released", data['msg'], "success");
        } else {
          notif("Alert", data['msg'], "error");
        }
      }
    });
  });

  $("#reldropsaveorno").click(function(){
    if ($("#reldroporno").val() == "" ) {
      notif("Alert", "OR # is empty. Please enter value.", "warning");
      $("#reldroporno").focus();
      return;
    } 

    $.ajax({
      url: "../config/includes.php?var=savedropornorelease",
      method: "POST",
      data: {trcode: $("#dreltrcode").val(),orno: $("#reldroporno").val(), ordate: $("#reldropordate").val()},
      dataType: "json",
      success: function (data) {
        if (data['result']) {
          notif("Saving..", data['msg'], "success");
        } else {
          notif("Alert", data['msg'], "error");
        }
      }
    });
  });

  $("#relsaveorno").click(function(){
    $.ajax({
      url: "../config/includes.php?var=saveornorelease",
      method: "POST",
      data: {trcode: $("#reltrcode").val(),orno: $("#relorno").val(), ordate: $("#relordate").val()},
      dataType: "json",
      success: function (data) {
        if (data['result']) {
          notif("Saving..", data['msg'], "success");
        } else {
          notif("Alert", data['msg'], "error");
        }
      }
    });
  });

  //========================================================================================================================
  // TODA LIST
  //========================================================================================================================
  var toda = {};
  var todadatatbles = $("#todalist-datatable").DataTable({
      ajax: {
        url: "/mtop_pila/config/includes.php?var=getalltodadetails",
        method: "GET"
      },
      columns: [
        {data: "ID"},
        {data: "todacode"},
        {data: "todaRoute"},
        {data: "todaRemarks"}
      ],
      bInfo: false,
    });

  $("#todalist-datatable").on("click", "tr", function (){
    if (ctrl == "") {
      var data = todadatatbles.row($(this).closest("tr")).data();
      $("#todaid").val(data.ID);
      $("#todacode").val(data.todacode);
      $("#todaroute").val(data.todaRoute);
      $("#todaremarks").val(data.todaRemarks);
    }
  });

  $("#todanew").click(function () {
    ctrl = "new";
    $("#todanew, #todaedit, #todadelete").attr("disabled", true);
    $("#todacode, #todaroute, #todaremarks, #todasave, #todacancel").attr("disabled", false);
    $("#todaid, #todacode, #todaroute, #todaremarks").val("");
  });

  $("#todacancel").click(function () {
    if (ctrl == "edit") {
      $("#todaedit").html('<i class="fa fa-pencil-square-o"></i> Edit');
      $("#todanew, #todaedit, #todadelete").attr("disabled", false);
      $("#todacode, #todaroute, #todaremarks, #todasave, #todacancel").attr("disabled", true);
      $("#todacode").val(toda.todacode);
      $("#todaroute").val(toda.todaroute);
      $("#todaremarks").val(toda.todaremarks);
    } else {
      $("#todanew, #todaedit, #todadelete").attr("disabled", false);
      $("#todacode, #todaroute, #todaremarks, #todasave, #todacancel").attr("disabled", true);
      $("#todacode, #todaroute, #todaremarks").val("");
    }
    ctrl = "";
  });

  $("#todasave").click(function () {
    var data = $(':input').serializeArray();
    $.each(data, function (i, item) {
      toda[item.name] = item.value;
    });

    $.ajax({
      url: "/mtop_pila/config/includes.php?var=savetoda",
      method: "POST",
      data: toda,
      dataType: "JSON",
      success: function (e) {
        if (e.result) {
          notif("Saving..", e['msg'], "success");
          $("#todaid").val(e.todaid);
          ctrl = "";
          $("#todanew, #todaedit, #todadelete").attr("disabled", false);
          $("#todacode, #todaroute, #todaremarks, #todasave, #todacancel").attr("disabled", true);
          todadatatbles.ajax.reload();
        } else {
          notif("Alert", e['msg'], "error");
        }
      }
    });
  });

  $("#todaedit").click(function(){
    if ($("#todaid").val() == "") {
      notif("Warning", "Select a TODA in order to use the edit button.", "warning");
      return;
    }

    ctrl = "edit";
    if ($(this).html() == '<i class="fa fa-pencil-square-o"></i> Edit') {
      $(this).html('<i class="fa fa-pencil-square"></i> Update');
      $("#todanew, #todadelete, #todasave").attr("disabled", true);
      $("#todacode, #todaroute, #todaremarks, #todacancel").attr("disabled", false);
      var data = $(':input').serializeArray();
      $.each(data, function (i, item) {
        toda[item.name] = item.value;
      });
    } else if ($(this).html() == '<i class="fa fa-pencil-square"></i> Update') {
      var data = $(':input').serializeArray();
      $.each(data, function (i, item) {
        toda[item.name] = item.value;
      });
      $.ajax({
      url: "/mtop_pila/config/includes.php?var=updatetoda",
      method: "POST",
      data: toda,
      dataType: "JSON",
      success: function (e) {
        if (e.result) {
          $("#todaedit").html('<i class="fa fa-pencil-square-o"></i> Edit');
          notif("Updating..", e['msg'], "success");
          ctrl = "";
          $("#todanew, #todaedit, #todadelete").attr("disabled", false);
          $("#todacode, #todaroute, #todaremarks, #todasave, #todacancel").attr("disabled", true);
          todadatatbles.ajax.reload();
        } else {
          notif("Alert", e['msg'], "error");
        }
      }
    });
    } else {
      return;
    }
  });

  $("#todadelete").click(function () {
    if ($("#todaid").val() == "") {
      notif("Warning", "Select a TODA in order to use the delete button.", "warning");
      return;
    }

    $.ajax({
      url: "/mtop_pila/config/includes.php?var=deletetoda",
      method: "POST",
      data: {todaid: $("#todaid").val()},
      dataType: "JSON",
      success: function (e) {
        if (e.result) {
          notif("Deleting..", e['msg'], "success");
          $("#todanew, #todaedit, #todadelete").attr("disabled", false);
          $("#todacode, #todaroute, #todaremarks, #todasave, #todacancel").attr("disabled", true);
          $("#todaid, #todacode, #todaroute, #todaremarks").val("");
          todadatatbles.ajax.reload();
        } else {
          notif("Alert", e['msg'], "error");
        }
      }
    });
  });

  $("#rptmasterlistsearch").click(function () {
    $("#masterlist-franchise-datatable").DataTable().destroy();
    $("#masterlist-franchise-datatable").DataTable({
      ajax: {
        url: "../config/includes.php?var=getmasterlistfran",
        method: "POST",
        data: {from:$("#from").val(), to:$("#to").val()},
        dataType: "json",
      },
      dom: "Blfrtip",
      buttons: [
      {
        extend: "copy",
        className: "btn-sm"
      },
      {
        extend: "csv",
        className: "btn-sm"
      },
      {
        extend: "excel",
        className: "btn-sm"
      },
      {
        extend: "pdfHtml5",
        className: "btn-sm"
      },
      {
        extend: "print",
        className: "btn-sm"
      },
      ],
      columns: [
        {data: "trcode"},
        {data: "appl_status"},
        {data: "mo1"},
        {data: "own_fn"},
        {data: "mo2"},
        {data: "mo7"},
        {data: "mo5"},
        {data: "mo6"},
        {data: "brgy"},
      ],
    });
  });
  //end of document
});