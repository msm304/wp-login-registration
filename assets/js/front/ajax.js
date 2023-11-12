jQuery(document).ready(function ($) {
  $(".lr-login").on("submit", function (e) {
    e.preventDefault();
    let email = $("#email").val();
    let password = $("#password").val();
    let remember_me = $("#remember-me").val();
    $.ajax({
      type: "POST",
      url: lr_ajax.lr_ajaxurl,
      dataType: "JSON",
      data: {
        action: "wp_lr_auth_login",
        email: email,
        password: password,
        remember_me: remember_me,
        nonce: lr_ajax._lr_nonce,
      },
      success: function (response) {},
    });
  });
});
