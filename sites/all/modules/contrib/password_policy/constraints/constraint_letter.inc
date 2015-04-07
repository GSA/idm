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
function password_policy_constraint_letter_description() {
  return array('name' => t('Letter'), 'description' => t('Password must contain the specified minimum number of letters.'));
}

/**
 * Error message of the constraint.
 */
function password_policy_constraint_letter_error($constraint) {
  return format_plural($constraint, 'Password must contain at least one letter.', 'Password must contain at least @count letters.');
}

/**
 * Password validation.
 */
function password_policy_constraint_letter_validate($password, $constraint, $account) {
  $chars = drupal_strlen($password);
  $num = 0;
  for ($i = 0; $i < $chars; ++$i) {
    $char = drupal_substr($password, $i, 1);
    if (ctype_alpha($char)) {
      $num++;
    }
  }
  return $num >= $constraint;
}

/**
 * Javascript portion.
 */
function password_policy_constraint_letter_js($constraint, $account) {
  return <<<JS

    var i = 0;
    var num = 0;
    var chr = "";
    while (i < value.length) {
      chr = value.charAt(i);
      if (chr.toUpperCase() != chr.toLowerCase()) {
        num++;
      }
      i++;
    }
    if (num < $constraint) {
      strength = "low";
      msg.push(translate.constraint_letter);
    }
JS;
}
