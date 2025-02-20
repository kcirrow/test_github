$(document).ready(function () {
  $("#droppingtable").on("click", "#btn-view", function () {
    var d = droppingtable.row($(this).closest("tr")).data();
    window.location.href =
      baseurl + "/admin/dropping-form.php?trcode=" + d.trcode;
  });
  var cmselection = "";
  $("#btn-apply-drop").click(function () {
    cmselection = $("#cmselectiontable").DataTable({
      destroy: true,
      ajax: {
        url: "../config/includes.php?var=getmotor",
        method: "POST",
      },
      columns: [
        {data: function () {
            return "<button class='btn btn-primary btn-sm' id='btn-motor-select'>Select</button>";
        }},
        { data: "ophumanpin" },
        { data: "opname" },
        { data: "motorpin" },
        { data: "todabody" },
        { data: "franchiseno" },
        { data: "engine" },
        { data: "chassis" },
        { data: "plateno" },
      ],
      bInfo: false,
      order: [[0, "desc"]],
    });
    $("#cmselection-modal").modal("show");
  });

  $("#cmselectiontable tbody").on("dblclick", "tr", function () {
    var d = cmselection.row($(this).closest("tr")).data();
    window.location.href =
      baseurl + "/admin/dropping-form.php?motor=" + d.motorpin;
  });
  
  $("#cmselectiontable tbody").on("click", "#btn-motor-select", function () {
    var d = cmselection.row($(this).closest("tr")).data();
    window.location.href =
      baseurl + "/admin/dropping-form.php?motor=" + d.motorpin;
  });

  $("#application-menu").addClass("menu-is-opening menu-open");
  $("#dropping-table").addClass("active");

  $("#droppingtable").on("click", "#btn-cancel", function () {
    var d = droppingtable.row($(this).closest("tr")).data();
    Swal.fire({
      title: "Are you sure you want to cancel this?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, cancel it!",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Are you sure you want to cancel this?",
          html:
            'For what reason: <input type="text" class="form-control form-control-sm" id="reason"> <br>' +
            'To confirm enter authentication: <input type="password" class="form-control form-control-sm" id="auth">',
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Submit",
          reverseButtons: true,
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../config/includes.php?var=canceldropping",
              method: "POST",
              data: {
                trcode: d.trcode,
                reason: $("#reason").val(),
                auth: $("#auth").val(),
              },
              dataType: "JSON",
              success: function (e) {
                if (e.result) {
                  Swal.fire("Job done!", e.msg, "success");
                  changeownershiptable.ajax.reload();
                } else {
                  Swal.fire("Ops!", e.msg, "error");
                }
              },
            });
          }
        });
      }
    });
  });
});

//=============================================================================================================
// Assessment Section
//=============================================================================================================
droppingtable.on("click", "#btn-dropping-assessment", function () {
  var d = droppingtable.row($(this).closest("tr")).data();
  assyes = droppingtable;
  state["trcode"] = d.trcode;
  state["appl_status"] = d.appl_status;
  $("#assess-trcode").val(d.trcode);
  $("#assess-fullname").val(d.fullname);
  $("#assess-trans").val(d.appl_status);
  $("#total-assess").html("0.00");
  callAssessmentTable(d.appl_status);
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

droppingtable.on("click", "#btn-dropping-inspection", function () {
  var d = droppingtable.row($(this).closest("tr")).data();
  state = d;
  $.ajax({
    url: "../config/includes.php?var=getdetinspection&trcode=" + d.trcode,
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
  data1.append("opcode", state.opcode);
  data1.append("motorid", state.motorid);
  data1.append("appl_status", state.appl_status);
  $.ajax({
    url: "../config/includes.php?var=saveinspection",
    method: "POST",
    data: data1,
    dataType: "JSON",
    processData: false,
    contentType: false,
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
        droppingtable.ajax.reload();
        $("#inspection-modal").modal("hide");
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});

$("#btn-inspect-print").click(function () {
    window.open(baseurl + "/config/inspectionprint.php?trcode="+state.trcode);
});

//=============================================================================================================
// Releasing Section
//=============================================================================================================
droppingtable.on("click", "#btn-dropping-release", function () {
  var d = droppingtable.row($(this).closest("tr")).data();
  state = d;
  if (d.target_path == "") {
      d.target_path = "../dist/img/operator.png";
  }
  $("#roper-img-alt").attr("src", d.target_path);
  toDataUrl(d.target_path, function (base64Img) {
    shit = base64Img;
  });
  $("#btn-operator-printid").remove();
  callReleasingTable(d.trcode, d.appl_status);
  $("#relmtp").attr("readonly", true);
  $("#relfranexp-col").remove();
  $.ajax({
    url: "../config/includes.php?var=getapprovepersonel",
    method: "POST",
    dataType: "JSON",
    success: function (e) {
        $(".opt-relapprove").remove();
      $.map(e, function (x) {
        $("#relapprove").append(
          "<option class='opt-relapprove' value='" + x.app_id + "'>" + x.app_name + "</option>"
        );
      });
    },
  });
  $("#release-modal").modal("show");
});

$("#btn-operator-save-release").click(function () {
     var mtp = "";
  if ($("#relmtp").hasClass("select2")) {
      mtp = $("#relmtp option:selected").val();
  } else {
      mtp = $("#relmtp").val();
  }
  $.ajax({
    url: "../config/includes.php?var=saverelease",
    method: "POST",
    data: {
      mtp: mtp,
      mtpdt: $("#reldtissue").val(),
      dtexp: "1990-01-01",
      trcode: state.trcode,
      provi: $("#relprovi").val(),
      sticker: $("#relsticker").val(),
      dtissuestk: $("#reldtissuesticker").val(),
      stkexp: $("#relstickerexp").val(),
      schoolname: $("#relschoolname").val(),
      trans: state.appl_status,
      remarks: $("#relremarks").val(),
    },
    dataType: "json",
    success: function (data) {
      if (data["result"]) {
        Swal.fire("Nice!", data.msg, "success");
        droppingtable.ajax.reload();
      } else {
        Swal.fire("Ops!", data.msg, "error");
      }
    },
  });
});

$("#btn-operator-print").click(function () {
  window.open(baseurl + "/config/morong_printing/morong_dropping.php?trcode="+state.trcode+"&app="+state.appl_status);
});

$("#btn-operator-save-print-release").click(function () {
    var mtp = "";
  if ($("#relmtp").hasClass("select2")) {
      mtp = $("#relmtp option:selected").val();
  } else {
      mtp = $("#relmtp").val();
  }
  $.ajax({
    url: "../config/includes.php?var=saverelease",
    method: "POST",
    data: {
      mtp: mtp,
      mtpdt: $("#reldtissue").val(),
      dtexp: "1990-01-01",
      trcode: state.trcode,
      provi: $("#relprovi").val(),
      sticker: $("#relsticker").val(),
      dtissuestk: $("#reldtissuesticker").val(),
      stkexp: $("#relstickerexp").val(),
      schoolname: $("#relschoolname").val(),
      trans: state.appl_status,
      remarks: $("#relremarks").val(),
    },
    dataType: "json",
    success: function (data) {
      if (data["result"]) {
        Swal.fire("Nice!", data.msg, "success").then((result) => {
          if (result.isConfirmed) {
            window.open(baseurl + "/config/morong_printing/morong_dropping.php?trcode="+state.trcode+"&app="+state.appl_status);
          }
        });
        
        droppingtable.ajax.reload();
      } else {
        Swal.fire("Ops!", data.msg, "error");
      }
    },
  });
});

