/**
 * Extend Drupal.states.Dependent.comparisons. With this extension condition
 * states can be set as array:
 * JQUERY_SELECTOR => array('value' => array('value_1', 'value_2', ....)),
 */

(function ($) {
  if (Drupal.states) {
    var states = Drupal.states.Dependent.comparisons;
    var trigger = false;

    var arrayState = {
      'Array': function (reference, value) {
        // in case of boolean Single on/off checkbox - when field is unchecked value is empty
        if (value == '') {
		  value = 0;
		}
      	var conditionType = reference.condition_type;
	      if (value instanceof Array) {
	        if (conditionType == 'or') {
	          var found = false;
	          $.each(reference, function(index, val) {
		        for (var i = 0; i < value.length; ++i) {
	              if (value[i] == val) {
	                found = true;
	                return false;
	              }
	            }
	          });
	          
	          if ($('.date-conditional-state').length != 0) {
	            date_field_handler(found);
              }
	          return found;
			}
            else {   // conditionType is and
	          var not_found = false;
		        $.each(reference, function(index, val) {
		          for (var i = 0; i < value.length; ++i) {
	                if (value[i] == val) {
	                  return;
                    }
	              }
	              not_found = true;
	              return false;
	            });
	            if ($('.date-conditional-state').length != 0) {
	              date_field_handler(!not_found);
                }
	            return !not_found;
	        }
	      }
	      else {
	        for (var i = 0; i < reference.length; ++i) {
	          if (reference[i] == value) {
	            date_field_handler(true);
	            return true;
	          }
	        }
	        if ($('.date-conditional-state').length != 0) {
	          date_field_handler(false);
          }
	        return false;
  	    }
      }
    };

    var extendStates = $.extend(true, states, arrayState);
    Drupal.states.Dependent.comparisons = extendStates;
    // needed for IE7, IE8
    Drupal.states.Dependent.prototype.compare =
      function (reference, selector, state) {
        var value = this.values[selector][state.name];
        var name = reference.constructor.name;
        if (!name) {
          name = reference.constructor.toString().match(/function +([a-zA-Z0-9_]+) *\(/)[1];
        }
        if (name in Drupal.states.Dependent.comparisons) {
          // Use a custom compare function for certain reference value types.
          return Drupal.states.Dependent.comparisons[name](reference, value);
        }
        else {
          // Do a plain comparison otherwise.
          return compare(reference, value);
        }
    };

    Drupal.states.Trigger.states.value.change = function () {
      var values = this.val();
      if (values instanceof Array) {
        return values;
      }
      else {
        if (this.is('input')) {
          return this.filter(':checked').map(function() {
            return $(this).val();
          }).get();
        }
        else {
          return $(this).val();
        }
      }
    }
  }

  if (Drupal.behaviors.states) {
    var old_hook = Drupal.behaviors.states.attach;
    // Pull combination type down into the value
    // This is a bit of a hack which is needed because states.js
    // _only_ passes the values to our comparison function, but
    // we need additional info. So we just hack that additional
    // info into the value :)
    Drupal.behaviors.states.attach = function(context, settings) {
      for (var k in Drupal.settings.states) {
    	  var triggered_field = Drupal.settings.states[k];
        for (var t in triggered_field) {
          var state_type = triggered_field[t];
          for (var c in state_type) {
            var control_field = state_type[c];
            if (control_field.value) {
              control_field.value.condition_type = control_field.condition_type;
            }
            delete control_field.condition_type;
          }
        }
      }
      old_hook(context, settings); // Invoke the original handler after we're done
    };
  }

  // hack for date fields
  function date_field_handler(trigger) {
    var state = $('.date-conditional-state').attr('state');

    if ((trigger && state == 'enabled') || (!trigger && state == 'disabled')) {
      $('.date-conditional-state :input').removeAttr('disabled');
    }
    else if (trigger && state == 'disabled' || (!trigger && state == 'enabled')) {
      $('.date-conditional-state :input').attr('disabled', true);
    }

  }

  function compare (a, b) {
    return (a === b) ? (a === undefined ? a : true) : (a === undefined || b === undefined);
  }

})(jQuery);
