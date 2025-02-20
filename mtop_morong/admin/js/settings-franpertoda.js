$("#settingstodaperfrantable tbody").on("click", "#view-fpt-operator", function () {
	var d = settingstodaperfran.row($(this).closest('tr')).data();
	$.ajax({
    url: "../config/includes.php?var=getdetoperator",
    method: "POST",
    data: { code: d.opercode },
    dataType: "JSON",
    success: function (e) {
      $("#fpt-oper-name").html(e.first_name + " " + e.middle_name + " " + e.last_name);
      $("#fpt-oper-gender").html(e.sex);
      $("#fpt-oper-contactno").html(e.mobile_no);

      $("#fpt-oper-address").html(e.address_house_no + " " + e.address_street_name + " " + e.address_subdivision + " " + e.address_brgy + " " + e.address_municipality + " " + e.address_province);

      $("#fpt-oper-drivlis").html(e.drivlis);

      if (e.target_path != "") {
        $("#fpt-oper-img-alt").attr("src", e.target_path);
      } else {
        $("#fpt-oper-img-alt").attr("src", "../dist/img/operator.png");
      }

      $("#fpt-operator").modal("show");
    },
  });
});

$("#settingstodaperfrantable tbody").on("click", "#view-fpt-motor", function () {
	var d = settingstodaperfran.row($(this).closest('tr')).data();
	$("#fpt-motor").modal("show");
	$.ajax({
	    url: "../config/includes.php?var=getdetmotor",
	    method: "POST",
	    data: { code: d.motorid },
	    dataType: "JSON",
	    success: function (e) {
	      
	    },
	  });
});