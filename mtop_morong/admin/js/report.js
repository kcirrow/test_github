//=========================================================================================================
//	FUNCTIONS AND VARIABLE (FAV)
//=========================================================================================================

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

$.ajax({
  url: "../config/includes.php?var=gettodaoption",
  method: "POST",
  dataType: "JSON",
  success: function (e) {
      $("#toda option").remove();
      $("#toda").append(
        "<option value=''>ALL TODA</option>"
      );
    $.map(e.data, function (x) {
      $("#toda").append(
        "<option value='" + x.todacode + "'>" + x.todacode + "</option>"
      );
    });
  },
});

var apyr = new Date();
for (var i = apyr.getFullYear(); i >= 2010; i--) {
  $("#year").append(
    "<option value='" + i + "'>" + i + "</option>"
  );
}

$("#datefrom, #dateto").val(TodayDate());

var franchisemasterlisttable = "";
var tdpmasterlisttable = "";
var expiredfranchisetable = "";
var dropmasterlisttable = "";
var collectiontable = "";
var todatable = "";
var abstracttable = "";
var changemotorreport = "";
var activitylogs = "";


var residencysummary = $("#residency-summary-table").DataTable({
	destroy: true,
	ajax: {
		url: "../config/includes.php?var=getresidencyrummaryreport",
		method: "POST",
		data: {
			toda: $("#toda").val()
		}
	},
	columns: [      
	    {data: "toda"},
	    {data: "res"},
	    {data: "nres"},
	    {data: "total"}
	],
	dom: "Bfrtip",
	buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});

$("#btn-report-masterlist-franchise-search").click(function () {
	franchisemasterlisttable = $("#franchise-masterlist-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=getmasterlistfran",
			method: "POST",
			data: {
				from: $("#datefrom").val(),
				to: $("#dateto").val(),
				toda: $("#toda").val(),
				year: $("#year").val()
			}
		},
		columns: [  
				{data: "trcode"},     
				//{data: "bodyno"},                
		    {data: "last_name"},
		    {data: "first_name"},
		    {data: "middle_name"},
		    {data: "addr"},
		    {data: "mvno"},
		    {data: "make"},
		    {data: "engine"},
		    {data: "chassis"},
		    {data: "plateno"},
		    {data: "franchise_date"},
		    {data: "fno"},
		    {data: "last_renew"},
		    {data: "toda"},
		    {data: "appl_status"}
		],
		order: [[ 0, "asc" ]], 
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});

// $("#btn-report-masterlist-changemotor-search").click(function () {
// 	franchisemasterlisttable = $("#changemotor-masterlist-table").DataTable({
// 		destroy: true,
// 		ajax: {
// 			url: "../config/includes.php?var=getmasterlistcm",
// 			method: "POST",
// 			data: {
// 				from: $("#datefrom").val(),
// 				to: $("#dateto").val(),
// 				toda: $("#toda").val(),
// 				year: $("#year").val()
// 			}
// 		},
// 		columns: [      
// 			{data: "bodyno"},                
// 		    {data: "last_name"},
// 		    {data: "first_name"},
// 		    {data: "middle_name"},
// 		    {data: "addr"},
// 		    {data: "make"},
// 		    {data: "engine"},
// 		    {data: "chassis"},
// 		    {data: "plateno"},
// 		    {data: "franchise_date"},
// 		    {data: "fno"},
// 		    {data: "last_renew"},
// 		    {data: "toda"},
// 		    {data: "appl_status"}
// 		],
// 		order: [[ 0, "asc" ]], 
// 		dom: "Bfrtip",
// 		buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print'
//         ]
// 	});
// });


$("#btn-report-masterlist-tdp-search").click(function () {
	tdpmasterlisttable = $("#tdp-masterlist-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=getmasterlisttdp",
			method: "POST",
			data: {
				from: $("#datefrom").val(),
				to: $("#dateto").val(),
				toda: $("#toda").val(),
				year: $("#year").val()
			}
		},
		columns: [      
			{data: "trcode"},                
		    {data: "todabody"},
		    {data: "own_ln"},
		    {data: "own_fn"},
		    {data: "own_mi"},
		    {data: "addr"},
		    {data: "drivlis"},
		    {data: "lisexp"},
		    {data: "dtreg"},
		    {data: "tdpexp"}
		],
		order: [[ 0, "asc" ]], 
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});


$("#btn-report-masterlist-drop-search").click(function () {
	dropmasterlisttable = $("#drop-masterlist-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=getmasterlistdrop",
			method: "POST",
			data: {
				toda: $("#toda").val(),
				from: $("#datefrom").val(),
				to: $("#dateto").val()
			}
		},
		columns: [      
		    {data: "bodyno"},
			{data: "own_ln"},                
		    {data: "own_fn"},
		    {data: "own_mi"},
		    {data: "addr"},
		    {data: "mo2"},
		    {data: "mo7"},
		    {data: "mo5"},
		    {data: "mo6"},
		    {data: "mo1"},
		    {data: "reason"},
		    {data: "date_create"}
		],
		order: [[ 0, "asc" ]], 
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});


