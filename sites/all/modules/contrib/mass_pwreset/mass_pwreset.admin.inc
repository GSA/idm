<?php

/**
 * @file
 * mass_pwreset.admin.unc
 *
 * Admin page callbacks for the mass_pwreset module.
 */
function mass_pwreset_form($form, $form_state) {
  $form['options'] = array(
    '#type' => 'fieldset',
    '#title' => t('Options'),
  );
  $form['options']['notify_users'] = array(
    '#type' => 'checkbox',
    '#title' => t('Notify users of password reset via email'),
    '#description' => t('Notify users of password reset with Drupal\'s password recovery email.'),
    '#default_value' => 0,
  );
  $form['options']['include_admin_user'] = array(
    '#type' => 'checkbox',
    '#title' => t('Include admin user (uid1)'),
    '#description' => t('Include the administrative superuser id 1 account in the list of passwords being reset.'),
    '#default_value' => 0,
  );
  $form['reset_passwords'] = array(
    '#type' => 'submit',
    '#value' => t('Reset passwords'),
    '#submit' => array('mass_pwreset_submit'),
  );

  return $form;
}

/**
 * Reset paswords and notify users
 *
 */
function mass_pwreset_submit($form, &$form_state) {
  // Load up the users!
  $users = entity_load('user');

  // Loop through each user and process password resets and email users.
  foreach ($users as $user) {
    // Process uid1 if user requested.
    if ($user->uid == '1' && $form_state['values']['include_admin_user'] == '1') {
      $new_pass = _mass_pwreset_generate_password(12, TRUE);
      user_save($user, array('pass' => $new_pass));
      drupal_set_message(t('UID1 password reset.'), 'status');
      if ($form_state['values']['notify_users'] == '1') {
        _user_mail_notify('password_reset', $user);
        drupal_set_message(t('UID1 user notified via email.'), 'status');
      }
    }
    // Process standard users and exclude uid0
    elseif ($user->uid !== '0' && $user->uid !== '1') {
      $new_pass = _mass_pwreset_generate_password(12, TRUE);
      user_save($user, array('pass' => $new_pass));
      drupal_set_message(t('Users passwords reset.'), 'status');
      if ($form_state['values']['notify_users'] == '1') {
        _user_mail_notify('password_reset', $user);
        drupal_set_message(t('Users notified via email.'), 'status');
      }
    }

  }

}
