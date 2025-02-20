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

callReqTable($("#req-category").val());

$("#req-category").change(function () {
	callReqTable($(this).val());
});

$("#btn-req-save").click(function () {
	$.ajax({
		url: "../config/includes.php?var=savereq",
		method: "POST",
		data: $("#req-form-submit").serialize(),
		dataType: "JSON",
		success: function (e) {
			if (e.result) {
				alert(e.msg);
				callReqTable($("#req-category").val());
				$("#div-settings-req-form").hide();
				$("#div-settings-req-table").show();
			} else {
				alert(e.msg);
			}
		}
	});
});

$("#btn-req-edit").click(function () {
	var d = settingsreq.row('.selected').data();
	$.ajax({
		url: "../config/includes.php?var=updatereq",
		method: "POST",
		data: $("#req-form-submit").serialize()+"&req-id="+d.reqid,
		dataType: "JSON",
		success: function (e) {
			if (e.result) {
				alert(e.msg);
				callReqTable($("#req-category").val());
				$("#div-settings-req-form").hide();
				$("#div-settings-req-table").show();
			} else {
				alert(e.msg);
			}
		}
	});
});

$("#settingsreqtable tbody").on("click", "#btn-settings-req-view",function () {
	var d = settingsreq.row($(this).closest('tr')).data();
	$("#settingsreqtable tbody tr").removeClass("selected")
	$(this).closest('tr').addClass("selected");
	$("#req-desc").val(d.reqdesc);
	$("#req-cat").val(d.trans);
	$("#div-settings-req-table, #btn-req-save").hide();
	$("#div-settings-req-form, #btn-req-edit").show();
});

$("#btn-settings-req-create").click(function () {
	$("#div-settings-req-table, #btn-req-edit").hide();
	$("#div-settings-req-form, #btn-req-save").show();
	$("#req-desc").val("");
});

$("#btn-req-back").click(function () {
	$("#div-settings-req-form").hide();
	$("#div-settings-req-table").show();
});