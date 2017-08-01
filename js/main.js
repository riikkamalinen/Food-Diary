
$(document).ready(function() {
  //Bindaukset

  //Popup
  $("main").on("click", ".popup", function(e) {
    var data = $(this).attr("data-data") === "" ? "" : JSON.parse($(this).attr("data-data"));
    open_popup($(this).attr("data-page"), data);
  });

  $("#popup_bg").on("click", function(e) {
    if (e.target !== this)
      return;

    close_popup();
  });

  $(".logout").on("click", function() {
    $.get("login_handler.php", { "logout": "true" }, function(response) {
      $("body").html(response);
    });
  });

  $("#popup").on("click", ".manage_user .btn_save", function(response) {
    save_user();
  });

  $(".user_table_wrapper").on("click", ".btn_delete", function() {
    delete_user($(this));
  });

  $("a").on("click", function(e) {
    e.preventDefault();
    var url = $(this).attr("href");
    var content = $(this).attr("data-content");
    history.pushState(content, null, url);
    change_page(content);
  });

  $(window).on("popstate", function(e) {
    change_page(e.originalEvent.state);
  });

});
