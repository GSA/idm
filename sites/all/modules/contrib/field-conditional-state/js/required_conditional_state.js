/**
 * Add behavior for required condition.
 */

(function ($) {
  $(document).bind('state:required', function(e) {
   	var label = $(e.target).closest('.form-item, .form-submit, .form-wrapper').find("label").first();
   	var required = '<span title="This field is required." class="form-required">*</span>';
    $(e.target).closest('.form-item, .form-submit, .form-wrapper').removeClass('form-required');

    var none_input =  $(e.target).find('input[value=_none]');
    var none_option = $(e.target).find('option[value=_none]');
    if (e.trigger) {
      if (e.value) {
        // Check for multivalue field - if textfield has more than one value
        // form elements are displayed in table header of the table (hidden) is
        // also on the top of the page then we need to add required class for
        // all the labels for this field.
        if ($(e.target).find("span.form-required").first().length == 0 && $(e.target).find("table").length == 0) {
          label.append(required);
        }
        else if ($(e.target).find("span.form-required").length == 0 && $(e.target).find("table").length){
          $(e.target).find("table th").find("label").append(required);
        }
        none_option.hide();
        none_input.parent().hide();
      }
      else {
        none_option.show();
        none_input.parent().show();
        label.find("span.form-required").remove();
        $(e.target).find("table th").find("label").find("span.form-required").remove();
      }
    }
  });
})(jQuery);
