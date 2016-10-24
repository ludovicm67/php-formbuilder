<?php
/**
 * @package     FormBuilder class
 * @version     1.0.0
 * @author      ludovicm67 <ludovicmuller1@gmail.com>
 * @license     This software is licensed under the MIT license: http://opensource.org/licenses/MIT
 *
 */

namespace ludovicm67;

/**
 * Class FormBuilder
 * This class helps you to build forms quickly.
 * @package FormBuilder
 *
 */
class FormBuilder {

    /**
     * Static function for cleaning string
     *
     * @param   string  $str    String to clean
     *
     * @return  string          String cleaned
     */
    static function cleanString($str) {

        return stripslashes(trim(htmlspecialchars(addslashes($str))));

    }


    /**
     * Static function for generating an input field
     *
     * @param   string  $type   Type of the field (default: "text")
     * @param   string  $name   Name of the field (default: empty)
     * @param   array   $attrs  Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $input  Return the input field
     */
    static function input($type = 'text', $name = '', $attrs = []) {

        $input = '<input type="' . $type . '"';
        $input .= ($name) ? ' name="' . self::cleanString($name) . '"' : '';

        if($type == 'checkbox' && isset($_POST["$name"]) && $_POST["$name"] == 'on') {
            $attrs['checked'] = 'checked';
        }

        // Add all additional attributes defined in $attrs
        foreach ($attrs as $attrName => $attrValue) {
            $input .= ' ' . $attrName . '="' . self::cleanString($attrValue) . '"';
        }

        // Autofill the fields if they aren't password or empty
        if(isset($_POST["$name"]) && $type != "password" && !isset($attrs['value'])) {
            $input .= ' value="' . self::cleanString($_POST["$name"]) . '"';
        }

        $input .= ">\n";
        return $input;

    }


    /**
     * Static function for generating an hidden input field
     *
     * @param   string  $name   Name of the field (default: empty)
     * @param   string  $value  Value of the field (default: empty)
     *
     * @return  string  $input  Return the input[type=hidden] field
     */
    static function hidden($name = '', $value = '') {

        $attrs = [];
        $attrs['value'] = $value;
        return self::input($type = 'hidden', $name, $attrs);

    }


    /**
     * Static function for generating a submit input
     *
     * @param   string  $value  Value of the field (default: empty)
     * @param   array   $attrs  Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $input  Return the input[type=submit] field
     */
    static function submit($value = 'Submit', $attrs = []) {

        $attrs['value'] = $value;
        return self::input($type = 'submit', '', $attrs);

    }


    /**
     * Static function for generating a text input field
     *
     * @param   string  $name   Name of the field (default: empty)
     * @param   array   $attrs  Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $input  Return the text input field
     */
    static function text($name = '', $attrs = []) {

        return self::input('text', $name, $attrs);

    }


    /**
     * Static function for generating a password input field
     *
     * @param   string  $name   Name of the field (default: empty)
     * @param   array   $attrs  Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $input  Return the password input field
     */
    static function password($name = '', $attrs = []) {

        return self::input('password', $name, $attrs);

    }


    /**
     * Static function for generating a email input field
     *
     * @param   string  $name   Name of the field (default: empty)
     * @param   array   $attrs  Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $input  Return the email input field
     */
    static function email($name = '', $attrs = []) {

        return self::input('email', $name, $attrs);

    }


    /**
     * Static function for generating a checkbox field
     *
     * @param   string  $name   Name of the field (default: empty)
     * @param   array   $attrs  Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $input  Return the checkbox field
     */
    static function checkbox($name = '', $attrs = []) {

        return self::input('checkbox', $name, $attrs);

    }


