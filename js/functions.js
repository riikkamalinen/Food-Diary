function change_page(page_name, callback) {
  var data = {
    "page": page_name
  }
  $.get("content_loader.php", data, function(response) {
    $("main").html(response);
    if (callback !== undefined)
      callback();
  });
}

function open_popup(popup_page, data, callback) {
  $.get(popup_page, data, function(response) {
    $("#popup_bg").show();
    $("#popup").html(response);
    $("#popup").show();
    if (callback !== undefined)
      callback();
  });
}

function close_popup(callback) {
  $("#popup_bg").hide();
  $("#popup").hide();
  if (callback !== undefined)
    callback();
}

function save_user() {
  var data = { };
  $("input").css("border", "");
  $(".manage_user input").each(function() {
    data[$(this).attr("name")] = $(this).val();
  });
  $.post("contents/kayttajahallinta/save_user.php", data, function(response) {
    var errors = JSON.parse(response);
    $("#user_count").html(errors.shift());
    if (errors.length) {
      $.each(errors, function(key, val) {
        $("input[name=" + val + "]").css("border", "1px solid red");
      });
    } else {
      $.get("contents/kayttajahallinta/user_table.php", { "relative_root": 1 }, function(table) {
        $(".user_table_wrapper").html(table);
      });
    }
  });
}

function delete_user(element) {
  $.post("contents/kayttajahallinta/delete_user.php", { "user": element.attr("data-id") }, function(count) {
    $("#user_count").html(count);
    $.get("contents/kayttajahallinta/user_table.php", { "relative_root": 1 }, function(table) {
      $(".user_table_wrapper").html(table);
    });
  });
}
