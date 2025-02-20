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


$("#btn-toda-save").click(function () {
	$.ajax({
		url: "../config/includes.php?var=savetoda",
		method: "POST",
		data: $("#toda-form-submit").serialize(),
		dataType: "JSON",
		success: function (e) {
			if (e.result) {
				alert(e.msg)
			} else {
				alert(e.msg);
			}
		}
	});
});

$("#btn-toda-edit").click(function () {
	var d = settingstoda.row('.selected').data();
	$.ajax({
		url: "../config/includes.php?var=updatetoda",
		method: "POST",
		data: $("#toda-form-submit").serialize()+"&tid="+d.ID,
		dataType: "JSON",
		success: function (e) {
			if (e.result) {
				alert(e.msg);
			} else {
				alert(e.msg);
			}
		}
	});
});

$("#settingstodatable tbody").on("click", "#btn-settings-toda-view",function () {
	var d = settingstoda.row($(this).closest('tr')).data();
	$("#settingstodatable tbody tr").removeClass("selected")
	$(this).closest('tr').addClass("selected");
	$.ajax({
		url: "../config/includes.php?var=getdettoda",
		method: "POST",
		data: {tcode: d.todacode},
		dataType: "JSON",
		success: function (e) {
			$("#tcode").val(e.data.todacode);
			$("#troute").val(e.data.todaRoute);
			$("#tremarks").val(e.data.todaRemarks);
			$("#div-settings-signatories-table, #btn-signatories-save").hide();
			$("#div-settings-signatories-form, #btn-signatories-edit").show();
		}signatories
	});
});

$("#btn-settings-toda-create").click(function () {
	$("#div-settings-toda-table, #btn-toda-edit").hide();
	$("#div-settings-toda-form").show();
});

$("#btn-toda-back").click(function () {
	$("#div-settings-toda-form").hide();
	$("#div-settings-toda-table").show();
});