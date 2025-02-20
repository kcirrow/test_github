$(document).ready(function () {
	$("#driverspermittable").on("click", "#btn-view", function () {
		var d = driverspermittable.row($(this).closest("tr")).data();
		window.location.href = "/mtop_dasma/admin/driverspermit-form.php?trcode=" + d.trcode;
	});

	$("#btn-apply-tdp").click(function () {
		window.location.href = "/mtop_dasma/admin/driverspermit-form.php";
	});

	$("#application-menu").addClass("menu-is-opening menu-open");
	$("#driverspermit-table").addClass("active");

	$("#driverspermittable").on("click", "#btn-cancel", function () {
		var d = driverspermittable.row($(this).closest("tr")).data();
		Swal.fire({
		  title: 'Are you sure you want to cancel this?',
		  text: "You won't be able to revert this!",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, cancel it!',
		  reverseButtons: true
		}).then((result) => {
		  if (result.isConfirmed) {
		  	Swal.fire({
			  title: 'Are you sure you want to cancel this?',
			  html: 'For what reason: <input type="text" class="form-control form-control-sm" id="reason"> <br>' +
				    'To confirm enter authentication: <input type="password" class="form-control form-control-sm" id="auth">',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Submit',
			  reverseButtons: true
			}).then((result) => {
			  if (result.isConfirmed) {
			    $.ajax({
			    	url: "../config/includes.php?var=cancelfranchise",
			    	method: "POST",
			    	data: {
			    		trcode: d.trcode,
			    		reason: $("#reason").val(),
			    		auth: $("#auth").val()
			    	},
			    	dataType: "JSON",
			    	success: function (e) {
			    		if (e.result) {
			    			Swal.fire(
							  'Job done!',
							  e.msg,
							  'success'
							);
							franchisetable.ajax.reload();
			    		} else {
			    			Swal.fire(
							  'Ops!',
							  e.msg,
							  'error'
							);
			    		}
			    	}
			    });
			  }
			});
		  }
		});
	});
});