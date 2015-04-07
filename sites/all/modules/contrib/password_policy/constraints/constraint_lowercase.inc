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
function password_policy_constraint_lowercase_description() {
  return array('name' => t('Lowercase'), 'description' => t('Password must contain the specified minimum number of lowercase letters.'));
}

/**
 * Error message of the constraint.
 */
function password_policy_constraint_lowercase_error($constraint) {
  return format_plural($constraint, 'Password must contain at least one lowercase character.', 'Password must contain at least @count lowercase characters.');
}

/**
 * Password validation.
 */
function password_policy_constraint_lowercase_validate($password, $constraint, $account) {
  $chars = drupal_strlen($password);
  $num = 0;
  for ($i = 0; $i < $chars; ++$i) {
    if (ctype_lower(drupal_substr($password, $i, 1))) {
      $num++;
    }
  }
  return $num >= $constraint;
}

/**
 * Javascript portion.
 */
function password_policy_constraint_lowercase_js($constraint, $account) {
  return <<<JS

    var i = 0;
    var num = 0;
    var chr = "";
    while (i < value.length) {
      chr = value.charAt(i);
      if (chr.toUpperCase() != chr.toLowerCase()) {
        if (chr == chr.toLowerCase()) {
          num++;
        }
      }
      i++;
    }
    if (num < $constraint) {
      strength = "low";
      msg.push(translate.constraint_lowercase);
    }
JS;
}
