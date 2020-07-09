$(function () {
  $(window).scroll(function () {
    if ($(this).scrollTop() > 5) {
      $("header#header").css({
        "box-shadow": "0px 2px 20px 0px rgba(162, 160, 161, 0.3)",
      });
    } else {
      $("header#header").css({
        "box-shadow": "none",
      });
    }
  });
});

$(document).ready(function () {
  $(".borrar").click(function () {
    if (!confirm("¿Está seguro de esta operación?")) {
      return false;
    }
  });
});
