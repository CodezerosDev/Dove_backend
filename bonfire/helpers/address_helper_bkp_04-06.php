<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers to jumpstart their development of
 * CodeIgniter applications.
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2014, Bonfire Dev Team
 * @license   http://opensource.org/licenses/MIT
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

/**
 * Address helper functions.
 *
 * Provides various helper functions when working with address(es) in forms.
 *
 * @package    Bonfire\Helpers\address_helper
 * @author     Bonfire Dev Team
 * @link       http://cibonfire.com/docs/developer
 */

if (! function_exists('country_select')) {
    /**
     * Create a country-based form dropdown based on the entries in the
     * address.countries config.
     *
     * @param string $selectedIso The value of the item that should be selected
     * when the dropdown is rendered.
     * @param string $defaultIso  The value of the item that should be selected
     * if no other matches are found.
     * @param string $selectName  The name assigned to the select element.
     * Defaults to 'iso'.
     * @param string $classValue       Optional value for class name.
     *
     * @return string The full html for the select input.
     */
    function country_select($selectedIso = '', $defaultIso = 'US', $selectName = 'iso', $classValue = '')
    {
        // Grab the countries from the config
        $countries = config_item('address.countries');
        if (! is_array($countries) || empty($countries)) {
            return lang('us_no_countries');
        }

        // If $selectedIso is empty, set the selection to $defaultIso
        if (empty($selectedIso)) {
            $selectedIso = $defaultIso;
        }

        // Setup the opening select tag
        $output = "<select name='{$selectName}' id='{$selectName}'";
        if (! empty($classValue) && is_string($classValue)) {
            $output .= " class='{$classValue}'";
        }
        $output .= ">\n";

        // Add the option elements
        $output .= "<option value=''>&nbsp;</option>\n";
        foreach ($countries as $countryIso => $country) {
            $output .= "<option value='{$countryIso}'";
            if ($countryIso == $selectedIso) {
                $output .= " selected='selected'";
            }
            $output .= ">{$country['printable']}</option>\n";
        }

        // Close the select element and return.
        return "{$output}</select>\n";
    }
}

if (! function_exists('state_select')) {
    /**
     * Creates a state/provience/county form dropdown based on the entries in
     * the address.states config. The word "state" is used but the structure can
     * be used for Canadian provinces, Irish and UK counties, and any other area
     * based data.
     *
     * @param string $selectedCode The value of the item that should be selected when the dropdown is drawn.
     * @param string $defaultCode The value of the item that should be selected if no other matches are found.
     * @param string $countryCode The code of the country for which the states/priviences/counties are returned. Defaults to 'US'.
     * @param string $selectName The name assigned to the select. Defaults to 'state_code'.
     * @param string $classValue Optional value for class name.
     *
     * @return string The full html for the select input.
     */
    function state_select($selectedCode = '', $defaultCode = '', $countryCode = 'US', $selectName = 'state_code', $classValue = '')
    {
        // Grab the states from the config
        $allStates = config_item('address.states');
        if (! is_array($allStates) || empty($allStates[$countryCode])) {
            return lang('us_no_states');
        }

        // Get the states for the selected country
        $states = $allStates[$countryCode];

        // If $selectedCode is empty, set it to $defaultCode
        if (empty($selectedCode)) {
            $selectedCode = $defaultCode;
        }

        // Setup the opening select tag
        $output = "<select name='{$selectName}' id='{$selectName}'";
        if (is_string($classValue) && ! empty($classValue)) {
            $output .= " class='{$classValue}'";
        }
        $output .= ">\n";

        // Add the option elements
        $output .= "<option value=''>&nbsp;</option>\n";
        foreach ($states as $abbrev => $name) {
            $output .= "<option value='{$abbrev}'";
            if ($abbrev == $selectedCode) {
                $output .= " selected='selected'";
            }
            $output .= ">{$name}</option>\n";
        }

        // Close the select element and return.
        return "{$output}</select>\n";
    }
}

if (! function_exists('state_abbr_to_name')) {
    /**
     * Convert a state/region/subdivision abbreviation to the full name.
     *
     * ISO 3166-2 codes are 1-3 characters and alphanumeric. While most countries
     * have a fixed number of characters for their set of codes (with most using
     * 2 characters), some have multiple character lengths for their codes, sometimes
     * indicating larger regions with fewer characters and sub-regions with more
     * characters.
     *
     * @param string $abbr         Abbreviation (ISO 3166-2 code).
     * @param string $country_code Country ISO 3166-1 alpha-2 code.
     *
     * @return string
     */
    function state_abbr_to_name($abbr, $country_code = 'US')
    {
        // First, grab the states from the config
        $all_states = config_item('address.states');
        // Get the states for the selected country
        $states = $all_states[$country_code];

        $abbr = strtoupper($abbr);
        return isset($states[$abbr]) ? $states[$abbr] : false;
    }
}

