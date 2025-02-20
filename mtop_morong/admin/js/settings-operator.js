//=========================================================================================================
//  FUNCTIONS AND VARIABLE (FAV)
//=========================================================================================================

var state = {};
var apyr = new Date();
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

loadPSGC(0);

$(window).keydown(function (event) {
  if (event.keyCode == 13) {
    event.preventDefault();
    return false;
  }
});

$("#settingsoperatortable tbody").on(
  "click",
  "#btn-settings-operator-history",
  function () {
    var d = settingsoperator.row($(this).closest("tr")).data();
    window.location.href = "settings-history.php?operator=" + d.humanpin;
  }
);

$("#settings-menu").addClass("menu-is-opening menu-open");
$("#settings-operator-nav").addClass("active");
//=============================================================================================================
// Operator Section
//=============================================================================================================

$("#settingsoperatortable tbody").on(
  "click",
  "#btn-settings-operator-view",
  function () {
    var d = settingsoperator.row($(this).closest("tr")).data();

    $.ajax({
      url: "../config/includes.php?var=getdetoperator",
      method: "POST",
      data: { code: d.humanpin },
      dataType: "JSON",
      success: function (e) {
          state = e;
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
        $("#cin").val(e.cin);
        if (e.target_path != "") {
          $("#oper-img-alt").attr("src", e.target_path);
        } else {
          $("#oper-img-alt").attr("src", "../dist/img/operator.png");
        }
        $("#div-settings-operator-table, #btn-operator-save").hide();
        $("#div-settings-operator-form, #btn-operator-edit").show();
      },
    });
  }
);

$("#btn-settings-operator-create").click(function () {
  $("#div-settings-operator-table, #btn-operator-edit").hide();
  $("#div-settings-operator-form").show();
});

$("#btn-operator-back").click(function () {
  $("#div-settings-operator-form").hide();
  $("#div-settings-operator-table").show();
});

$("#operator-form-submit").submit(function (e) {
  e.preventDefault();
  var url = "";
  if (btype == "insert") {
      url = "../config/includes.php?var=insertoperator";
  } else if (btype == "update") {
      url = "../config/includes.php?var=updateoperator&opercode=" + state.humanpin;
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
           state["humanpin"] = e.ophumanpin;
        }
        btype = "";
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

$("#settingsoperatortable tbody").on("click", "#btn-settings-operator-delete", function () {
  var d = settingsoperator.row($(this).closest("tr")).data();
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
              url: "../config/includes.php?var=deleteoperator",
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
                  settingsoperator.ajax.reload();
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
