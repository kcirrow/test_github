//==============================================================================================================================
// Franchise Expiry
//==============================================================================================================================

  $.ajax({
    url: "../config/includes.php?var=getfranexpdate",
    method: "POST",
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        $("#fran-exp").val(e.data.noofyr);
        $("#exp-mode").val(e.data.expmode).trigger("change");
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });

$("#exp-mode").change(function () {
  if ($(this).val() == 0) {
    $("#fran-exp").attr('disabled', false);
  } else {
    $("#fran-exp").attr('disabled', true);
  }
});
  
$("#btn-fran-exp-edit").click(function (e) {
    e.preventDefault();
    $.ajax({
    url: "../config/includes.php?var=updatefranexpdate",
    method: "POST",
    data: $('#fran-exp-form-submit').serialize(),
    dataType: "JSON",
    success: function (e) {
      if (e.result) {
        Swal.fire("Nice!", e.msg, "success");
      } else {
        Swal.fire("Ops!", e.msg, "error");
      }
    },
  });
});