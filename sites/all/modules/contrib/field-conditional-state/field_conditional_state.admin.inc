<?php

/**
 * @file
 * Field Conditional State admin settings.
 */

/**
 * Page callback: Field Conditional State admin settings.
 *
 * @see field_conditional_state_menu()
 * @ingroup forms
 */
function field_conditional_state_settings_form($form, &$form_state, $instance) {
  $bundle = $instance['bundle'];
  $entity_type = $instance['entity_type'];
  $field = field_info_field($instance['field_name']);
  $bundle_instances = field_info_instances($entity_type, $bundle);
  // Don't use edited field and body field.
  unset($bundle_instances[$instance['field_name']]);
  unset($bundle_instances['body']);

  // Available states to set.
  $states_types = array_keys(field_conditional_state_module_invoke());
  $control_instances = field_conditional_state_get_control_instances($bundle_instances);

  $form['#attached']['js'][] = drupal_get_path('module', 'field_conditional_state') . '/js/settings_form.js';
  $form['#tree'] = TRUE;

  if ($control_instances) {
    $form['add_field_state']['field_name'] = array(
      '#type' => 'item',
      '#title' => t('The field @field is', array('@field' => $instance['label'])),
    );
    $form['add_field_state']['state_type'] = array(
      '#type' => 'select',
      '#options' => drupal_map_assoc($states_types),
    );
    $form['add_field_state']['when'] = array(
      '#type' => 'item',
      '#title' => t('when field'),
    );
    $form['add_field_state']['control_field'] = array(
      '#type' => 'select',
      '#options' => field_conditional_state_get_instances_labels($control_instances),
    );
    $form['add_field_state']['is'] = array(
      '#type' => 'item',
      '#title' => t('is set to'),
    );

    $control_element = array();
    foreach ($control_instances as $field_name => $field_instance) {
      $field_info = field_info_field($field_name);
    
      $function = $field_instance['widget']['module'] . '_field_widget_form';
      if (function_exists($function)) {
        $langcode = '';
        $delta = '';
        $items = array();
        $element = array(
          '#entity' => array(),
          '#entity_type' => $field_instance['entity_type'],
          '#required' => $field_instance['required'],
        );
        $control_element[$field_name] = $function($form, $form_state, $field_info, $field_instance, $langcode, $items, $delta, $element);
      }
      unset($control_element[$field_name]['#element_validate']);

      $type = str_replace($field_instance['widget']['module'] . '_', '', $field_instance['widget']['type']);
      switch ($type) {
        case 'select':
        case 'buttons':
          $control_element[$field_name]['#type'] = 'select';
          break;

        case 'onoff':
          unset($control_element[$field_name]['#default_value']);
          $control_element[$field_name]['#options'] = array(
            $control_element[$field_name]['#on_value'] => 'checked',
            $control_element[$field_name]['#off_value'] => 'unchecked',
          );
          $control_element[$field_name]['#type'] = 'select';
          break;
      }
      $total_options = count($control_element[$field_name]['#options']);

      $form['add_field_state']['options'][$field_name] = array_merge(
        $control_element[$field_name],
        array(
          '#required' => FALSE,
          '#multiple' => TRUE,
          '#states' => array(
            'visible' => array(
              ':input[name="add_field_state[control_field]"]' => array('value' => $field_name),
            ),
          ),
          '#size' => $total_options > 5 ? 5 : $total_options,
          '#prefix' => '<div class = "values-selection">',
          '#suffix' => '</div>',
        )
      );
    }

    $form['add_field_state']['condition_type'] = array(
      '#title' => t('Condition type'),
      '#type' => 'select',
      '#description' => t('OR -> any choice will control field, <br /> AND -> all choices must be selected to control field'),
      '#options' => array('or' => 'OR', 'and' => 'AND'),
    );
    $form['trigger_field'] = array(
      '#type' => 'hidden',
      '#value' => $instance['field_name'],
    );
    $form['bundle'] = array(
      '#type' => 'hidden',
      '#value' => $bundle,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Add condition'),
      '#name' => 'add_condition',
    );

    $field_conditional_states = field_conditional_state_get_field_conditions($instance['field_name'], $bundle);
    if (isset($field_conditional_states)) {
      foreach ($field_conditional_states as $condition_id => $condition_settings) {
        $trigger_values = array();
        $options = $control_element[$condition_settings['control_field']]['#options'];
        if (isset($condition_settings['trigger_values'])) {
          foreach ($condition_settings['trigger_values'] as $val) {
            $trigger_values[$val] = $options[$val];
          }
          $condition_type = t('@c', array('@c' => $condition_settings['condition_type']));
          $trigger_values = implode(" $condition_type ", $trigger_values);
        }
        $placeholders = array(
          '%target_field' => $instance['label'],
          '@state' => $condition_settings['state'],
          '%control_field' => $bundle_instances[$condition_settings['control_field']]['label'],
          '@trigger_values' => $trigger_values,
        );
        $value = t('Field %target_field is @state when field %control_field has value @trigger_values', $placeholders);
        $id = $condition_settings['id'];

        $form['field_states'][$condition_id]['condition'] = array(
          '#type' => 'item',
          '#title' => filter_xss($value),
        );
        $form['field_states'][$condition_id]['delete'] = array(
          '#type' => 'hidden',
          '#value' => $id,
        );
        $form['field_states'][$condition_id]['submit'] = array(
          '#type' => 'submit',
          '#value' => t('Delete condition'),
          '#name' => 'delete_condition_' . $id,
        );
      }
    }
  }
  else {
    $form['add_field_state']['control_field'] = array(
      '#type' => 'item',
      '#title' => t('No control field to select! You need at least one checkbox/radio or select list field for this content type.'),
    );
  }
  return $form;
}

