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
function password_policy_constraint_complexity_description() {
  return array('name' => t('Complexity'), 'description' => t('Password must contain the specified minimum number of character types (lowercase, uppercase, digit or punctuation).'));
}

/**
 * Error message of the constraint.
 */
function password_policy_constraint_complexity_error($constraint) {
  return format_plural($constraint, 'Password must contain at least one character of the following types: lowercase, uppercase, digit or punctuation.', 'Password must contain at least @count characters of different types (lowercase, uppercase, digit or punctuation).');
}

/**
 * Password validation.
 */
function password_policy_constraint_complexity_validate($password, $constraint, $account) {
  $chars = drupal_strlen($password);
  $num = 0;
  $upper = 0;
  $lower = 0;
  $digit = 0;
  $punct = 0;
  for ($i = 0; $i < $chars; ++$i) {
    $char = drupal_substr($password, $i, 1);
    if (ctype_upper($char)) {
      $upper = 1;
    }
    elseif (ctype_lower($char)) {
      $lower = 1;
    }
    elseif (ctype_digit($char)) {
      $digit = 1;
    }
    elseif (ctype_punct($char)) {
      $punct = 1;
    }
  }
  $num = $upper + $lower + $digit + $punct;
  return $num >= $constraint;
}

/**
 * Javascript portion.
 */
function password_policy_constraint_complexity_js($constraint, $account) {
  return <<<JS

    var i = 0;
    var num = 0;
    var upper = 0;
    var lower = 0;
    var digit = 0;
    var punct = 0;
    var chr = "";
    while (i < value.length) {
      chr = value.charAt(i);
      if (chr.toUpperCase() != chr.toLowerCase()) {
        if (chr == chr.toUpperCase()) {
          upper = 1;
        }
        else {
          lower = 1;
        }
      }
      else if ("1234567890".indexOf(chr) != -1) {
        digit = 1;
      }
      else if (chr.toUpperCase() == chr.toLowerCase() && "1234567890".indexOf(chr) == -1 && chr != ' ') {
        punct = 1;
      }
      i++;
    }
    num = upper + lower + digit + punct;
    if (num < $constraint) {
      strength = "low";
      msg.push(translate.constraint_complexity);
    }
JS;
}
