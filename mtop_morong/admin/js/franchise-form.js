//=========================================================================================================
//	FUNCTIONS AND VARIABLE (FAV)
//=========================================================================================================

var state = {};
var btype = "";

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




function statusButton(status) {
  if (status == "FOR ASSESSMENT") {
    return "<button class='btn btn-info' id='btn-view'><i class='fa fa-folder-open'></i></button>";
  } else if (status == "FOR PAYMENT") {
    return "<button class='btn btn-info' id='btn-view'><i class='fa fa-book-open'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button>";
  } else if (status == "RELEASED") {
    return "<button class='btn btn-success' id='btn-release'><i class='fa fa-check'></i></button> <button class='btn btn-success' id='btn-payment'><i class='fa fa-money-bill'></i></button> <button class='btn btn-info' id='btn-print-assess'><i class='fa fa-file'></i></button>";
  }
}

function printReleasePermit(data) {
  const printPage = async (sURL) => {
    var oHiddFrame = document.createElement("iframe");
    const printPromise = new Promise((resolve, reject) => {
      oHiddFrame.onload = function () {
        try {
          oHiddFrame.contentWindow.focus(); // Required for IE
          oHiddFrame.contentWindow.print();
          resolve();
        } catch (error) {
          reject(error);
        }
      };
    });
    oHiddFrame.style.position = "fixed";
    oHiddFrame.style.right = "0";
    oHiddFrame.style.bottom = "0";
    oHiddFrame.style.width = "0";
    oHiddFrame.style.height = "0";
    oHiddFrame.style.border = "0";
    oHiddFrame.src = sURL;
    document.body.appendChild(oHiddFrame);
    await printPromise;
  };
  // You'll need to make your image into a Data URL
  // Use http://dataurl.net/#dataurlmaker
  var doc = new jsPDF();
  function converttobase64(imgpath) {
    var img = new Image();
    img.src = imgpath;
    return img;
  }

  var imgData = converttobase64(data.target_path);

  doc.setFontSize(12);
  doc.text(57, 69, "Carmona, Cavite");
  doc.text(57, 79, data.fullname);
  doc.setFontSize(10);
  doc.text(57, 89, data.addr);
  doc.addImage(imgData, "JPEG", 160, 55, 35, 35);
  doc.setFontSize(12);
  doc.text(165, 97, data.franchise_no);
  doc.text(20, 108, data.mo1);
  doc.text(15, 128, data.mo2);
  doc.text(65, 128, data.mo5);
  doc.text(115, 128, data.mo7);
  doc.text(165, 128, data.mo6);
  doc.setFontSize(8);
  doc.text(165, 159, data.f3);
  doc.setFontSize(12);
  doc.text(82, 237, data.or_number);
  doc.text(82, 245, data.dtexprd);

  printPage(doc.output("bloburl")).catch((error) => {
    // Fallback printing method
    doc.autoPrint();
    doc.output("dataurlnewwindow");
  });
}

$(window).keydown(function (event) {
  if (event.keyCode == 13) {
    event.preventDefault();
    return false;
  }
});

if (getUrlParameter("trcode") !== undefined) {
  $.ajax({
    url: "../config/includes.php?var=getdetfranchise",
    method: "POST",
    data: {
      trcode: getUrlParameter("trcode"),
    },
    dataType: "JSON",
    success: function (e) {
      if (e) {
        state = e;
        $("#form-operatorid").html("<b>Operator ID: </b>" + e.opcode);
        $("#form-operatorname").html(e.fullname);
        $("#form-operatoraddress").html(e.addr);
        $("#form-operatorcontact").html(e.mobile_no);
        $("#displayStatus").append(statusDisplay(e.Tags));
        $("#displayFranStatus").append(
          franDisplay(e.dtexprd, e.status, e.remarks)
        );

        if (e.optp != "") {
          $("#form-operatorimg").attr("src", e.optp);
        }

        $("#form-driverid").html("<b>Driver ID: </b>" + e.drivercode);
        $("#form-drivername").html(e.drname);
        $("#form-driveraddress").html(e.draddr);
        $("#form-drivercontact").html(e.drcont_no);

        if (e.drtp != "") {
          $("#form-driverimg").attr("src", e.drtp);
        }
        state["motorid"] = e.motorpin;
        $("#form-motorid").html(e.motorpin);
        $("#form-motortoda").html(e.tbody);
        $("#form-motormake").html(e.make);
        $("#form-motorchassis").html(e.chassis);
        $("#form-motorengine").html(e.engine);
        $("#form-motorplate").html(e.plateno);
        $("#form-motorplatecolor").html(e.platecolor);
        $("#form-motorstickerexpdate").html(e.dtexprdstick);
        $("#form-franchiseexpdate").html(e.dtexprd);

        $("#form-motormtop").html(e.franchiseno);
        $("#form-lastrenew").html(e.last_renew);
        $("#form-trcode").html(e.trcode);
        $("#form-applicationtype").val(e.appl_status);
        $("#form-applicationyear").val(e.yr);

        callReqApplication(e.appl_status);
        
        $("#form-applicationtype").attr("disabled", true);
        $("#form-applicationyear").attr("disabled", true);
      }

      if (e.Tags == "FOR ASSESSMENT") {
        $("#btn-submit-franchise").remove();
        $("#btn-operator-release").remove();
        $("#btn-modal-driver").remove();
        $("#btn-modal-operator").remove();
        $("#btn-modal-motor").remove();
      } else if (e.Tags == "FOR PAYMENT") {
        $("#sameasoperator-inp").remove();
        $("#btn-modal-operator").remove();
        $("#btn-modal-driver").remove();
        $("#btn-modal-motor").remove();
        $("#btn-submit-franchise").remove();
        $("#btn-operator-print").remove();
      } else if (e.Tags == "FOR RELEASING" || e.Tags == "RELEASED") {
        $("#sameasoperator-inp").remove();
        $("#btn-submit-franchise").remove();
        $("#btn-operator-assessment").remove();
        $("#btn-modal-operator").remove();
        $("#btn-modal-driver").remove();
        $("#btn-modal-motor").remove();
      } else if (e.Tags == "FOR INSPECTION" || e.Tags == "DENIED") {
        $("#sameasoperator-inp").remove();
        $("#btn-operator-assessment").remove();
        $("#btn-submit-franchise").remove();
        $("#btn-operator-release").remove();
        $("#btn-modal-driver").remove();
        $("#btn-modal-operator").remove();
        $("#btn-modal-motor").remove();
      } else {
        $("#btn-operator-release").remove();
        $("#btn-operator-assessment").remove();
      }
    },
  });
} else {
  $("#btn-operator-release").remove();
  $("#btn-operator-assessment").remove();
}

