//=========================================================================================================
//  FUNCTIONS AND VARIABLE (FAV)
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

function switchonoff(id, val) {
  if (val !== undefined) {
    if (val == "on") {
      $("#" + id).prop("checked", true);
    } else {
      $("#" + id).prop("checked", false);
    }
  }
}

function clearBox () {
    
  $("#mid").html("");
  $("#mavailability").html("xxxx").trigger("change");
  $("#mmtpyr").html("");
  
  $("#mopcode, #mbody, #mtoda, #mmtop, #mmake, #mengine, #mchassis, #myrmodel, #mcolor, #mcert, #mmvno, #mdtissue, #mplate, #magency, #mremarks, #mplatecolor, #morcrname").val("");

  switchonoff("orcr-name-switch", "off");
  
  $("#morcrname").attr("readonly", true);
  
  $("#mname").val("");
  $("#maddress").val("");
  $("#moper-img-alt").attr("src", "../dist/img/operator.png");
}

$(window).keydown(function(event){
  if(event.keyCode == 13) {
    event.preventDefault();
    return false;
  }
});


$.ajax({
  url: "../config/includes.php?var=getalltodadetails",
  method: "POST",
  dataType: "JSON",
  success: function (e) {
    $.map(e.data, function (x) {
      $("#mtoda").append("<option value='"+x.todacode+"'>"+x.todacode+"</option>");
    });
  }
});


$("#motor-form-submit").submit(function (e) {
    e.preventDefault();
    var url = "";
      if (btype == "insert") {
          url = "../config/includes.php?var=savemotor";
      } else if (btype == "update") {
          url = "../config/includes.php?var=updatestatus";
      } else {
          Swal.fire("Notice!", "Something went wrong.", "warning");
          return;
      }
    $.ajax({
        url: url,
        method: "POST",
        data: $("#motor-form-submit").serialize() + "&mid=" + state.motorpin,
        dataType: "JSON",
        success: function (e) {
          if (e.result) {
            if (btype == "insert") {
                state["motorpin"] = e.motorpin;    
            }
            btype = "";
            Swal.fire("Done!", e.msg, "success");
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

$("#mopcode").change(function () {
  if ($(this).val() != "") {
    $.ajax({
      url: "../config/includes.php?var=getopmotor1",
      method: "POST",
      data: { code: $(this).val() },
      dataType: "json",
      success: function (data) {
        if (data != "") {
          $("#strcode").val(data["trcode"]);
          $("#stags").val(data["tags"]);
          $("#mname").val(data["fullname"]);
          $("#maddress").val(data["addr"]);
          if (data.target_path !== null && data.target_path !== undefined) {
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


$("#settingsstatustable tbody").on("click", "#btn-settings-motor-view",function () {
  var d = settingsstatus.row($(this).closest('tr')).data();
  $.ajax({
    url: "../config/includes.php?var=getdetmotor",
    method: "POST",
    data: { motorid: d.motorpin },
    dataType: "JSON",
    success: function (e) {
        state = e;
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
      switchonoff("orcr-name-switch", e.crswitch);
      if (e.crswitch == "on") {
        $("#morcrname").attr("readonly", false);
      }
      $("#div-settings-motor-table, #btn-motor-save, #btn-motor-operator").hide();
    $("#div-settings-motor-form, #btn-motor-edit").show();
    },
  });
});



$("#mavailability").change(function () {
  if ($(this).html() == "AVAILABLE") {
    $(this).css("color", "lightgreen");
  } else if ($(this).html() == "UNAVAILABLE") {
    $(this).css("color", "red");
  } else {
    $(this).css("color", "black");
  }
});

$("#btn-settings-motor-create").click(function () {
    clearBox();
  $("#div-settings-motor-table, #btn-motor-edit").hide();
  $("#div-settings-motor-form, #btn-motor-operator, #btn-motor-save").show();
});

$("#btn-motor-back").click(function () {
  $("#div-settings-motor-form").hide();
  $("#div-settings-motor-table").show();
});


$("#settingsstatustable tbody").on("click", "#btn-settings-motor-delete", function () {
  var d = settingsstatus.row($(this).closest("tr")).data();
    Swal.fire({
      title: "Are you sure you want to delete this?",
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
          title: "Are you sure you want to delete this?",
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
              url: "../config/includes.php?var=deletemotor",
              method: "POST",
              data: {
                opcode: d.humanpin,
                reason: $("#reason").val(),
                auth: $("#auth").val(),
              },
              dataType: "JSON",
              success: function (e) {
                if (e.result) {
                  Swal.fire("Job done!", e.msg, "success");
                  settingsstatus.ajax.reload();
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