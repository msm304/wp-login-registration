jQuery(document).ready(function () {
  jQuery("body").on("click", ".like-button", function (e) {
    e.preventDefault();
    let el = jQuery(this);
    let post_id = el.data("post-id");
    let user_id = el.data("user-id");
    // console.log(el);
    jQuery.ajax({
      type: "POST",
      url: ls_ajax.ls_ajaxurl,
      dataType: "JSON",
      data: {
        action: "wp_ls_like_post",
        post_id: post_id,
        user_id: user_id,
        _nonce: ls_ajax._ls_nonce,
      },
      success: function (response) {
        if (response.success) {
          jQuery.toast({
            text: response.message,
            icon: "success",
            loader: true, // Change it to false to disable loader
            position: "top-left",
            bgColor: "#2ecc71",
            textColor: "white",
            textAlign: "right",
            loaderBg: "#202124", // To change the background
            allowToastClose: false,
          });
          jQuery("#like-counter").text(response.like_number);
          el.removeClass("like-button").addClass("unlike-button");
        }
      },
      error: function (error) {
        if (error) {
          jQuery.toast({
            text: error.responseJSON.message,
            icon: "error",
            loader: true, // Change it to false to disable loader
            position: "top-left",
            bgColor: "#da0b4e",
            textColor: "white",
            textAlign: "right",
            loaderBg: "#202124", // To change the background
            allowToastClose: false,
          });
        }
      },
    });
  });
  jQuery("body").on("click", ".unlike-button", function (e) {
    // alert("unlike");
    e.preventDefault();
    let el = jQuery(this);
    let post_id = el.data("post-id");
    let user_id = el.data("user-id");
    // console.log(el);
    jQuery.ajax({
      type: "POST",
      url: ls_ajax.ls_ajaxurl,
      dataType: "JSON",
      data: {
        action: "wp_ls_unlike_post",
        post_id: post_id,
        user_id: user_id,
        _nonce: ls_ajax._ls_nonce,
      },
      success: function (response) {
        if (response.success) {
          jQuery.toast({
            text: response.message,
            icon: "success",
            loader: true, // Change it to false to disable loader
            position: "top-left",
            bgColor: "#2ecc71",
            textColor: "white",
            textAlign: "right",
            loaderBg: "#202124", // To change the background
            allowToastClose: false,
          });
          jQuery("#like-counter").text(response.like_number);
          el.removeClass("unlike-button").addClass("like-button");
        }
      },
      error: function (error) {
        if (error) {
          jQuery.toast({
            text: error.responseJSON.message,
            icon: "error",
            loader: true, // Change it to false to disable loader
            position: "top-left",
            bgColor: "#da0b4e",
            textColor: "white",
            textAlign: "right",
            loaderBg: "#202124", // To change the background
            allowToastClose: false,
          });
        }
      },
    });
  });
});