    /**
     * Static function for generating a select field
     *
     * @param   string  $name       Name of the field (default: empty)
     * @param   array   $options    Array for options
     * @param   array   $attrs      Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $select Return the select field
     */
    static function select($name = '', $options = [], $attrs = []) {

        // Are the options given by an associative array or not?
        $isAssoc = (count(array_filter(array_keys($options), 'is_string')) > 0) ? true : false;

        $select  = '<select';
        $select .= ($name) ? ' name="' . self::cleanString($name) . '"' : '';

        // Add all additional attributes defined in $attrs
        foreach ($attrs as $attrName => $attrValue) {
            $select .= ' ' . $attrName . '="' . self::cleanString($attrValue) . '"';
        }

        $select .= ">\n";

        foreach ($options as $optionValue => $optionTitle) {

            /* Check if option is disabled = if $optionTitle ends with --disabled */
            $optionDisabled = ' --disabled';
            $optionDisabledStrLen = strlen($optionDisabled);
            $optionArgs = '';
            if(substr_compare($optionTitle, $optionDisabled, -$optionDisabledStrLen, $optionDisabledStrLen) == 0) {
                $optionTitle = substr($optionTitle, 0, -$optionDisabledStrLen);
                $optionArgs .= ' disabled="disabled"';
            }

            /* Check if option is selected = if $optionTitle ends with --selected */
            $optionSelected = ' --selected';
            $optionSelectedStrLen = strlen($optionSelected);
            if(substr_compare($optionTitle, $optionSelected, -$optionSelectedStrLen, $optionSelectedStrLen) == 0) {
                $optionTitle = substr($optionTitle, 0, -$optionSelectedStrLen);
                $optionArgs .= ' selected="selected"';
            }

            /* If $options is not an associative array, the value will have the title value */
            if(!$isAssoc) $optionValue = $optionTitle;

            /* Autoselect option */
            if(isset($_POST["$name"]) && $_POST["$name"] === "$optionValue") $optionArgs .= ' selected="selected"';

            $select .= '<option value="' . self::cleanString($optionValue) . '"' . $optionArgs . '>' . $optionTitle . "</option>\n";

        }

        $select .= "</select>\n";
        return $select;

    }


    /**
     * Static function for generating a select field, to select a day (1-31)
     *
     * @param   string  $name       Name of the field (default: empty)
     * @param   array   $attrs      Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $select Return the select field
     */
    static function selectDay($name = '', $attrs = []) {

        $days = [];
        for ($i=1; $i <= 31; $i++) $days[] = sprintf('%02d', $i);

        /* Autoselect current day if empty */
        if(!isset($_POST["$name"])) $days[date('d')-1] .= ' --selected';

        return self::select($name, $days, $attrs);

    }


    /**
     * Static function for generating a select field, to select a month (1-12)
     *
     * @param   string  $name       Name of the field (default: empty)
     * @param   array   $attrs      Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $select Return the select field
     */
    static function selectMonth($name = '', $attrs = []) {

        $months = [];
        for ($i=1; $i <= 12; $i++) $months[] = sprintf('%02d', $i);

        /* Autoselect current month if empty */
        if(!isset($_POST["$name"])) $months[date('m')-1] .= ' --selected';

        return self::select($name, $months, $attrs);

    }


    /**
     * Static function for generating a select field, to select a month name
     *
     * @param   string  $name       Name of the field (default: empty)
     * @param   array   $attrs      Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $select Return the select field
     */
    static function selectMonthName($name = '', $attrs = []) {

        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        /* Autoselect current month if empty */
        if(!isset($_POST["$name"])) $months[sprintf('%02d', date('m'))] .= ' --selected';

        return self::select($name, $months, $attrs);

    }


    /**
     * Static function for generating a select field, to select a year (today-150 -> today)
     *
     * @param   string  $name       Name of the field (default: empty)
     * @param   array   $attrs      Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $select Return the select field
     */
    static function selectYear($name = '', $attrs = []) {

        $years = [];
        for ($i=date('Y')-150; $i <= date('Y'); $i++) $years[] = sprintf('%04d', $i);

        /* Autoselect current month if empty */
        if(!isset($_POST["$name"])) $years[150] .= ' --selected';

        return self::select($name, $years, $attrs);

    }


    /**
     * Static function for generating a textarea field
     *
     * @param   string  $name       Name of the field (default: empty)
     * @param   array   $attrs      Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $textarea   Return the textarea field
     */
    static function textarea($name = '', $attrs = []) {

        $textarea = '<textarea';
        $textarea .= ($name) ? ' name="' . self::cleanString($name) . '"' : '';

        // Add all additional attributes defined in $attrs
        foreach ($attrs as $attrName => $attrValue)
            $textarea .= ' ' . $attrName . '="' . self::cleanString($attrValue) . '"';

        $textarea .= '>';

        // Autofill if not empty
        if(isset($_POST["$name"])) $textarea .= self::cleanString($_POST["$name"]);

        $textarea .= "</textarea>\n";
        return $textarea;

    }

}
