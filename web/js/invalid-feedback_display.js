var invalidInputSelectors = ".krajee-datepicker, .tt-input, input.grouped-input";
$("body").on("change focusout", invalidInputSelectors, function () {
  var input = $(this);
  setTimeout(function () {
    if (input.hasClass("is-invalid")) {
      input.closest("div").addClass("is-invalid");
    }
  }, 700);
});

$(document).ready(function () {
  $(invalidInputSelectors).each(function () {
    if ($(this).hasClass("is-invalid")) {
      $(this).closest("div").addClass("is-invalid");
    }
  });
});

$("body").on("click", "form#w0 button[type='submit']", function () {
  $(invalidInputSelectors).trigger("change");
});
