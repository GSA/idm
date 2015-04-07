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
function password_policy_constraint_punctuation_description() {
  return array('name' => t('Punctuation'), 'description' => t('Password must contain the specified minimum number of punctuation (not whitespace or an alphanumeric) characters.'));
}

/**
 * Error message of the constraint.
 */
function password_policy_constraint_punctuation_error($constraint) {
  return format_plural($constraint, 'Password must contain at least one punctuation (not whitespace or an alphanumeric) character.', 'Password must contain at least @count punctuation (not whitespace or an alphanumeric) characters.');
}

/**
 * Password validation.
 */
function password_policy_constraint_punctuation_validate($password, $constraint, $account) {
  $chars = drupal_strlen($password);
  $num = 0;
  for ($i = 0; $i < $chars; ++$i) {
    if (ctype_punct(drupal_substr($password, $i, 1))) {
      $num++;
    }
  }
  return $num >= $constraint;
}

/**
 * Javascript portion.
 */
function password_policy_constraint_punctuation_js($constraint, $account) {
  return <<<JS

    var i = 0;
    var num = 0;
    var chr = "";
    while (i < value.length) {
      chr = value.charAt(i);
      if (chr.toUpperCase() == chr.toLowerCase() && "1234567890".indexOf(chr) == -1 && chr != ' ') {
        num++;
      }
      i++;
    }
    if (num < $constraint) {
      strength = "low";
      msg.push(translate.constraint_punctuation);
    }
JS;
}
