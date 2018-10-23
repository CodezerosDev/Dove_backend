<?php
$view = '';
$xinha_names = '';
$field_prefix = '';
if ($db_required == 'new' && $table_as_field_prefix === true) {
    $field_prefix = "{$module_name_lower}_";
}
$valid_rules = array(
    "required"              => "required: true",
    "trim"                  => "required: {
                                    depends:function(){
                                        $(this).val($.trim($(this).val()));
                                        return true;
                                    }
                                }",
    "alpha"                 => "accept: /^([a-z])+$/i",
    "is_numeric"            => "accept: /^[\-+]?[0-9]*\.?[0-9]+$/",
    "alpha_numeric"         => "accept: /^([a-z0-9])+$/i",
    "valid_email"           => "email: true",
    "integer"               => "accept: /^[\-+]?[0-9]+$/",
    "is_decimal"            => "accept: /^[\-+]?[0-9]+(\.[0-9]+)?$/",
    "is_natural"            => "accept: /^[0-9]+$/",
    "is_natural_no_zero"    => "accept: /^[0-9]+$/",
//    "valid_ip"              => "accept: /^(?:(?:25[0-5]2[0-4][0-9][01]?[0-9][0-9]?)\.){3}(?:25[0-5]2[0-4][0-9][01]?[0-9][0-9]?)$/",
    "valid_ip"              => "validIP: true",
//    "valid_base64"          => "accept: /[^a-zA-Z0-9\/\+=]/",
    "valid_base64"          => "accept: /^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{4})$/",
    "alpha_extra"           => "accept: /^([-a-z0-9_-])+$/i"
);
$valid_rules_messages = array(
    "alpha"                 => "accept: 'Please enter only alpha characters'",
    "is_numeric"            => "accept: 'Please enter only numeric values'",
    "alpha_numeric"         => "accept: 'Please enter only alpha-numeric characters'",
    "integer"               => "accept: 'Please enter only integer characters'",
    "is_decimal"            => "accept: 'Please enter only decimal characters'",
    "is_natural"            => "accept: 'Please enter only natural numbers'",
    "is_natural_no_zero"    => "accept: 'Please enter only natural numbers'",
//    "valid_ip"              => "accept: 'Please enter valid IP Address'",
    "valid_ip"              => "validIP: 'Please enter valid IP Address'",
    "valid_base64"          => "accept: 'Please enter valid base64 string'",
    "alpha_extra"           => "accept: 'Please enter Alpha-numeric, underscore, dash, periods and spaces characters'",
);
$form_rules = array();
$form_rules_messages = array();
for ($counter = 1; $field_total >= $counter; $counter++) {
	// only build on fields that have data entered.
	if (set_value("view_field_label$counter") == null) {
		continue; // move onto next iteration of the loop
	}

	$maxlength = null;
	$field_label = set_value("view_field_label$counter");
	$field_name = $field_prefix . set_value("view_field_name$counter");
	$field_type = set_value("view_field_type$counter");
    $validation_rules = $this->input->post("validation_rules$counter")!=""?$this->input->post("validation_rules$counter"):array();

	// field type
	switch($field_type) {
        case 'textarea':
            if ( ! empty($textarea_editor)) {
                if ($textarea_editor == 'ckeditor') {
                    $view .= "
					if ( ! ('{$field_name}' in CKEDITOR.instances)) {
						CKEDITOR.replace('{$field_name}');
					}";
                } elseif ($textarea_editor == 'xinha') {
                    if ($xinha_names != '') {
                        $xinha_names .= ', ';
                    }
                    $xinha_names .= "'{$field_name}'";
                } elseif ($textarea_editor == 'markitup') {
                    $view .= "
                    $('#{$field_name}').markItUp(mySettings);";
                }
            }
            break;

        case 'input':
            if(count($validation_rules)>0) {
                $applied_rules = array();
                $applied_rules_message = array();
                for($vr=0; $vr<count($validation_rules); $vr++) {
                    if(array_key_exists($validation_rules[$vr], $valid_rules)) {
                        $applied_rules[] = $valid_rules[$validation_rules[$vr]];
                    }

                    if(array_key_exists($validation_rules[$vr], $valid_rules_messages)) {
                        $applied_rules_message[] = $valid_rules_messages[$validation_rules[$vr]];
                    }
                }
                $form_rules[] = "$field_name: {
                                    ".implode(',',$applied_rules)."
                                }";

                $form_rules_messages[] = "$field_name: {
                                            ".implode(',',$applied_rules_message)."
                                        }";
                /*if(in_array("required",$validation_rules) && in_array('trim',$validation_rules)) {
                    $form_rules[] = "$field_label: {
                                        required: {
                                            depends:function(){
                                                $(this).val($.trim($(this).val()));
                                                return true;
                                            }
                                        }
                                    }";
                } else if(in_array("required",$validation_rules)) {
                    $form_rules[] = "$field_label: {
                                        required: true
                                    }";
                }*/

            }
            // no break;
        case 'password':
            // no break;
        default: // input.. added bit of error detection setting select as default
            $db_field_type = set_value("db_field_type$counter");
            if ($db_field_type != null) {
                if ($db_field_type == 'DATE') {
                    $view .= "
                    $('#{$field_name}').datepicker({dateFormat: 'yy-mm-dd'});";
                } elseif ($db_field_type == 'DATETIME') {
    				$view .= "
                    $('#{$field_name}').datetimepicker({dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss'});";
                }
            }
            break;
    }
}

if(count($form_rules)>0) {
    if(in_array('valid_ip',$validation_rules)) {
        $view .= "
        jQuery.validator.addMethod('validIP', function(value) {
            var split = value.split('.');
            if (split.length != 4)
                return false;

            for (var i=0; i<split.length; i++) {
                var s = split[i];
                if (s.length==0 || isNaN(s) || s<0 || s>255)
                    return false;
            }
            return true;
        }, ' Invalid IP Address');";
    }
    $view .= "
    $(document).ready(function() {
        /*
        jQuery.validator.addMethod('accept', function(value, element, param) {
          return value.match(new RegExp('.' + param + '$'));
        });
        */
        jQuery.validator.addMethod('accept', function(value, element, param) {
            return this.optional(element) || param.test(value);
        });
        $('form').validate({
            rules: {
                ".implode(',', $form_rules)."
            },
            messages: {
                ".implode(',', $form_rules_messages)."
            }
        });
    });";
}

if ($xinha_names != '') {
	$view .= "
    var xinha_plugins = ['Linker'],
        xinha_editors = [{$xinha_names}];

    function xinha_init() {
        if ( ! Xinha.loadPlugins(xinha_plugins, xinha_init)) {
            return;
        }

        var xinha_config = new Xinha.Config();
        xinha_editors = Xinha.makeEditors(xinha_editors, xinha_config, xinha_plugins);
        Xinha.startEditors(xinha_editors);
    }

    xinha_init();";
}

echo $view;