$.ajax({
  url: "../config/includes.php?var=gettodaoption",
  method: "POST",
  dataType: "JSON",
  success: function (e) {
    $.map(e.data, function (x) {
      $("#mtoda").append(
        "<option value='" + x.todacode + "'>" + x.todacode + "</option>"
      );
    });
  },
});

$.ajax({
  url: "../config/includes.php?var=getapprovepersonel",
  method: "POST",
  dataType: "JSON",
  success: function (e) {
    $.map(e, function (x) {
      $("#relapprove").append(
        "<option value='" + x.app_id + "'>" + x.app_name + "</option>"
      );
    });
  },
});

var apyr = new Date();
$("#form-applicationyear option").remove();
for (var i = apyr.getFullYear(); i >= 2010; i--) {
  $("#form-applicationyear").append(
    "<option value='" + i + "'>" + i + "</option>"
  );
}

$("#form-applicationyear").val(apyr.getFullYear());

$("#application-menu").addClass("menu-is-opening menu-open");
$("#franchise-table").addClass("active");

//=============================================================================================================
// Operator Section
//=============================================================================================================

$("#btn-modal-operator").click(function () {
  callOperatorTable();
  $("#operator-modal").modal("show");
});

$("#operator-modal").on("shown.bs.modal", function () {
    loadPSGC(0);
});

$("#btn-modal-operator-view").click(function () {
  $.ajax({
    url: "../config/includes.php?var=getdetoperator",
    method: "POST",
    data: { code: state.opcode },
    dataType: "JSON",
    success: function (e) {
      $("#firstname").val(e.first_name);
      $("#midinit").val(e.middle_name);
      $("#lastname").val(e.last_name);
      $("#ext_name").val(e.ext_name);
      $("#bday").val(e.birth_date);
      $("#age").val(e.age);
      if (e.sex != "") {
        $("#gender").val(e.sex);
      }
      if (e.civil_status != "") {
        $("#civstats").val(e.civil_status);
      }
      $("#hse").val(e.address_house_no);
      $("#st").val(e.address_street_name);
      $("#subd").val(e.address_subdivision);
      state["region"] = e.psgc_region;
      state["prov"] = e.psgc_province;
      state["mun"] = e.psgc_municipality;
      state["brgy"] = e.psgc_brgy;
      $("#region").val(e.psgc_region).trigger("change");
      $("#prov").val(e.psgc_province);
      $("#mun").val(e.psgc_municipality);
      $("#brgy").val(e.psgc_brgy);

      $("#drivlic").val(e.drivlis);
      $("#drivissue").val(e.dateissued);
      $("#drivplace").val(e.placeissued);
      $("#contact").val(e.mobile_no);
      $("#ctc").val(e.certno);
      $("#ctcissue").val(e.certon);
      $("#ctcplace").val(e.certat);
      $("#emername").val(e.conperson);
      $("#emercontact").val(e.conconnum);
      $("#emeraddr").val(e.conaddress);
      $("#remarks").val(e.remarks);
      $("#hiddenimage").val(e.profile_img);
      $("#occupation").val(e.occupation);

      if (e.target_path != "") {
        $("#oper-img-alt").attr("src", e.target_path);
      } else {
        $("#oper-img-alt").attr("src", "../dist/img/operator.png");
      }
      $("#div-operator-table, #btn-operator-back, #btn-operator-save").hide();
      $("#div-operator-form, #btn-operator-edit").show();
      $("#operator-modal").modal("show");
    },
  });
});

$("#operator-modal").on("hidden.bs.modal", function () {
  $("#div-operator-table, #btn-operator-back, #btn-operator-save").show();
  $("#div-operator-form").hide();
});

$("#operatortable").on("click", "tr", function () {
  $("#operatortable tbody tr").removeClass("selected");
  $(this).addClass("selected");
});

$("#operatortable").on("dblclick", "tr", function () {
  var d = operatortable.row($(this)).data();
  state["opcode"] = d.humanpin;
  state["dlis"] = d.drivlis;
  $("#form-operatorid").html("<b>Operator ID: </b>" + d.humanpin);
  $("#form-operatorname").html(d.fullname);
  $("#form-operatoraddress").html(d.addr);
  $("#form-operatorcontact").html(d.mobile_no);
  if (d.target_path != "") {
    $("#form-operatorimg").attr("src", d.target_path);
  } else {
    $("#form-operatorimg").attr("src", "../dist/img/operator.png");
  }
  $("#operator-modal").modal("hide");
});

