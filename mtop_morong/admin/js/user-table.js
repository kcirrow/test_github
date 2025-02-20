$(document).ready(function () {
    //==============================================================================================================================
    // User Management
    //==============================================================================================================================
    var state = {};
    var usermanagementtable = $("#usermanagementtable").DataTable({
      ajax: {
        url: "../config/includes.php?var=getallusers",
        method: "POST",
      },
      columns: [
        {
          data: function (e) {
            return "<button class='btn btn-info' id='btn-settings-user-view'><i class='fa fa-folder-open'></i></button>";
          },
        },
        { data: "fullname" },
        { data: "designation" },
        { data: "UserLevel" },
      ],
    });
	
	function switchonoff(id, val) {
      if (val !== undefined) {
        if (val == 1) {
          $("#" + id).prop("checked", true);
        } else {
          $("#" + id).prop("checked", false);
        }
      }
    }

	$("#settings-menu").addClass("menu-is-opening menu-open");
	$("#open-user-management").addClass("active");


	$("#btn-create-user").click(function () {
	    state['url'] = "signup";
		$("#user-modal").modal('show');
	});
	
	$("#usermanagementtable tbody").on("click", "#btn-settings-user-view", function () {
	   var d = usermanagementtable.row($(this).closest('tr')).data();
	   state['id'] = d.id;
	   $.ajax({
        url: "../config/includes.php?var=getuserdet",
        method: "POST",
        data: {id: state.id},
        dataType: "JSON",
        success: function (e) {
          console.log(e);
          state['url'] = "updateuser";
          $("#fullname").val(e.fullname);
          $("#position").val(e.designation);
          $("#username").val(e.username);
          switchonoff("tfran-application-switch", e.tf_application);
          switchonoff("tfran-view-switch", e.tf_view);
          switchonoff("tfran-inspection-switch", e.tf_inspection);
          switchonoff("tfran-assessment-switch", e.tf_assessment);
          switchonoff("tfran-release-switch", e.tf_releasing);
          switchonoff("tfran-cancel-switch", e.tf_cancel);
          switchonoff("tfran-orencode-switch", e.tf_orencode);
          switchonoff("tfran-appform-switch", e.tf_appform);
          
          switchonoff("cm-application-switch", e.cm_application);
          switchonoff("cm-view-switch", e.cm_view);
          switchonoff("cm-inspection-switch", e.cm_inspection);
          switchonoff("cm-assessment-switch", e.cm_assessment);
          switchonoff("cm-release-switch", e.cm_releasing);
          switchonoff("cm-cancel-switch", e.cm_cancel);
          switchonoff("cm-orencode-switch", e.cm_orencode);
          switchonoff("cm-appform-switch", e.cm_appform);
          
          switchonoff("co-application-switch", e.co_application);
          switchonoff("co-view-switch", e.co_view);
          switchonoff("co-inspection-switch", e.co_inspection);
          switchonoff("co-assessment-switch", e.co_assessment);
          switchonoff("co-release-switch", e.co_releasing);
          switchonoff("co-cancel-switch", e.co_cancel);
          switchonoff("co-orencode-switch", e.co_orencode);
          switchonoff("co-appform-switch", e.co_appform);
          
          switchonoff("drop-application-switch", e.dp_application);
          switchonoff("drop-view-switch", e.dp_view);
          switchonoff("drop-inspection-switch", e.dp_inspection);
          switchonoff("drop-assessment-switch", e.dp_assessment);
          switchonoff("drop-release-switch", e.dp_releasing);
          switchonoff("drop-cancel-switch", e.dp_cancel);
          switchonoff("drop-orencode-switch", e.dp_orencode);
          switchonoff("drop-appform-switch", e.dp_appform);
          
          switchonoff("settings-operator-switch", e.sett_opdr);
          switchonoff("settings-motor-switch", e.sett_motor);
          switchonoff("settings-toda-switch", e.sett_toda);
          switchonoff("settings-frantoda-switch", e.sett_franpertoda);
          
          switchonoff("references-requirements-switch", e.ref_requirements);
          switchonoff("references-assfee-switch", e.ref_assfees);
          switchonoff("references-signa-switch", e.ref_signa);
          switchonoff("references-make-switch", e.ref_make);
          switchonoff("references-lto-switch", e.ref_lto);
          
          switchonoff("report-franchise-switch", e.rep_newrenew);
          switchonoff("report-cm-switch", e.rep_cm);
          switchonoff("report-co-switch", e.rep_co);
          switchonoff("report-drop-switch", e.rep_drop);
          switchonoff("report-exprdfran-switch", e.rep_franexprd);
          switchonoff("report-collection-switch", e.rep_collection);
          switchonoff("report-abstract-switch", e.rep_abstract);
          
          $("#ipt-password, #ipt-retype").hide();
          
          $("#user-modal").modal('show');
        },
      });
	});

	$.validator.setDefaults({
		submitHandler: function () {
		  $.ajax({
		  	url: "../config/includes.php?var="+state.url,
		  	method: "POST",
		  	data: $("#user-form").serialize() + "&id=" + state['id'],
		  	dataType: "JSON",
		  	success: function (e) {
		  		if (e.result) {
		  			 Swal.fire("Nice!", e.msg, "success");
		  			 usermanagementtable.ajax.reload();
		  		} else {
		  			 Swal.fire("Ops!", e.msg, "error");
		  		}
		  	}
		  });
		}
	});

	$('#user-form').validate({
	    rules: {
	      fullname: {
	        required: true
	      },
	      position: {
	        required: true
	      },
	      username: {
	        required: true
	      },
	      password: {
	        required: true,
	        minlength: 5
	      },
	      retype: {
	        required: true,
	        minlength: 5,
	        equalTo: '#password'
	      },
	    },
	    messages: {
	      fullname: {
	        required: "Please enter a username."
	      },
	      position: {
	        required: "Please enter a username."
	      },
	      username: {
	        required: "Please enter a username."
	      },
	      password: {
	        required: "Please provide a password",
	        minlength: "Your password must be at least 5 characters long"
	      },
	      retype: {
	        required: "Password does not match.",
	        minlength: "Your password must be at least 5 characters long"
	      },
	    },
	    errorElement: 'span',
	    errorPlacement: function (error, element) {
	      error.addClass('invalid-feedback');
	      element.closest('.form-group').append(error);
	    },
	    highlight: function (element, errorClass, validClass) {
	      $(element).addClass('is-invalid');
	    },
	    unhighlight: function (element, errorClass, validClass) {
	      $(element).removeClass('is-invalid');
	    }
	});

});