//=========================================================================================================
//	FUNCTIONS AND VARIABLE (FAV)
//=========================================================================================================

var state = {};
var base64 = "";

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

function getOperatorMotor(code) {
  $.ajax({
    url: "../config/includes.php?var=getopmotor",
    method: "POST",
    data: { code: code },
    dataType: "json",
    success: function (data) {
      if (data != "") {
        $("#mname").val(data["fullname"]);
        $("#maddress").val(data["addr"]);
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

$(window).keydown(function (event) {
  if (event.keyCode == 13) {
    event.preventDefault();
    return false;
  }
});

if (getUrlParameter("trcode") !== undefined) {
  $.ajax({
    url: "../config/includes.php?var=getdetdriverspermit",
    method: "POST",
    data: {
      trcode: getUrlParameter("trcode"),
    },
    dataType: "JSON",
    success: function (e) {
      if (e) {
        state = e;
        $("#form-operatorid").html("<b>Operator ID: </b>" + e.operCode);
        $("#form-operatorname").html(e.fullname);
        $("#form-operatoraddress").html(e.addr);
        $("#form-operatorcontact").html(e.cont_no);
        $("#displayStatus").append(statusDisplay(e.Tags));
        $("#displayFranStatus").append(
          franDisplay(e.dtexprd, e.status, e.remarks)
        );
        if (e.optp != "") {
          $("#form-operatorimg").attr("src", e.optp);
        }

        $("#form-driverid").html("<b>Operator ID: </b>" + e.drivercode);
        $("#form-drivername").html(e.drname);
        $("#form-driveraddress").html(e.draddr);
        $("#form-drivercontact").html(e.drcont_no);

        if (e.drtp != "") {
          $("#form-driverimg").attr("src", e.drtp);
        }

        $("#form-motorid").html(e.motorid);
        $("#form-motortoda").html(e.tbody);
        $("#form-motormake").html(e.mo2);
        $("#form-motorchassis").html(e.mo7);
        $("#form-motorengine").html(e.mo5);
        $("#form-motorplate").html(e.mo6);

        $("#form-drivertdp").html(e.tdpno);
        $("#form-tdpexpdt").val(e.tdpexp);
        $("#form-motormtop").html(e.franchise_no);
        $("#form-lastrenew").html(e.last_renew);
        $("#form-trcode").html(e.trcode);
        $("#form-applicationtype").val(e.appl_status);
        $("#form-applicationyear").val(e.yr);
      }

      if (e.Tags == "FOR ASSESSMENT") {
        $("#btn-submit-driverpermit").remove();
        $("#btn-driver-release").remove();
      } else if (e.Tags == "FOR PAYMENT") {
        $("#btn-modal-operator").remove();
        $("#btn-modal-driver").remove();
        $("#btn-modal-motor").remove();
        $("#btn-submit-driverpermit").remove();
      } else if (e.Tags == "FOR RELEASING" || e.Tags == "RELEASED") {
        $("#btn-submit-driverpermit").remove();
        $("#btn-driver-assessment").remove();
        $("#btn-modal-operator").remove();
        $("#btn-modal-driver").remove();
        $("#btn-modal-motor").remove();
      } else {
        $("#btn-driver-release").remove();
        $("#btn-driver-assessment").remove();
      }
    },
  });
} else {
  $("#btn-driver-release").remove();
  $("#btn-driver-assessment").remove();
}

$.ajax({
  url: "../config/includes.php?var=getalltodadetails",
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

//=============================================================================================================
// Driver Section
//=============================================================================================================

$("#btn-modal-driver").click(function () {
  callDriverTable();
  $("#driver-modal").modal("show");
});

$("#btn-modal-driver-view").click(function () {
  $.ajax({
    url: "../config/includes.php?var=getdetdriver",
    method: "POST",
    data: { code: state.drivercode },
    dataType: "JSON",
    success: function (e) {
      $("#dfirstname").val(e.own_fn);
      $("#dmidinit").val(e.own_mi);
      $("#dlastname").val(e.own_ln);
      $("#dhse").val(e.hse_no);
      $("#dblk").val(e.blk_no);
      $("#dlot").val(e.lot_no);
      $("#dst").val(e.st);
      $("#dsubd").val(e.subdivision);
      $("#dbrgy").val(e.brgy);
      $("#dmun").val(e.Mun);
      $("#dprov").val(e.prov);
      $("#ddrivlic").val(e.drivlis);
      $("#ddrivissue").val(e.dateissued);
      $("#ddrivplace").val(e.placeissued);
      $("#dcontact").val(e.cont_no);
      $("#dctc").val(e.certno);
      $("#dctcissue").val(e.certon);
      $("#dctcplace").val(e.certat);
      $("#dremarks").val(e.remarks);
      $("#dhiddenimage").val(e.file_name);

      if (e.target_path != "") {
        $("#driver-img-alt").attr("src", e.target_path);
      } else {
        $("#driver-img-alt").attr("src", "../dist/img/driver.jpg");
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
  state["drivercode"] = d.file_id;
  $("#form-driverid").html("<b>Operator ID: </b>" + d.file_id);
  $("#form-drivername").html(d.fullname);
  $("#form-driveraddress").html(d.addr);
  $("#form-drivercontact").html(d.cont_no);
  if (d.target_path != "") {
    $("#form-driverimg").attr("src", d.target_path);
  } else {
    $("#form-driverimg").attr("src", "../dist/img/driver.jpg");
  }
  $("#driver-modal").modal("hide");
});

$('#btn-driver-select').click(function () {
  var d = drivertable.row($(this)).data();
  state["drivercode"] = d.file_id;
  $("#form-driverid").html("<b>Operator ID: </b>" + d.file_id);
  $("#form-drivername").html(d.fullname);
  $("#form-driveraddress").html(d.addr);
  $("#form-drivercontact").html(d.cont_no);
  if (d.target_path != "") {
    $("#form-driverimg").attr("src", d.target_path);
  } else {
    $("#form-driverimg").attr("src", "../dist/img/driver.jpg");
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

$("#btn-driver-save").click(function () {
  var data1 = new FormData($("#driver-form-submit")[0]);
  data1.append("file", $("#driver-img")[0].files[0]);
  $.ajax({
    url: "../config/includes.php?var=insertdriver",
    method: "POST",
    data: data1,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
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
            $("#dblk").val() +
            " " +
            $("#dlot").val() +
            " " +
            $("#dst").val() +
            " " +
            $("#dsubd").val() +
            " " +
            $("#dbrgy").val() +
            " " +
            $("#dmun").val() +
            " " +
            $("#dprov").val()
        );
        $("#form-driverimg").attr("src", $("#driver-img-alt").attr("src"));
        $("#form-drivercontact").html($("#dcontact").val());
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-driver-edit").click(function () {
  var data1 = new FormData($("#driver-form-submit")[0]);
  data1.append("file", $("#driver-img")[0].files[0]);
  $.ajax({
    url:
      "../config/includes.php?var=updatedriver&drivercode=" + state.drivercode,
    method: "POST",
    data: data1,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
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
            $("#dblk").val() +
            " " +
            $("#dlot").val() +
            " " +
            $("#dst").val() +
            " " +
            $("#dsubd").val() +
            " " +
            $("#dbrgy").val() +
            " " +
            $("#dmun").val() +
            " " +
            $("#dprov").val()
        );
        $("#form-driverimg").attr("src", $("#driver-img-alt").attr("src"));
        $("#form-drivercontact").html($("#dcontact").val());
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
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
// Operator Section
//=============================================================================================================

$("#btn-modal-operator").click(function () {
  callOperatorTable();
  $("#operator-modal").modal("show");
});

$("#btn-modal-operator-view").click(function () {
  $.ajax({
    url: "../config/includes.php?var=getdetoperator",
    method: "POST",
    data: { code: state.opercode },
    dataType: "JSON",
    success: function (e) {
      $("#firstname").val(e.own_fn);
      $("#midinit").val(e.own_mi);
      $("#lastname").val(e.own_ln);
      $("#bday").val(e.bday);
      $("#age").val(e.age);
      $("#gender").val(e.gender);
      $("#civstats").val(e.civilstat);
      $("#hse").val(e.hse_no);
      $("#blk").val(e.blk_no);
      $("#lot").val(e.lot_no);
      $("#st").val(e.st);
      $("#subd").val(e.subdivision);
      $("#brgy").val(e.brgy);
      $("#mun").val(e.Mun);
      $("#prov").val(e.prov);
      $("#drivlic").val(e.drivlis);
      $("#drivissue").val(e.dateissued);
      $("#drivplace").val(e.placeissued);
      $("#contact").val(e.cont_no);
      $("#ctc").val(e.certno);
      $("#ctcissue").val(e.certon);
      $("#ctcplace").val(e.certat);
      $("#emername").val(e.conperson);
      $("#emercontact").val(e.conconnum);
      $("#emeraddr").val(e.conadress);
      $("#remarks").val(e.remarks);

      if (e.target_path != "") {
        $("#oper-img-alt").attr("src", e.target_path);
      } else {
        $("#oper-img-alt").attr("src", "../dist/img/operator.jpg");
      }

      $("#div-operator-table, #btn-operator-back, #btn-operator-save").hide();
      $("#div-operator-form, #btn-operator-edit").show();
      $("#operator-modal").modal("show");
    },
    error: function (xhr, ajaxOptions, thrownError) {
      Swal.fire("Ops!", "You haven't selected any operator yet.", "error");
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
  state["opcode"] = d.file_id;
  state["opercode"] = d.file_id;
  state["drcode"] = d.file_id;
  $("#form-operatorid").html("<b>Operator ID: </b>" + d.file_id);
  $("#form-operatorname").html(d.fullname);
  $("#form-operatoraddress").html(d.addr);
  $("#form-operatorcontact").html(d.cont_no);
  if (d.target_path != "") {
    $("#form-operatorimg").attr("src", d.target_path);
  } else {
    $("#form-operatorimg").attr("src", "../dist/img/operator.jpg");
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

$("#btn-operator-save").click(function () {
  var data1 = new FormData($("#operator-form-submit")[0]);
  data1.append("file", $("#oper-img")[0].files[0]);
  $.ajax({
    url: "../config/includes.php?var=insertoperator",
    method: "POST",
    data: data1,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
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
            $("#blk").val() +
            " " +
            $("#lot").val() +
            " " +
            $("#st").val() +
            " " +
            $("#subd").val() +
            " " +
            $("#brgy").val() +
            " " +
            $("#mun").val() +
            " " +
            $("#prov").val()
        );
        $("#form-operatorimg").attr("src", $("#oper-img-alt").attr("src"));
        $("#form-operatorcontact").html($("#contact").val());
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-operator-edit").click(function () {
  var data1 = new FormData($("#operator-form-submit")[0]);
  data1.append("file", $("#oper-img")[0].files[0]);
  $.ajax({
    url: "../config/includes.php?var=updateoperator&opercode=" + state.opercode,
    method: "POST",
    data: data1,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
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
            $("#blk").val() +
            " " +
            $("#lot").val() +
            " " +
            $("#st").val() +
            " " +
            $("#subd").val() +
            " " +
            $("#brgy").val() +
            " " +
            $("#mun").val() +
            " " +
            $("#prov").val()
        );
        $("#form-operatorimg").attr("src", $("#oper-img-alt").attr("src"));
        $("#form-operatorcontact").html($("#contact").val());
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#oper-img").change(function (event) {
  var reader = new FileReader();
  reader.onload = function () {
    var output = document.getElementById("oper-img-alt");
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
  $("#btn-create-motor").remove();
});

$("#btn-motor-save").click(function () {
  $.ajax({
    url: "../config/includes.php?var=savemotor",
    method: "POST",
    data: $("#motor-form-submit").serialize(),
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        state["opmotor"] = e.motorid;
        $("#mid").html(e.motorid);
        Swal.fire("Nice!", e.msg, "success");
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-motor-edit").click(function () {
  $.ajax({
    url: "../config/includes.php?var=updatemotor",
    method: "POST",
    data: $("#motor-form-submit").serialize() + "&mid=" + state.motorid,
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
        $("#form-motorid").html(state.motorid);
        $("#form-motortoda").html(
          $("#mtoda").val() + " - " + $("#mbody").val()
        );
        $("#form-motormake").html($("#mmake").val());
        $("#form-motorchassis").html($("#mchassis").val());
        $("#form-motorengine").html($("#mengine").val());
        $("#form-motorplate").html($("#mplate").val());
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#motortable").on("click", "tr", function () {
  $("#motortable tbody tr").removeClass("selected");
  $(this).addClass("selected");
});

$("#motortable").on("dblclick", "tr", function () {
  var d = motortable.row($(this)).data();
  state["mopid"] = d.file_id;
  state["opmotor"] = d.motorid;
  state["motorid"] = d.motorid;
  state["opcode"] = d.file_id;
  state["opercode"] = d.file_id;
  $("#form-motorid").html(d.motorid);
  $("#form-motortoda").html(d.todabody);
  $("#form-motormake").html(d.mo2);
  $("#form-motorchassis").html(d.mo5);
  $("#form-motorengine").html(d.mo7);
  $("#form-motorplate").html(d.mo6);
  $("#form-motormtop").html(d.franno);
  $("#form-lastrenew").html(d.last_renew);
  $("#form-operatorid").html("<b>Operator ID: </b>" + d.file_id);
  $("#form-operatorname").html(d.cname);
  $("#form-operatoraddress").html(d.addr);
  $("#form-operatorcontact").html(d.cont_no);
  if (d.optp != "") {
    $("#form-operatorimg").attr("src", d.optp);
  } else {
    $("#form-operatorimg").attr("src", "../dist/img/operator.jpg");
  }

  if (state["drcode"] !== undefined && state["drcode"] !== null) {
    if (state["drcode"] == "") {
      state["drcode"] = d.drivercode;
      $("#form-driverid").html("<b>Driver ID: </b>" + d.drivercode);
      $("#form-drivername").html(d.dname);
      $("#form-driveraddress").html(d.draddr);
      $("#form-drivercontact").html(d.drcont_no);
      if (d.drtp != "") {
        $("#form-driverimg").attr("src", d.drtp);
      } else {
        $("#form-driverimg").attr("src", "../dist/img/driver.jpg");
      }
    }
  }
  $("#motor-modal").modal("hide");
});

$("#btn-modal-motor-view").click(function () {
  $.ajax({
    url: "../config/includes.php?var=getdetmotor",
    method: "POST",
    data: { motorid: state.motorid },
    dataType: "JSON",
    success: function (e) {
      $("#mopcode").val(e.opercode);
      getOperatorMotor(e.opercode);
      $("#mid").html(e.motorid);
      $("#mbody").val(e.f1);
      $("#mtoda").val(e.mo1);
      $("#mmtop").val(e.franchise_no);
      $("#mmake").val(e.mo2);
      $("#mavailability").html(e.mo9).trigger("change");
      $("#mengine").val(e.mo5);
      $("#mchassis").val(e.mo7);
      $("#myrmodel").val(e.mo3);
      $("#mcolor").val(e.mo11);
      $("#mmtpyr").html(e.foryear);
      $("#mcert").val(e.creg);
      $("#mdtissue").val(e.crdate);
      $("#mplate").val(e.mo6);
      $("#magency").val(e.f3);
      $("#mremarks").val(e.remarks);
      $("#div-motor-table, #btn-motor-back, #btn-motor-save").hide();
      $("#div-motor-form, #btn-motor-edit").show();
      // $("#mopcode").attr("disabled", true);
      $("#motor-modal").modal("show");
    },
    error: function (xhr, ajaxOptions, thrownError) {
      Swal.fire("Ops!", "You haven't selected any motor yet.", "error");
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
  $("#div-motor-form").show();
});

$("#btn-motor-back").click(function () {
  $("#div-motor-form").hide();
  $("#div-motor-table").show();
});

//=============================================================================================================
// Submit Driver's Permit Section
//=============================================================================================================

$("#btn-submit-driverpermit").click(function () {
  state["yr"] = $("#form-applicationyear").val();
  state["tdpexpdt"] = $("#form-tdpexp").val();
  $.ajax({
    url: "../config/includes.php?var=submitdriverpermit",
    method: "POST",
    data: state,
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
        window.location.href =
          "/mtop_dasma/admin/franchise-form.php?trcode=" + e.trcode;
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

//=============================================================================================================
// Assessment Section
//=============================================================================================================

$("#btn-driver-assessment").click(function () {
  callAssessmentTable("TDP");
});

//=============================================================================================================
// Releasing Section
//=============================================================================================================

$("#btn-driver-release").click(function () {
  callReleasingTable(getUrlParameter("trcode"));
  $("#release-modal").modal("show");
});

$("#btn-driver-save-release").click(function () {
  $.ajax({
    url: "../config/includes.php?var=savetdprelease",
    method: "POST",
    data: {
      tdpno: state.tdpno,
      tdpexp: state.tdpexp,
      reldt: $("#reldtissue").val(),
      trcode: state.trcode,
    },
    dataType: "json",
    success: function (data) {
      if (data["result"]) {
        Swal.fire("Nice!", data.msg, "success");
      } else {
        Swal.fire("Ops!", data.msg, "error");
      }
    },
  });
});
