jQuery(document).ready(function (e) {
  jQuery("#position-type").on("change", function () {
    if (jQuery("option.fixed").is(":selected")) {
        jQuery(".fixed-position-option").slideDown();
    }
    if (jQuery("option.static").is(":selected")) {
      jQuery(".fixed-position-option").slideUp();
    }
  });
  jQuery(".br-range-output").text(jQuery("#border-r").val() + "px");
  jQuery("#border-r").on("input", function () {
    jQuery(".br-range-output").val(this.value + "px");
  });

  jQuery(".offset-x-output").text(jQuery("#offset-x").val() + "px");
  jQuery("#offset-x").on("input", function () {
    jQuery(".offset-x-output").val(this.value + "px");
  });

  jQuery(".offset-y-output").text(jQuery("#offset-y").val() + "px");
  jQuery("#offset-y").on("input", function () {
    jQuery(".offset-y-output").val(this.value + "px");
  });
});