var expiredtdptable = $("#expiring-tdp-table").DataTable({
		destroy: true,
		responsive: true,
		ajax: {
			url: "../config/includes.php?var=getexpiringtdp",
			method: "POST",
		},
		columns: [      
			{data: "trcode"},                
		    {data: "nname"},
		    {data: "todabody"},
		    {data: "tdpno"},
		    {data: "tdpapp"},
		    {data: "tdpexp"}
		],
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});


$("#btn-report-expired-franchise-search").click(function () {
	expiredfranchisetable = $("#expired-franchise-table").DataTable({
		destroy: true,
		responsive: true,
		ajax: {
			url: "../config/includes.php?var=getexpiredfranchise",
			method: "POST",
			data: {
				toda: $("#toda").val(),
				year: $("#year").val()
			}
		},
		columns: [      
		    {data: "tbody"},
			{data: function (e) {
			    return e.first_name + " " + e.last_name;
			}},                
		    {data: "addr"},
		    {data: "franchise_no"},
		    {data: "dtexprd"},
		    {data: "last_renew"}
		],
		order: [[ 0, "asc" ]], 
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});

$("#btn-report-expiring-franchise-search").click(function () {
	expiredfranchisetable = $("#expiring-franchise-table").DataTable({
		destroy: true,
		responsive: true,
		ajax: {
			url: "../config/includes.php?var=getexpiringfranchise",
			method: "POST",
			data: {
				toda: $("#toda").val(),
				from: $("#datefrom").val(),
				to: $("#dateto").val()
			}
		},
		columns: [      
		    {data: "toda"},
			{data: function (e) {
			    return e.first_name + " " + e.last_name;
			}},                
		    {data: "addr"},
		    {data: "franchise_no"},
		    {data: "dtexprd"},
		    {data: "last_renew"}
		],
		order: [[ 0, "asc" ]], 
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});


$("#btn-report-collection-search").click(function () {
	collectiontable = $("#collection-table").DataTable({
		destroy: true,
		responsive: true,
		ajax: {
			url: "../config/includes.php?var=getreportcollection",
			method: "POST",
			data: {
				from: $("#datefrom").val(),
				to: $("#dateto").val()
			}
		},
		columns: [      
		    {data: "trcode"},
				{data: "opname"},                
		    {data: "toda"},
		    {data: "or_number"},
		    {data: "or_date"},
		    {data: "totamt"}
		],
		sort: false,
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});


$("#btn-report-toda-search").click(function () {
	todatable = $("#toda-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=gettodaoption",
			method: "POST",
			data: {
				from: $("#datefrom").val(),
				to: $("#dateto").val(),
			}
		},
		columns: [      
		    {data: "todacode"},
				{data: "todaRoute"},                
		    {data: "todaPres"},
				{data: "contactno"},
		    {data: "ctoda"},
    		{data: "todaRemarks"},
		],
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});


$("#btn-report-abstract-search").click(function () {
	abstracttable = $("#abstract-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=getreportabstract",
			method: "POST",
			data: {
				from: $("#datefrom").val(),
				to: $("#dateto").val()
			}
		},
		columns: [
			  {data: "trcode"},    
		    {data: "orno"},
				{data: "datecreate"},                
		    {data: "payor"},
		    {data: "col2"},
		    {data: "col24"},
		    {data: "col25"},
		    {data: "col29"},
		    {data: "col6"},
		    {data: "col26"},
		    {data: "col32"},
		    {data: "col34"},
		    {data: "col39"},
		    {data: "totamt"},
		],
		order: [[ 1, "asc" ]], 
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});

$("#btn-report-changemotor-search").click(function () {
	changemotorreport = $("#changemotor-masterlist-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=getchangemotorreport",
			method: "POST",
			data: {
				from: $("#datefrom").val(),
				to: $("#dateto").val(),
				toda: $("#toda").val(),
				year: $("#year").val()
			}
		},
		columns: [      
		    {data: "opfname"},
			  {data: "opnewfname"},                
		    {data: "motorpin"},
		    {data: "addr"},
		    {data: "dateapplication"},
		    {data: "franchiseno"},
		    {data: "toda"},
		    {data: "Tags"},
		],
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});

$("#btn-report-changeownership-search").click(function () {
	changemotorreport = $("#changeownership-masterlist-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=getchangeownershipreport",
			method: "POST",
			data: {
				from: $("#datefrom").val(),
				to: $("#dateto").val(),
				toda: $("#toda").val(),
				year: $("#year").val()
			}
		},
		columns: [      
		    {data: "opfname"},
				{data: "opnewfname"},                
		    {data: "motorpin"},
		    {data: "addr"},
		    {data: "dateapplication"},
		    {data: "franchiseno"},
		    {data: "toda"},
		    {data: "Tags"},
		],
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});

$("#btn-report-residency-summary-search").click(function () {

});

$("#btn-activity-logs-search").click(function () {
	activitylogs = $("#activity-logs-table").DataTable({
		destroy: true,
		ajax: {
			url: "../config/includes.php?var=getactivitylogs",
			method: "POST",
			data: {
			    from: $("#datefrom").val(),
				to: $("#dateto").val(),
				user: $("#log-user").val()
			}
		},
		columns: [      
		    {data: "username"},
		    {data: "realname"},
		    {data: "transaction"},
		    {data: "transdetails"},
		    {data: "datetransact"}
		],
		dom: "Bfrtip",
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
});