/**
 * Form validation handler for field_conditional_state_settings_form().
 */
function field_conditional_state_settings_form_validate($form, &$form_state) {
  if ($form_state['triggering_element']['#value'] == t('Add condition')) {
    $target_field = $form_state['values']['trigger_field'];
    $control_field = $form_state['values']['add_field_state']['control_field'];
    $state_type = $form_state['values']['add_field_state']['state_type'];
    $bundle = $form_state['values']['bundle'];
    $query_args = array(':field_name' => $target_field, ':control_field' => $control_field, ':state' => $state_type, ':bundle' => $bundle);
    $result = db_query("SELECT count(*) AS count FROM {field_conditional_state} WHERE field_name = :field_name AND control_field = :control_field AND state = :state AND bundle = :bundle", $query_args)->fetchObject();
    if ($result->count > 0) {
      form_set_error("add_field_state][state_type", t("You already have this state type between these two fields."));
    }
    elseif (empty($form_state['values']['add_field_state']['options'][$control_field])) {
      form_set_error("add_field_state][options][$control_field", t("You need to select at least one of the value."));
    }
  }
}

/**
 * Form submission handler for field_conditional_state_settings_form().
 */
function field_conditional_state_settings_form_submit($form, &$form_state) {
  if ($form_state['triggering_element']['#value'] == t('Delete condition')) {
    list($field_states, $condition_id) = $form_state['triggering_element']['#parents'];
    $delete_condition_id = $form_state['values'][$field_states][$condition_id]['delete'];
    $delete_condition = db_delete('field_conditional_state')
      ->condition('id', $delete_condition_id, '=')
      ->execute();
  }
  else {
    $target_field = $form_state['values']['trigger_field'];
    $bundle = $form_state['values']['bundle'];
    $values = $form_state['values']['add_field_state'];
    $state_type = $values['state_type'];
    $control_field = $values['control_field'];
    // If there is only one control value selected set condition type to OR.
    $condition_type = (count($values['options'][$control_field]) == 1) ? 'or' : $values['condition_type'];
    if (count($values['options'][$control_field]) == 1) {
      $condition_type = 'or';
    }
    $control_values = serialize($values['options'][$control_field]);
    $condition = db_insert('field_conditional_state')->fields(array(
      'field_name' => $target_field,
      'control_field' => $control_field,
      'state' => $state_type,
      'bundle' => $bundle,
      'trigger_values' => $control_values,
      'condition_type' => $condition_type
    ))
    ->execute();
  }
}

/**
 * Returns HTML for a field's conditional state settings form.
 *
 * @param $variables
 *   An associative array containing:
 *   - form: A render element representing the form.
 *
 * @ingroup themable
 */
function theme_field_conditional_state_settings_form($variables) {
  $form = $variables['form'];
  // Add conditional state table.
  foreach (element_children($form['add_field_state']) as $key) {
    $row[] = array('data' => drupal_render($form['add_field_state'][$key]), 'align' => 'center', 'width' => '15%');
  }
  $rows[] = $row;

  $output = theme('table', array('header' => array(), 'rows' => $rows));
  $output .= drupal_render($form['submit']);

  // Current conditional states for field.
  $condition_rows = array();
  if (isset($form['field_states'])) {
    foreach (element_children($form['field_states']) as $condition_id) {
      $condition_rows[] = array(
        array('data' => drupal_render($form['field_states'][$condition_id]['condition'])),
        array('data' => drupal_render($form['field_states'][$condition_id]['submit']), 'align' => 'center'),
      );
    }
    $output .= theme('table', array('header' => array(t('Condition'), ''), 'rows' => $condition_rows));
  }
  else {
    $output .= t("You don't have any conditions for this field.");
  }
  $output .= drupal_render_children($form);
  return $output;
}

/**
 * Returns a list of field instance labels.
 *
 * @param $instances
 *   An array of field instances.
 *
 * @return
 *   An array of field instance labels, keyed by field name.
 */
function field_conditional_state_get_instances_labels($instances) {
  $labels_array = array();
  foreach ($instances as $field_name => $field_instance) {
    $labels_array[$field_name] = $field_instance['label'];
  }
  return $labels_array;
}

/**
 * Returns a list of all available control instances.
 *
 * @param $instances
 *   An array of field instances.
 *
 * @return
 *   An array of field instances, keyed by field name.
 */
function field_conditional_state_get_control_instances($instances) {
  $instances_array = array();
  $selectable_widget_types = array('options_select', 'options_buttons', 'options_onoff');
  foreach ($instances as $field_name => $field_instance) {
    if (in_array($field_instance['widget']['type'], $selectable_widget_types)) {
      $instances_array[$field_name] = $field_instance;
    }
  }
  return $instances_array;
}
