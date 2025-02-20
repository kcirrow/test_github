 $(document).ready(function () {
  var state = {};
  
  handleInput = function (x, y) {
    state[y] = x;
  }

  $("#su-submit").submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: "../config/includes.php?var=insertUsers",
      method: "POST",
      data: state,
      dataType: "JSON",
      success: function (result) {
        $("#sumsg").html(result["msg"]);
        $("#sumsg").css("color", result["msgcolor"]);
      }
    });
  });
}); 