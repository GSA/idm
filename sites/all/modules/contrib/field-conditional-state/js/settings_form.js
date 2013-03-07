(function ($) {

/**
 * Hide or show condition type field based on the count of control values.
 */
Drupal.behaviors.fieldConditionalState = {
  attach: function (context, settings) {
    var target = $('.form-item-add-field-state-condition-type')
      .hide();
    var selected = $('.values-selection').find('select option:selected');
    show_hide(selected.length);
    $('.values-selection').find('select').change(function() {
      selected = $('.values-selection').find('select option:selected');
      show_hide(selected.length);
    });

    function show_hide(count) {
      if (count > 1) {
        target.show('slow');
      }
      else {
        target.hide('slow');
      }
    }
  }
};

}(jQuery));