if (! function_exists('state_name_to_abbr')) {
    /**
     * Convert a full state/region/subdivision name to the abbreviation
     * (ISO 3166-2 code).
     *
     * @param  string $name State's full name.
     * @param  string $country_code Country ISO 3166-1 alpha-2 code.
     *
     * @return string/boolean Returns the state's ISO 3166-2 code/abbreviation,
     * or false when not found.
     */
    function state_name_to_abbr($name, $country_code = 'US')
    {
        // First, grab the states from the config
        $all_states = config_item('address.states');
        // Get the states for the selected country
        $states = $all_states[$country_code];

        // Use lowercase for comparison
        return array_search(strtolower($name), array_map('strtolower', $states));
    }
}

if (! function_exists('city_select')) {

    function city_select($selectedCode = '', $defaultCode = '', $selectName = 'city_code', $classValue = '')
    {
        // If $selectedCode is empty, set it to $defaultCode
        if (empty($selectedCode)) {
            $selectedCode = $defaultCode;
        }

        // Setup the opening select tag
        $output = "<select name='{$selectName}' id='{$selectName}'";
        if (is_string($classValue) && ! empty($classValue)) {
            $output .= " class='{$classValue}'";
        }
        $output .= ">\n";


        // Add the option elements
        $output .= "<option value=''>Select City</option>\n";
        //foreach ($city as $abbrev => $name) {
        //    $output .= "<option value='{$abbrev}'";
        //    if ($abbrev == $selectedCode) {
        //        $output .= " selected='selected'";
        //    }
        //    $output .= ">{$name}</option>\n";
        //}

        // Close the select element and return.
        return "{$output}</select>\n";
    }
}

if (! function_exists('form_create_input')) {

    function form_create_input($args1,$args2,$args3)
    {
        $err_class = form_error($args1['name']) ? 'has-error' : '';
        $output="<div class='control-group $err_class'>";
        $output.="<label class='control-label col-md-3' for='$args1[name]'>$args3</label>";
        $output.="<div class='controls'>";
        $output.="<input type='text' value='$args2' name='$args1[name]' id='$args1[id]' class='form-control input-medium' />";
        $output.="</div></div>";
        return $output;
        //return "<br/><input type='text' value='' />";
    }
}

