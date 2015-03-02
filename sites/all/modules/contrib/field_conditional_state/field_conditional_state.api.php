<?php
/**
 * @file
 * Hooks provided by Field Conditional States.
 */

/**
 * Allow modules to add widgets that should be supported by FCS.
 *
 * @return array
 *   An array whose keys are widget names and whose values are arrays
 *   containing the keys:
 *   - form_elements: An array containing the path(s) down the render
 *     array to the actual form element(s), based on the initialisation
 *     within hook_field_widget_form.
 *     This is used to determine where to add direct states.
 *     The element with index 0 will be used as trigger element (in case
 *     the widget is supported as control field).
 * 
 *   - field_data: An array containing the path(s) down the render array
 *     to the level where the keys #entity_type, #bundle and #field_name
 *     are set.
 * 
 *   - reprocess_from_root: (optional). By default , the states visible
 *     and invisible will be added to the top level of the render array
 *     defined in hook_field_widget_form. But sometimes this level of
 *     the render array won't be rendered by Drupal and the states won't
 *     have any effect. In case this happens reprocess_from_root should
 *     be set to true. Field Conditional States will then add the
 *     visibility states to the field level directly below the form root.
 * 
 *   - field_states: (optional) An array of states that can be applied
 *     to the widget. Valid values can be found here:
 *     https://api.drupal.org/api/drupal/includes%21common.inc/function/drupal_process_states/7
 *
 *   - trigger_states: (optional) An array of control states that can be
 *     used by widget. Valid values can be found here:
 *     https://api.drupal.org/api/drupal/includes%21common.inc/function/drupal_process_states/7
 *
 *   - trigger_value_widget: (optional) A callback function returning a
 *     form element to enter trigger values in the settings form. By
 *     default this is just a textfield.
 *
 *   - trigger_value_submit: (optional) A callback function which
 *     transforms the values entered in the trigger_value_widget into a
 *     string that can be saved as trigger value. For multivalue widgets
 *     this function may return an array of trigger values.
 */
function hook_field_conditional_state_settings_alter(&$settings) {

  $settings['my_widget'] = array(
    'form_elements' => array(
      array('value'),
      array('description'),
    ),
    'field_data' => array(),
    'field_states' => array('enabled', 'disabled', 'visible', 'invisible'),
    'trigger_states' => array('value', '!value', 'empty', 'filled'),
  );
}
