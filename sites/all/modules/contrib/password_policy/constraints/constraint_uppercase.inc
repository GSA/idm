<?php
/**
 * @file
 * Password policy constraint callbacks.
 */

/****************************************************************************/
/* Constraint API                                                           */
/****************************************************************************/

/**
 * Description of the constraint.
 */
function password_policy_constraint_uppercase_description() {
  return array('name' => t('Uppercase'), 'description' => t('Password must contain the specified minimum number of uppercase letters.'));
}

/**
 * Error message of the constraint.
 */
function password_policy_constraint_uppercase_error($constraint) {
  return format_plural($constraint, 'Password must contain at least one uppercase character.', 'Password must contain at least @count uppercase characters.');
}

/**
 * Password validation.
 */
function password_policy_constraint_uppercase_validate($password, $constraint, $account) {
  $chars = drupal_strlen($password);
  $num = 0;
  for ($i = 0; $i < $chars; ++$i) {
    if (ctype_upper(drupal_substr($password, $i, 1))) {
      $num++;
    }
  }
  return $num >= $constraint;
}

/**
 * Javascript portion.
 */
function password_policy_constraint_uppercase_js($constraint, $account) {
  return <<<JS

    var i = 0;
    var num = 0;
    var chr = "";
    while (i < value.length) {
      chr = value.charAt(i);
      if (chr.toUpperCase() != chr.toLowerCase()) {
        if (chr == chr.toUpperCase()) {
          num++;
        }
      }
      i++;
    }
    if (num < $constraint) {
      strength = "low";
      msg.push(translate.constraint_uppercase);
    }
JS;
}
