$(document).ready(function() {
  $("#login").on("click", function() {
    var data = {
      "username": $("input[name='username']").val(),
      "password": $("input[name='password']").val()
    };
    $.post("login_handler.php", data, function(response) {
      $("body").html(response);
    });
  });
});
