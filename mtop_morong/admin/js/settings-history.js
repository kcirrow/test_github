//=========================================================================================================
//	FUNCTIONS AND VARIABLE (FAV)
//=========================================================================================================

var state = {};
var historymotor = "";
var historydriver = "";
var historytrail = "";

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

//=============================================================================================================
// History Section
//=============================================================================================================

$.ajax({
  url: "../config/includes.php?var=getoperatorhistory",
  method: "POST",
  data: { code: getUrlParameter("operator") },
  dataType: "JSON",
  success: function (e) {
    if (e.result) {
      if (e.operator.target_path != "") {
          $("#history-oper-img-alt").attr("src", e.operator.target_path);
      }
      $("#history-operatorname").html(e.operator.fullname);
      $("#history-gender").html(e.operator.sex);
      $("#history-contactno").html(e.operator.mobile_no);

      historydriver = $("#history-drivers-table").DataTable({
        data: e.drivers,
        columns: [
          { data: "trcode" },
          { data: "fname" },
          { data: "motorpin" },
          { data: "foryear" },
        ],
      });

      historymotor = $("#history-motors-table").DataTable({
        data: e.motors,
        columns: [
          { data: "motorpin" },
          { data: "franchiseno" },
          { data: "tbody" },
          { data: "engine" },
          { data: "plateno" },
          { data: "chassis" },
          { data: "status" },
          { data: "foryear" },
          { data: "dtexprd" },
          { data: "remarks" },
        ],
      });

      historytrail = $("#history-trail-table").DataTable({
        data: e.audits,
        columns: [
          { data: "datetransact" },
          { data: "transaction" },
          { data: "transdetails" },
          { data: "realname" },
          { data: "pcname" },
        ],
      });
    }
  },
});
