//=========================================================================================================
//	FUNCTIONS AND VARIABLE (FAV)
//=========================================================================================================

var state = {};

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

$(window).keydown(function(event){
	if(event.keyCode == 13) {
	  event.preventDefault();
	  return false;
	}
});

//=============================================================================================================
// Driver Section
//=============================================================================================================

$("#settingsdrivertable tbody").on("click", "#btn-settings-driver-view",function () {
	var d = settingsdriver.row($(this).closest('tr')).data();
	$.ajax({
		url: "../config/includes.php?var=getdetdriver",
		method: "POST",
		data: {code: d.file_id},
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

			$("#div-settings-driver-table, #btn-driver-save").hide();
			$("#div-settings-driver-form, #btn-driver-edit").show();
		}
	});
});


$("#btn-settings-driver-create").click(function () {
	$("#div-settings-driver-table, #btn-driver-edit").hide();
	$("#div-settings-driver-form").show();
});

$("#btn-driver-back").click(function () {
	$("#div-settings-driver-form").hide();
	$("#div-settings-driver-table").show();
});


$("#btn-driver-save").click(function () {
	$.ajax({
		url: "../config/includes.php?var=insertdriver",
		method: "POST",
		data: $("#driver-form-submit").serialize(),
		dataType: "JSON",
		success: function (e) {
			settingsdriver.ajax.reload();
			alert(e.msg);
		}
	});
});

$("#btn-driver-edit").click(function () {
	$.ajax({
		url: "../config/includes.php?var=updatedriver",
		method: "POST",
		data: $("#driver-form-submit").serialize()+"&drivercode="+state.drivercode,
		dataType: "JSON",
		success: function (e) {
			settingsdriver.ajax.reload();
			alert(e.msg);
		}
	});
});