if (! function_exists('form_create_textarea')) {

    function form_create_textarea($args1,$args2,$args3)
    {
        $err_class = form_error($args1['name']) ? 'has-error' : '';
        $output="<div class='control-group $err_class'>";
        $output.="<label class='control-label col-md-3' for='$args1[name]'>$args3</label>";
        $output.="<div class='controls'>";
        /*$output.="<input type='text' value='$args2' name='$args1[name]' id='$args1[id]' class='form-control input-medium span6' />";*/
        $output.="<textarea name='$args1[name]' class='form-control input-medium' id='$args1[id]'>$args2</textarea>";
        $output.="</div></div>";
        return $output;
        //return "<br/><input type='text' value='' />";
    }
}
if (! function_exists('form_birth_date')) {

    function form_birth_date($args1,$args2,$args3)
    {
        $err_class = form_error($args1['name']) ? 'has-error' : '';
        $output="<div class='control-group $err_class'>";
        $output.="<label class='control-label col-md-3' for='$args1[name]'>$args3</label>";
        $output.="<div class='controls'>";
        $output.="<input type='text' value='$args2' name='$args1[name]' id='$args1[id]' readonly class='form-control input-medium' />";
        $output.="</div></div>";
        return $output;
    }
}
if (! function_exists('form_pro_pic')) {

    function form_pro_pic($args1,$args2,$args3)
    {
        $path = base_url().'assets/uploads/user_images/original/';
        //echo$path.$args2;
        $err_class = form_error($args1['name']) ? 'has-error' : '';
        $err_class1 = isset($message)? $message:'';
        $err_class2 = form_error($args1['name'])? form_error($args1['name']) : '';
        $image = ($args2!='')? "<img src='$path$args2' alt=''/>" : "<img src='http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' alt=''/>";
        $output="<div class='control-group $err_class'>";
        $output.=form_label($args3, $args1['name'], array('class' => "control-label col-md-3"));
        $output.="<div class='controls'>
                    <div class='fileinput fileinput-new' data-provides='fileinput'>
                    <div class='fileinput-new thumbnail' style='width: 200px; height: 150px;'>
                    $image
                    </div>
                    <div class='fileinput-preview fileinput-exists thumbnail' style='max-width: 200px; max-height: 150px;'></div>
                        <div>
                        <span class='btn default btn-file'>
                                 <span class='fileinput-new'>Select image </span>
                                 <span class='fileinput-exists'>Change </span>
                                 <input type='file' name='$args1[name]'>
                                 <input type='hidden' name='$args1[name]_old' value='$args2'>
                                 </span>
                                 <a href='#' class='btn default fileinput-exists' data-dismiss='fileinput'>Remove </a>
                                 </div>
                                 <div class='help-inline'>jpg,png,gif,jpeg file type allowed. Max Size:5MB.</div>
                                    <span class='error'>$err_class1</span>
                                    <span class='help-inline'>$err_class2</span></br>
                                </div>
                                </div>
                                </div>";
        //$output.="<input type='file' value='$args2' name='$args1[name]' id='$args1[id]' class='form-control input-medium' />";
        return $output;
    }
}
if (! function_exists('form_proff_pic'))
{
    //$current_segment = $this->uri->segment(3);

    function form_proff_pic($args1,$args2,$args3)
    {


        $path = base_url().'assets/uploads/kyc/original/';
        $nota = 'PreviewNotAvailable.png';
        $err_class = form_error($args1['name']) ? 'has-error' : '';
        $err_class1 = isset($message)? $message:'';
        $err_class2 = form_error($args1['name'])? form_error($args1['name']) : '';
        $image = ($args2!='')?
            (pathinfo($args2, PATHINFO_EXTENSION) != 'pdf')?
                "<img src='$path$args2' alt=''/>"
                : "<img src='$path$nota' alt=''/>"
            :
            "<img src='http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' alt=''/>";
        $output="<div class='control-group $err_class'>";
        $output.=form_label($args3, $args1['name'], array('class' => "control-label col-md-3"));


            $output.="<div class='controls'>
                        <div class='fileinput fileinput-new' data-provides='fileinput'>
                            <div class='fileinput-new thumbnail' style='width: 200px; /*height: 150px;*/'>
                                $image
                            </div>";

            $output .="<div>
                                <span class='btn default btn-file'>
                                    <span class='fileinput-new'>Select image </span>
                                    <span class='fileinput-exists'>Change </span>
                                    <input type='file' name='$args1[name]'>
                                    <input type='hidden' name='$args1[name]_old' value='$args2'>
                                </span>
                                <a href='#' class='btn default fileinput-exists' data-dismiss='fileinput'>Remove </a>
                            </div>
                            <div class='help-inline'>jpg,png,gif,jpeg,pdf file type allowed. Max Size:5MB.</div>
                            <span class='error'>$err_class1</span>
                            <span class='help-inline'>$err_class2</span></br>";

            $output .="</div>
                        </div></div>";
        //$output.="<input type='file' value='$args2' name='$args1[name]' id='$args1[id]' class='form-control input-medium' />";
        return $output;
    }
}

if (! function_exists('form_proff_id_doc')) {

    function form_proff_id_doc($args1,$args2,$args3)
    {
        $path = base_url().'assets/uploads/kyc/original/';

        $err_class = form_error($args1['name']) ? 'has-error' : '';
        $err_class1 = isset($message)? $message:'';
        $err_class2 = form_error($args1['name'])? form_error($args1['name']) : '';
        $image = ($args2!='')? "<img src='$path$args2' alt=''/>" : "<img src='http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' alt=''/>";
        $output="<div class='control-group $err_class'>";
        $output.=form_label($args3, $args1['name'], array('class' => "control-label col-md-3"));
        $output.="<div class='controls'>
                    <div class='fileinput fileinput-new' data-provides='fileinput'>
                    <div class='fileinput-new thumbnail' style='width: 200px; /*height: 150px;*/'>
                    $image
                    </div>
                    <!--<div class='fileinput-preview fileinput-exists thumbnail' style='max-width: 200px; max-height: 150px;'></div>-->
                        <div>
                        <span class='btn default btn-file'>
                                 <span class='fileinput-new'>Select image </span>
                                 <span class='fileinput-exists'>Change </span>
                                 <input type='file' name='$args1[name]'>
                                 <input type='hidden' name='$args1[name]_old' value='$args2'>
                                 </span>
                                 <a href='#' class='btn default fileinput-exists' data-dismiss='fileinput'>Remove </a>
                                 </div>
                                 <div class='help-inline'>jpg,png,gif,jpeg,pdf file type allowed. Max Size:5MB.</div>
                                    <span class='error'>$err_class1</span>
                                    <span class='help-inline'>$err_class2</span></br>
                                </div>
                                </div>
                                </div>";
        //$output.="<input type='file' value='$args2' name='$args1[name]' id='$args1[id]' class='form-control input-medium' />";
        return $output;
    }
}

/* End /helpers/address_helper.php */
