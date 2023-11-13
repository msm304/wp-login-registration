jQuery(document).ready(function ($) {
  $(".lr-login").on("submit", function (e) {
    e.preventDefault();
    let email = $("#email").val();
    let password = $("#password").val();
    let remember_me = $("#remember-me").prop("checked");
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
      beforeSend: function () {
        $("#lr-loading").html(
          '<div class="lds-facebook"><div></div><div></div><div></div></div>'
        );
      },
      success: function (response) {
        if (response.success) {
          $("#error-handler")
            .removeClass("alert-danger")
            .addClass("alert-success")
            .text(response.message);
          $("#lr-loading").html(
            '<div class="lds-facebook"><div></div><div></div><div></div></div>'
          );
          setTimeout(function () {
            window.location.href = document.documentURI;
          });
        }
      },
      error: function (error) {
        if (error.responseJSON.error) {
          $("#error-handler")
            .removeClass("alert-success")
            .addClass("alert-danger")
            .text(error.responseJSON.message);
          $("#lr-loading").text("ورود به حساب");
        }
      },
    });
  });
  // send sms
    $("body").on("click", "#send-code", function (e) {
      e.preventDefault();
      let el = $(this);
      let user_phone = $(".user-phone").val();
      $.ajax({
        url: lr_ajax.lr_ajaxurl,
        type: "POST",
        dataType: "JSON",
        data: {
          action: "wp_lr_auth_send_verification_code",
          user_phone: user_phone,
          nonce: lr_ajax._lr_nonce,
        },
        success: function (response) {
          $("#user-phone-number").hide();
          $("#verification-code").show();
          el.attr("id", "verify-code");
          el.text("اعتبار سنجی کد تایید");
        },
        error: function (error) {
          if (error.responseJSON.error) {
            alert(error.responseJSON.message);
          }
        },
      });
    });
  $("body").on("click", "#verify-code", function (e) {
    e.preventDefault();
    let el = $(this);
    let verification_code = $(".verification-code").val();
    $.ajax({
      url: lr_ajax.lr_ajaxurl,
      type: "POST",
      dataType: "JSON",
      data: {
        action: "wp_lr_auth_verify_verification_code",
        verification_code: verification_code,
        nonce: lr_ajax._lr_nonce,
      },
      success: function (response) {
        $("#user-phone-number").hide();
        $("#verification-code").show();
      },
      error: function (error) {
        if (error.responseJSON.error) {
          alert(error.responseJSON.message);
        }
      },
    });
  });


});