$("#operatortable tbody").on("click", "#btn-operator-select", function () {
  var d = operatortable.row($(this).closest('tr')).data();
  state["opcode"] = d.humanpin;
  state["dlis"] = d.drivlis;
  $("#form-operatorid").html("<b>Operator ID: </b>" + d.humanpin);
  $("#form-operatorname").html(d.fullname);
  $("#form-operatoraddress").html(d.addr);
  $("#form-operatorcontact").html(d.mobile_no);
  if (d.target_path != "") {
    $("#form-operatorimg").attr("src", d.target_path);
  } else {
    $("#form-operatorimg").attr("src", "../dist/img/operator.png");
  }
  $("#operator-modal").modal("hide");
});

$("#btn-create-operator").click(function () {
  $("#div-operator-table, #btn-operator-edit").hide();
  $("#div-operator-form").show();
});

$("#btn-operator-back").click(function () {
  $("#div-operator-form").hide();
  $("#div-operator-table").show();
});

$("#operator-form-submit").submit(function (e) {
  e.preventDefault();
  var url = "";
  if (btype == "insert") {
      url = "../config/includes.php?var=insertoperator";
  } else if (btype == "update") {
      url = "../config/includes.php?var=updateoperator&opercode=" + state.opcode;
  } else {
      Swal.fire("Notice!", "Something went wrong.", "warning");
      return;
  }
  var data1 = new FormData($("#operator-form-submit")[0]);
  data1.append("file", $("#oper-img")[0].files[0]);
  data1.append("brgydesc", $("#brgy :selected").text());
  data1.append("mundesc", $("#mun :selected").text());
  data1.append("provdesc", $("#prov :selected").text());
  data1.append("regiondesc", $("#region :selected").text());
  $.ajax({
    url: url,
    method: "POST",
    data: data1,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        if (btype == "insert") {
           state["opcode"] = e.ophumanpin;
        }
        btype = "";
        state["dlis"] = $("#drivlic").val();
        $("#form-operatorid").html("<b>Operator ID: </b>" + state["opcode"]);
        $("#form-operatorname").html(
          $("#firstname").val() +
            " " +
            $("#midinit").val() +
            " " +
            $("#lastname").val()
        );
        $("#form-operatoraddress").html(
          $("#hse").val() +
            " " +
            $("#st").val() +
            " " +
            $("#subd").val() +
            " " +
            $("#brgy :selected").val() +
            " " +
            $("#mun :selected").val() +
            " " +
            $("#prov :selected").val()
        );
        $("#form-operatorimg").attr("src", $("#oper-img-alt").attr("src"));
        $("#form-operatorcontact").html($("#contact").val());
        $("#operator-modal").modal("hide");
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-operator-save").click(function () {
  btype = "insert";
  $("#operator-form-submit").submit();
});

$("#btn-operator-edit").click(function () {
   btype = "update";
  $("#operator-form-submit").submit();
});

//=============================================================================================================
// Driver Section
//=============================================================================================================

$("#btn-modal-driver").click(function () {
  callDriverTable();
  $("#driver-modal").modal("show");
});

$("#driver-modal").on("shown.bs.modal", function () {

loadPSGC(1);
});

$("#btn-modal-driver-view").click(function () {
  $.ajax({
    url: "../config/includes.php?var=getdetdriver",
    method: "POST",
    data: { code: state.drivercode },
    dataType: "JSON",
    success: function (e) {
      $("#dfirstname").val(e.first_name);
      $("#dmidinit").val(e.middle_name);
      $("#dlastname").val(e.last_name);
      $("#dextname").val(e.ext_name);
      $("#dbday").val(e.birth_date);
      $("#dage").val(e.age);
      if (e.sex != "") {
        $("#gender").val(e.sex);
      }
      if (e.civil_status != "") {
        $("#civstats").val(e.civil_status);
      }
      $("#dhse").val(e.address_house_no);
      $("#dst").val(e.address_street_name);
      $("#dsubd").val(e.address_subdivision);
      state["region"] = e.psgc_region;
      state["prov"] = e.psgc_province;
      state["mun"] = e.psgc_municipality;
      state["brgy"] = e.psgc_brgy;
      $("#dregion").val(e.psgc_region).trigger("change");
      $("#dprov").val(e.psgc_province);
      $("#dmun").val(e.psgc_municipality);
      $("#dbrgy").val(e.psgc_brgy);

      $("#ddrivlic").val(e.drivlis);
      $("#ddrivissue").val(e.dateissued);
      $("#ddrivplace").val(e.placeissued);
      $("#dcontact").val(e.mobile_no);
      $("#dctc").val(e.certno);
      $("#dctcissue").val(e.certon);
      $("#dctcplace").val(e.certat);
      $("#dremarks").val(e.remarks);
      $("#dhiddenimage").val(e.profile_img);

      if (e.target_path != "") {
        $("#driver-img-alt").attr("src", e.target_path);
      } else {
        $("#driver-img-alt").attr("src", "../dist/img/driver.png");
      }

      $("#div-driver-table, #btn-driver-back, #btn-driver-save").hide();
      $("#div-driver-form, #btn-driver-edit").show();
      $("#driver-modal").modal("show");
    },
    error: function (xhr, ajaxOptions, thrownError) {
      Swal.fire("Ops!", "You haven't selected any driver yet.", "error");
    },
  });
});

$("#driver-modal").on("hidden.bs.modal", function () {
  $("#div-driver-table, #btn-driver-back, #btn-driver-save").show();
  $("#div-driver-form").hide();
});

$("#drivertable").on("click", "tr", function () {
  $("#drivertable tbody tr").removeClass("selected");
  $(this).addClass("selected");
});

$("#drivertable").on("dblclick", "tr", function () {
  var d = drivertable.row($(this)).data();
  if (d.drivlis == "") {
      Swal.fire("Ops!", "Operator doesn't have driver's license. Please edit the record.", "error");
      return;
  }
  state["drivercode"] = d.humanpin;
  $("#form-driverid").html("<b>Driver ID: </b>" + d.humanpin);
  $("#form-drivername").html(d.fullname);
  $("#form-driveraddress").html(d.addr);
  $("#form-drivercontact").html(d.mobile_no);
  if (d.target_path != "") {
    $("#form-driverimg").attr("src", d.target_path);
  } else {
    $("#form-driverimg").attr("src", "../dist/img/driver.png");
  }
  $("#driver-modal").modal("hide");
});

$("#drivertable").on("click", "#btn-driver-select", function () {
  var d = drivertable.row($(this).closest('tr')).data();
  if (d.drivlis == "") {
      Swal.fire("Ops!", "Operator doesn't have driver's license. Please edit the record.", "error");
      return;
  }
  state["drivercode"] = d.humanpin;
  $("#form-driverid").html("<b>Driver ID: </b>" + d.humanpin);
  $("#form-drivername").html(d.fullname);
  $("#form-driveraddress").html(d.addr);
  $("#form-drivercontact").html(d.mobile_no);
  if (d.target_path != "") {
    $("#form-driverimg").attr("src", d.target_path);
  } else {
    $("#form-driverimg").attr("src", "../dist/img/driver.png");
  }
  $("#driver-modal").modal("hide");
});

$("#btn-create-driver").click(function () {
  $("#div-driver-table, #btn-driver-edit").hide();
  $("#div-driver-form").show();
});

$("#btn-driver-back").click(function () {
  $("#div-driver-form").hide();
  $("#div-driver-table").show();
});

// $("#operator-form-submit").submit(function (e) {
// 	e.preventDefault();
// 	$.ajax({
// 		url: "../config/includes.php?var=insertoperator",
// 		method: "POST",
// 		data: $("#operator-form-submit").serialize(),
// 		dataType: "JSON",
// 		succcess: function (e) {
// 			console.log(e);
// 		}
// 	});
// });

$("#driver-form-submit").submit(function (e) {
    e.preventDefault();
    var url = "";
      if (btype == "insert") {
          url = "../config/includes.php?var=insertdriver";
      } else if (btype == "update") {
          url = "../config/includes.php?var=updatedriver&drivercode=" + state.drivercode;
      } else {
          Swal.fire("Notice!", "Something went wrong.", "warning");
          return;
      }
    var data1 = new FormData($("#driver-form-submit")[0]);
      data1.append("file", $("#driver-img")[0].files[0]);
      data1.append("dbrgydesc", $("#dbrgy :selected").text());
      data1.append("dmundesc", $("#dmun :selected").text());
      data1.append("dprovdesc", $("#dprov :selected").text());
      data1.append("dregiondesc", $("#dregion :selected").text());
      $.ajax({
        url: url,
        method: "POST",
        data: data1,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function (e) {
          if (e.result) {
            Swal.fire("Done!", e.msg, "success");
            if (btype == "insert") {
               state["drivercode"] = e.drcode;
            }
            btype = "";
            $("#form-drivername").html(
              $("#dfirstname").val() +
                " " +
                $("#dmidinit").val() +
                " " +
                $("#dlastname").val()
            );
            $("#form-driveraddress").html(
              $("#dhse").val() +
                " " +
                $("#dst").val() +
                " " +
                $("#dsubd").val() +
                " " +
                $("#dbrgy :selected").text() +
                " " +
                $("#dmun :selected").text() +
                " " +
                $("#dprov :selected").text()
            );
            $("#form-driverimg").attr("src", $("#driver-img-alt").attr("src"));
            $("#form-drivercontact").html($("#dcontact").val());
            $("#driver-modal").modal("hide");
          } else {
            Swal.fire("Ops!", e.msg, "error");
          }
        },
      });
  });

$("#btn-driver-save").click(function () {
  btype = "insert";
  $("#driver-form-submit").submit();
});

$("#btn-driver-edit").click(function () {
  btype = "update";
  $("#driver-form-submit").submit();
});

$("#driver-img").change(function (event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById("driver-img-alt");
    output.src = reader.result;
    base64 = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
});

//=============================================================================================================
// Motor Section
//=============================================================================================================

$("#btn-modal-motor").click(function () {
  callMotorTable();
});


$("#motor-form-submit").submit(function (e) {
    e.preventDefault();
    var url = "";
      if (btype == "insert") {
          url = "../config/includes.php?var=savemotor";
      } else if (btype == "update") {
          url = "../config/includes.php?var=updatemotor";
      } else {
          Swal.fire("Notice!", "Something went wrong.", "warning");
          return;
      }
    $.ajax({
        url: url,
        method: "POST",
        data: $("#motor-form-submit").serialize() + "&mid=" + state.motorid,
        dataType: "JSON",
        success: function (e) {
          if (e.result) {
            if (btype == "insert") {
                state["motorid"] = e.motorpin;    
            }
            btype = "";
            $("#mid").html(state["motorid"]);
            $("#form-motorid").html(state["motorid"]);
            $("#form-motortoda").html(
              $("#mtoda").val() + " - " + $("#mbody").val()
            );
            $("#form-motormake").html($("#mmake").val());
            $("#form-motorchassis").html($("#mchassis").val());
            $("#form-motorengine").html($("#mengine").val());
            $("#form-motorplate").html($("#mplate").val());
            $("#form-motorplatecolor").html($("#mplatecolor").val());
            Swal.fire("Done!", e.msg, "success");
            $("#motor-modal").modal("hide");
          } else {
            Swal.fire("Ops!", e.msg, "error");
          }
        },
      });
});

$("#btn-motor-save").click(function () {
    btype = "insert";
    $("#motor-form-submit").submit();
});

$("#btn-motor-edit").click(function () {
   btype = "update";
   $("#motor-form-submit").submit();
});

$("#motoroperatortable").on("click", "tr", function () {
  $("#motoroperatortable tbody tr").removeClass("selected");
  $(this).addClass("selected");
});

$("#motoroperatortable tbody").on("dblclick", "tr", function () {
  var d = motoroperatortable.row($(this)).data();
  $("#mopcode").val(d.humanpin).trigger("change");
  $("#motor-operator-modal").modal("hide");
});

$("#motor-operator-selected").click(function () {
  var d = motoroperatortable.row($("#motoroperatortable .selected")).data();
  $("#mopcode").val(d.humanpin).trigger("change");
  $("#motor-operator-modal").modal("hide");
});

$("#mopcode").change(function () {
  if ($(this).val() != "") {
    $.ajax({
      url: "../config/includes.php?var=getopmotor",
      method: "POST",
      data: { code: $(this).val() },
      dataType: "json",
      success: function (data) {
        if (data != "") {
          $("#mname").val(data["fullname"]);
          $("#maddress").val(data["addr"]);
          if (data.target_path !== null && data.target_path !== undefined && data.target_path != "") {
            $("#moper-img-alt").attr("src", data.target_path);
          } else {
            $("#moper-img-alt").attr("src", "../dist/img/operator.png");
          }
        } else {
          $("#mname").val("");
          $("#maddress").val("");
          Swal.fire(
            "Sorry",
            "We cannot find the opertator with this ID.",
            "error"
          );
        }
      },
    });
  }
});

$("#btn-motor-operator").click(function () {
  callMotorOperatorTable();
  $("#motor-operator-modal").modal("show");
});

$("#motortable").on("click", "tr", function () {
  $("#motortable tbody tr").removeClass("selected");
  $(this).addClass("selected");
});

$("#motortable").on("dblclick", "tr", function () {
  var d = motortable.row($(this)).data();
  state["motorid"] = d.motorpin;
  state["opcode"] = d.ophumanpin;
  $("#form-motorid").html(d.motorpin);
  $("#form-motortoda").html(d.todabody);
  $("#form-motormake").html(d.make);
  $("#form-motorchassis").html(d.chassis);
  $("#form-motorengine").html(d.engine);
  $("#form-motorplate").html(d.plateno);
  $("#form-motormtop").html(d.franno);
  $("#form-lastrenew").html(d.last_renew);
  $("#form-motorplatecolor").html(d.platecolor);
  $("#form-motorstickerexpdate").html(d.dtexprdstick);
  $("#form-franchiseexpdate").html(d.dtexprd);
  $("#displayFranStatus").append(
      franDisplay(d.dtexprd, "", "")
    );

  $("#form-operatorid").html("<b>Operator ID: </b>" + d.ophumanpin);
  $("#form-operatorname").html(d.opname);
  $("#form-operatoraddress").html(d.addr);
  $("#form-operatorcontact").html(d.opmobile_no);
  if (d.optp != "") {
    $("#form-operatorimg").attr("src", d.optp);
  } else {
    $("#form-operatorimg").attr("src", "../dist/img/operator.png");
  }

  if ($("#sameasoperator").is(":checked")) {
    state["drivercode"] = state.opcode;
    $("#form-driverid").html("<b>Driver ID: </b>" + state.opcode);
    $("#form-drivername").html($("#form-operatorname").html());
    $("#form-driveraddress").html($("#form-operatoraddress").html());
    $("#form-drivercontact").html($("#form-operatorcontact").html());
    $("#form-driverimg").attr("src", $("#form-operatorimg").attr("src"));
  } else {
    if (state["drivercode"] !== undefined && state["drivercode"] !== null) {
      if (state["drivercode"] == "") {
        state["drivercode"] = d.drhumanpin;
        $("#form-driverid").html("<b>Driver ID: </b>" + d.drhumanpin);
        $("#form-drivername").html(d.drname);
        $("#form-driveraddress").html(d.draddr);
        $("#form-drivercontact").html(d.drmobile_no);
        if (d.drtp != "") {
          $("#form-driverimg").attr("src", d.drtp);
        } else {
          $("#form-driverimg").attr("src", "../dist/img/driver.png");
        }
      }
    } else {
      state["drivercode"] = d.drhumanpin;
      $("#form-driverid").html("<b>Driver ID: </b>" + d.drhumanpin);
      $("#form-drivername").html(d.drname);
      $("#form-driveraddress").html(d.draddr);
      $("#form-drivercontact").html(d.drmobile_no);
      if (d.drtp != "") {
        $("#form-driverimg").attr("src", d.drtp);
      } else {
        $("#form-driverimg").attr("src", "../dist/img/driver.png");
      }
    }
  }

  $("#motor-modal").modal("hide");
});

$("#motortable").on("click", "#btn-motor-select", function () {
  var d = motortable.row($(this).closest('tr')).data();
  state["motorid"] = d.motorpin;
  state["opcode"] = d.ophumanpin;
  $("#form-motorid").html(d.motorpin);
  $("#form-motortoda").html(d.todabody);
  $("#form-motormake").html(d.make);
  $("#form-motorchassis").html(d.chassis);
  $("#form-motorengine").html(d.engine);
  $("#form-motorplate").html(d.plateno);
  $("#form-motormtop").html(d.franno);
  $("#form-lastrenew").html(d.last_renew);
  $("#form-motorplatecolor").html(d.platecolor);
  $("#form-motorstickerexpdate").html(d.dtexprdstick);
  $("#form-franchiseexpdate").html(d.dtexprd);
  $("#displayFranStatus").append(
      franDisplay(d.dtexprd, "", "")
    );

  $("#form-operatorid").html("<b>Operator ID: </b>" + d.ophumanpin);
  $("#form-operatorname").html(d.opname);
  $("#form-operatoraddress").html(d.addr);
  $("#form-operatorcontact").html(d.opmobile_no);
  if (d.optp != "") {
    $("#form-operatorimg").attr("src", d.optp);
  } else {
    $("#form-operatorimg").attr("src", "../dist/img/operator.png");
  }

  if ($("#sameasoperator").is(":checked")) {
    state["drivercode"] = state.opcode;
    $("#form-driverid").html("<b>Driver ID: </b>" + state.opcode);
    $("#form-drivername").html($("#form-operatorname").html());
    $("#form-driveraddress").html($("#form-operatoraddress").html());
    $("#form-drivercontact").html($("#form-operatorcontact").html());
    $("#form-driverimg").attr("src", $("#form-operatorimg").attr("src"));
  } else {
    if (state["drivercode"] !== undefined && state["drivercode"] !== null) {
      if (state["drivercode"] == "") {
        state["drivercode"] = d.drhumanpin;
        $("#form-driverid").html("<b>Driver ID: </b>" + d.drhumanpin);
        $("#form-drivername").html(d.drname);
        $("#form-driveraddress").html(d.draddr);
        $("#form-drivercontact").html(d.drmobile_no);
        if (d.drtp != "") {
          $("#form-driverimg").attr("src", d.drtp);
        } else {
          $("#form-driverimg").attr("src", "../dist/img/driver.png");
        }
      }
    } else {
      state["drivercode"] = d.drhumanpin;
      $("#form-driverid").html("<b>Driver ID: </b>" + d.drhumanpin);
      $("#form-drivername").html(d.drname);
      $("#form-driveraddress").html(d.draddr);
      $("#form-drivercontact").html(d.drmobile_no);
      if (d.drtp != "") {
        $("#form-driverimg").attr("src", d.drtp);
      } else {
        $("#form-driverimg").attr("src", "../dist/img/driver.png");
      }
    }
  }

  $("#motor-modal").modal("hide");
});

// $("#btn-modal-motor-view").click(function () {
//   $.ajax({
//     url: "../config/includes.php?var=getdetmotor",
//     method: "POST",
//     data: { motorid: state.motorid },
//     dataType: "JSON",
//     success: function (e) {
//       $("#mopcode").val(e.opercode).trigger("change");
//       $("#mid").html(e.motorpin);
//       $("#mbody").val(e.bodyno);
//       $("#mtoda").val(e.toda);
//       $("#mmtop").val(e.franchiseno);
//       $("#mmake").val(e.make);
//       $("#mavailability").html(e.status).trigger("change");
//       $("#mengine").val(e.engine);
//       $("#mchassis").val(e.chassis);
//       $("#myrmodel").val(e.yearmodel);
//       $("#mcolor").val(e.color);
//       $("#mmtpyr").html(e.foryear);
//       $("#mcert").val(e.crno);
//       $("#mmvno").val(e.mvno);
//       $("#mdtissue").val(e.crdate);
//       $("#mplate").val(e.plateno);
//       $("#magency").val(e.ltobranch);
//       $("#mremarks").val(e.remarks);
//       $("#mplatecolor").val(e.platecolor);
//       $("#morcrname").val(e.crname);
//       $("#morcr").val(e.orcr);
//       $("#morcrdate").val(e.orcrdate);
//       $("#mmunplateno").val(e.munplateno);
//       switchonoff("orcr-name-switch", e.crswitch);
//       if (e.crswitch == "on") {
//         $("#morcrname").attr("readonly", false);
//       }
//       $("#div-motor-table, #btn-motor-back, #btn-motor-save").hide();
//       $("#div-motor-form, #btn-motor-edit").show();
//       $("#motor-modal").modal("show");
//     },
//   });
// });

$("#btn-modal-motor-view").click(function () {
  $.ajax({
    url: "../config/includes.php?var=getdetmotor",
    method: "POST",
    data: { motorid: state.motorid },
    dataType: "JSON",
    success: function (e) {
      $("#mopcode").val(e.opercode).trigger("change");
      $("#mid").html(e.motorpin);
      $("#mbody").val(e.bodyno);
      $("#mtoda").val(e.toda);
      $("#mmtop").val(e.franchiseno);
      $("#mmake").val(e.make);
      $("#mavailability").html(e.status).trigger("change");
      $("#mengine").val(e.engine);
      $("#mchassis").val(e.chassis);
      $("#myrmodel").val(e.yearmodel);
      $("#mcolor").val(e.color);
      $("#mmtpyr").html(e.foryear);
      $("#mcert").val(e.crno);
      $("#mmvno").val(e.mvno);
      $("#mdtissue").val(e.crdate);
      $("#mplate").val(e.plateno);
      $("#magency").val(e.ltobranch);
      $("#mremarks").val(e.remarks);
      $("#mplatecolor").val(e.platecolor);
      $("#morcrname").val(e.crname);
      $("#morcr").val(e.orcr);
      $("#morcrdate").val(e.orcrdate);
      $("#mmunplateno").val(e.munplateno);
      $("#mexpired").val(e.dtexprd);
   
      switchonoff("orcr-name-switch", e.crswitch);
      if (e.crswitch == "on") {
        $("#morcrname").attr("readonly", false);
      }
      $("#div-motor-table, #btn-motor-back, #btn-motor-save").hide();
      $("#div-motor-form, #btn-motor-edit").show();
      $("#motor-modal").modal("show");
    },
  });
});

$("#motor-modal").on("hidden.bs.modal", function () {
  $("#div-motor-table, #btn-motor-back, #btn-motor-save").show();
  $("#div-motor-form").hide();
});

$("#mavailability").change(function () {
  if ($(this).html() == "AVAILABLE") {
    $(this).css("color", "lightgreen");
  } else if ($(this).html() == "UNAVAILABLE") {
    $(this).css("color", "red");
  } else {
    $(this).css("color", "white");
  }
});

$("#btn-create-motor").click(function () {
  $("#div-motor-table, #btn-motor-edit").hide();
  if (state["opcode"] !== undefined) {
    if (state["opcode"] != "") {
      $("#mopcode").val(state.opcode).trigger("change");
    }
  }
  $("#div-motor-form, #btn-motor-save").show();
});

$("#btn-motor-back").click(function () {
  $("#div-motor-form").hide();
  $("#div-motor-table").show();
});

//=============================================================================================================
// Submit Franchise Section
//=============================================================================================================
$("#form-applicationtype").change(function () {
    $("#form-applicationtype").removeClass('is-invalid');
});

$("#btn-submit-franchise").click(function () {
  if ($("#form-applicationtype").val() == null || $("#form-applicationtype").val() == "") {
    $("#form-applicationtype").addClass('is-invalid');
    return Swal.fire("Notice!", "Please select application type.", "warning");
  }
  state["yr"] = $("#form-applicationyear").val();
  state["applstatus"] = $("#form-applicationtype").val();
  
  $.ajax({
    url: "../config/includes.php?var=submitfranchise",
    method: "POST",
    data: state,
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire({
          icon: "success",
          text: e.msg,
          title: "Done!",
          showDenyButton: false,
          confirmButtonText: "Ok",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href =
              baseurl + "/admin/franchise-table.php";
          }
        });
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

//=============================================================================================================
// Assessment Section
//=============================================================================================================

$("#btn-operator-assessment").click(function () {
  callAssessmentTable($("#form-applicationtype").val());
});

//=============================================================================================================
// Releasing Section
//=============================================================================================================

$("#btn-operator-release").click(function () {
  callReleasingTable(getUrlParameter("trcode"));
  $("#release-modal").modal("show");
});

$("#btn-operator-save-release").click(function () {
  $.ajax({
    url: "../config/includes.php?var=saverelease",
    method: "POST",
    data: {
      mtp: $("#relmtp").val(),
      mtpdt: $("#reldtissue").val(),
      dtexp: $("#relfranexp").val(),
      trcode: state.trcode,
      provi: $("#relprovi").val(),
      sticker: $("#relsticker").val(),
      dtissuestk: $("#reldtissuesticker").val(),
      stkexp: $("#relstickerexp").val(),
      schoolname: $("#relschoolname").val(),
      remarks: $("#relremarks").val(),
    },
    dataType: "json",
    success: function (data) {
      if (data["result"]) {
        Swal.fire("Done!", data.msg, "success");
      } else {
        Swal.fire("Ops!", data.msg, "error");
      }
    },
  });
});

$("#btn-operator-print").click(function () {
  // window.location.href = "/mtop_dasma/admin/mtop-permit.php?trcode=" + state.trcode + "&app=" + $("#relapprove").val();
  $.ajax({
    url: "../config/includes.php?var=getpermitdetails",
    method: "POST",
    data: { trcode: state.trcode },
    dataType: "JSON",
    success: function (e) {
      printReleasePermit(e.data);
    },
  });
});

//================================================================================================================================
// Inspection Section
//================================================================================================================================
function switchonoff(id, val) {
  if (val !== undefined) {
    if (val == "on") {
      $("#" + id).prop("checked", true);
    } else {
      $("#" + id).prop("checked", false);
    }
  }
}

$("#btn-operator-inspection").click(function () {
  $.ajax({
    url:
      "../config/includes.php?var=getdetinspection&trcode=" +
      getUrlParameter("trcode"),
    method: "POST",
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        $("#inspect-trcode").val(e.data.trcode);
        $("#inspect-fullname").val(e.data.fullname);
        $("#inspect-address").val(e.data.addr);
        $("#inspect-toda").val(e.data.toda);

        $("#inspect-make").val(e.data.make);
        $("#inspect-engine").val(e.data.engine);
        $("#inspect-chassis").val(e.data.chassis);
        $("#inspect-bodyno").val(e.data.bodyno);
        $("#inspect-plateno").val(e.data.plateno);
        $("#inspect-fuel").val(e.data.fuel);
        $("#inspect-model").val(e.data.model);
        $("#inspect-yearacquired").val(e.data.yearacquired);

        $("#inspect-headlight").val(e.data.headlight);
        $("#inspect-signallight").val(e.data.signallight);
        $("#inspect-stoplight").val(e.data.stoplight);
        $("#inspect-handfootbrake").val(e.data.handfootbrake);
        $("#inspect-lightinsidecar").val(e.data.lightinsidecar);
        $("#inspect-trashcan").val(e.data.trashcan);
        $("#inspect-plate").val(e.data.plate);
        $("#inspect-drivlis").val(e.data.drivlis);

        switchonoff("inspect-headlight-switch", e.data.headlightSW);
        switchonoff("inspect-signallight-switch", e.data.signallightSW);
        switchonoff("inspect-stoplight-switch", e.data.stoplightSW);
        switchonoff("inspect-handfootbrake-switch", e.data.handfootbrakeSW);
        switchonoff("inspect-lightinsidecar-switch", e.data.lightinsidecarSW);
        switchonoff("inspect-trashcan-switch", e.data.trashcanSW);
        switchonoff("inspect-plate-switch", e.data.plateSW);
        switchonoff("inspect-drivlis-switch", e.data.drivlisSW);

        $("#inspection-modal").modal("show");
      }
    },
  });
});

$("#btn-inspect-save").click(function () {
  var data1 = new FormData($("#inspection-form-submit")[0]);
  data1.append("opercode", state.opcode);
  data1.append("motorid", state.motorid);
  $.ajax({
    url: "../config/includes.php?var=saveinspection",
    method: "POST",
    data: data1,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (e) {
      if (e.result) {
        Swal.fire("Done!", e.msg, "success");
        window.location.reload();
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

// $(".inspect-switch").click(function () {
// 	sid = $(this).attr("id");
// 	sid = sid.split("-");
// 	if ($(this).is(":checked")) {
// 		$("#"+sid[0]+"-"+sid[1]).attr("readonly", false);
// 	} else {
// 		$("#"+sid[0]+"-"+sid[1]).attr("readonly", true);
// 	}
// });

$("#inspect-result").change(function () {
  if ($("#inspect-result :selected").text() == "PASSED") {
    $(this).css("border-color", "green");
  } else if ($("#inspect-result :selected").text() == "FAILED") {
    $(this).css("border-color", "red");
  } else {
    $(this).css("border-color", "orange");
  }
});

//================================================================================================================================
// Additional Functions
//================================================================================================================================

var base64 = "";

$("#oper-img").change(function (event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById("oper-img-alt");
    output.src = reader.result;
    base64 = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
});

$("#bday").change(function () {
  var bdate = new Date($(this).val());
  var agecomp = Math.floor((apyr - bdate) / (365.25 * 24 * 60 * 60 * 1000));
  $("#age").val(agecomp);
});

$("#dbday").change(function () {
  var bdate = new Date($(this).val());
  var agecomp = Math.floor((apyr - bdate) / (365.25 * 24 * 60 * 60 * 1000));
  $("#dage").val(agecomp);
});

$("#sameasoperator").change(function () {
  if ($(this).is(":checked")) {
    if (
      state["opcode"] !== null &&
      state["opcode"] !== undefined &&
      state["opcode"] !== ""
    ) {
        if (state.dlis == undefined || state.dlis == "") {
            $(this).prop("checked", false);
            Swal.fire("Ops!", "Operator doesn't have driver's license. Please edit the record.", "error");
            return;
          }
      state["drivercode"] = state.opcode;
      $("#form-driverid").html("<b>Driver ID: </b>" + state.opcode);
      $("#form-drivername").html($("#form-operatorname").html());
      $("#form-driveraddress").html($("#form-operatoraddress").html());
      $("#form-drivercontact").html($("#form-operatorcontact").html());
      $("#form-driverimg").attr("src", $("#form-operatorimg").attr("src"));
    } else {
      $(this).prop("checked", false);
      Swal.fire(
        "Notice!",
        "Please select operator first before checking this.",
        "warning"
      );
    }
  } else {
    state["drivercode"] = "";
    $("#form-driverid").html("");
    $("#form-drivername").html("------------------------");
    $("#form-driveraddress").html("N/A");
    $("#form-drivercontact").html("N/A");
    $("#form-driverimg").attr("src", "../dist/img/driver.png");
  }
});

$("#btn-upload-pictures").click(function () {
  var data1 = new FormData($("#repapplication-form")[0]);
  data1.append("trcode", state.trcode);
  var d = reqapptable.rows().data();

  for (x = 1; x <= d.length; x++) {
    arr = $("#repapp-picture-" + x)[0].files[0];
    var y = reqapptable.row(x - 1).data();
    data1.append("req-img", $("#repapp-picture-" + x)[0].files[0]);
    data1.append("reqid", y.reqid);
    data1.append("reqdesc", y.reqdesc);
    data1.append("imgname", y.imgname);
    if (arr !== undefined) {
      $.ajax({
        url: "../config/includes.php?var=uploadrequirements",
        method: "POST",
        data: data1,
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function (e) {
          if (e.result) {
            Swal.fire("Done!", e.msg, "success");
            callReqApplication(state.appl_status);
          } else {
            Swal.fire("Ops!", e.msg, "error");
          }
        },
      });
    }
  }
});
