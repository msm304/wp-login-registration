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
      beforeSend: function () {
        $("#send-code").html(
          '<div class="lds-facebook"><div></div><div></div><div></div></div>'
        );
      },
      success: function (response) {
        $("#user-phone-number").hide();
        $("#verification-code").show();
        el.attr("id", "verify-code");
        el.text("اعتبار سنجی کد تایید");
        if (response.success) {
          $.toast({
            text: response.message,
            icon: "success",
            loader: true, // Change it to false to disable loader
            loaderBg: "#202124", // To change the background
            bgColor: "#2ecc71",
            textAlign: "right",
          });
        }
      },
      error: function (error) {
        if (error.responseJSON.error) {
          // alert(error.responseJSON.message);
          if (error) {
            $.toast({
              heading: "توجه !!!",
              text: error.responseJSON.message,
              icon: "error",
              loader: true, // Change it to false to disable loader
              loaderBg: "#202124", // To change the background
              textAlign: "right",
            });
          }
        }
      },
      complete: function () {
        $("#send-code").text("ارسال کد تایید");
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
      beforeSend: function () {
        $("#verify-code").html(
          '<div class="lds-facebook"><div></div><div></div><div></div></div>'
        );
      },
      success: function (response) {
        $("#get-user-phone").html(
          '<div id="register_form"> <div class="form-group"><label>نام و نام خانوادگی*</label> <input type="text" class="form-control display-name" value=""  placeholder="نام و نام خانوادگی..."> </div> <div class="form-group"><label>ایمیل*</label><input type="email..." class="form-control email" value="" placeholder="email..." dir="ltr"></div> <div class="form-group"><label>رمز عبور*</label><input type="text" class="form-control password" value=""></div> <div class="form-group"> <a href="" class="btn btn_apply w-100 " id="register-user">ثبت نام</a> </div></div>'
        );
      },
      error: function (error) {
        if (error.responseJSON.error) {
          if (error) {
            $.toast({
              heading: "توجه !!!",
              text: error.responseJSON.message,
              icon: "error",
              loader: true, // Change it to false to disable loader
              loaderBg: "#202124", // To change the background
              textAlign: "right",
            });
          }
        }
      },
      complete: function () {
        $("#verify-code").text("اعتبار سنجی کد تایید");
      },
    });
  });
  $("body").on("click", "#register-user", function (e) {
    e.preventDefault();
    let el = $(this);
    let display_name = $(".display-name").val();
    let email = $(".email").val();
    let password = $(".password").val();
    $.ajax({
      url: lr_ajax.lr_ajaxurl,
      type: "POST",
      dataType: "JSON",
      data: {
        action: "wp_lr_register_user",
        display_name: display_name,
        email: email,
        password: password,
        nonce: lr_ajax._lr_nonce,
      },
      beforeSend: function () {
        $("#register-user").html(
          '<div class="lds-facebook"><div></div><div></div><div></div></div>'
        );
      },
      success: function (response) {
        if (response.success) {
          $.toast({
            text: response.message,
            icon: "success",
            loader: true, // Change it to false to disable loader
            loaderBg: "#202124", // To change the background
            bgColor: "#2ecc71",
            textAlign: "right",
          });
          setTimeout(function () {
            window.location.href = "/";
          }, 3100);
        }
      },
      error: function (error) {
        if (error) {
          $.toast({
            heading: "توجه !!!",
            text: error.responseJSON.message,
            icon: "error",
            loader: true, // Change it to false to disable loader
            loaderBg: "#202124", // To change the background
            textAlign: "right",
          });
        }
      },
      complete: function () {},
    });
  });
  $("#send-recovery-mail").on("click", function (e) {
    e.preventDefault();
    let el = $(this);
    let email = $(".recover-email").val();
    $.ajax({
      url: lr_ajax.lr_ajaxurl,
      type: "POST",
      dataType: "JSON",
      data: {
        action: "wp_lr_recover_password",
        email: email,
        nonce: lr_ajax._lr_nonce,
      },
      beforeSend: function () {
        $("#send-recovery-mail").html(
          '<div class="lds-facebook"><div></div><div></div><div></div></div>'
        );
      },
      success: function (response) {
        if (response.success) {
          $.toast({
            text: response.message,
            icon: "success",
            loader: true, // Change it to false to disable loader
            loaderBg: "#202124", // To change the background
            bgColor: "#2ecc71",
            textAlign: "right",
          });
        }
      },
      error: function (error) {
        if (error) {
          $.toast({
            heading: "توجه !!!",
            text: error.responseJSON.message,
            icon: "error",
            loader: true, // Change it to false to disable loader
            loaderBg: "#202124", // To change the background
            textAlign: "right",
          });
        }
      },
      complete: function () {
        $("#send-recovery-mail").text("ارسال مجدد لینک تغییر کلمه عبور");
      },
    });
  });
});
