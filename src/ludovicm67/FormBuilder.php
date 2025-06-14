<?php

/**
 * @package     FormBuilder class
 * @author      Ludovic Muller <ludovicmuller1@gmail.com>
 * @license     This software is licensed under the MIT license: http://opensource.org/licenses/MIT
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
    static function cleanString(string $str) {

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
    static function input(string $type = 'text', string $name = '', array $attrs = []) {

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
    static function hidden(string $name = '', string $value = '') {

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
    static function submit(string $value = 'Submit', array $attrs = []) {

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
    static function text(string $name = '', array $attrs = []) {

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
    static function password(string $name = '', array $attrs = []) {

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
    static function email(string $name = '', array $attrs = []) {

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
    static function checkbox(string $name = '', array $attrs = []) {

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
    static function select(string $name = '', array $options = [], array $attrs = []) {

        // Are the options given by an associative array or not?
        $isAssoc = (count(array_filter(array_keys($options), 'is_string')) > 0) ? true : false;

        $select  = '<select';
        $select .= ($name) ? ' name="' . self::cleanString($name) . '"' : '';

        $defaultValue = null;
        if(isset($attrs['value'])) {
            $defaultValue = $attrs['value'];
            unset($attrs['value']);
        }

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
                if(!$defaultValue) $optionArgs .= ' selected="selected"';
            }

            /* If $options is not an associative array, the value will have the title value */
            if(!$isAssoc) $optionValue = $optionTitle;

            /* Autoselect option */
            if(($defaultValue && $defaultValue === "$optionValue") || (!$defaultValue && isset($_POST["$name"]) && $_POST["$name"] === "$optionValue")) $optionArgs .= ' selected="selected"';

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
    static function selectDay(string $name = '', array $attrs = []) {

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
    static function selectMonth(string $name = '', array $attrs = []) {

        $months = [];
        for ($i=1; $i <= 12; $i++) $months[] = sprintf('%02d', $i);

        /* Autoselect current month if empty */
        if(!isset($_POST["$name"])) $months[date('m')-1] .= ' --selected';

        return self::select($name, $months, $attrs);

    }


    /**
     * Static function for generating a select field, to select a month name
     *
     * @param   string      $name     Name of the field (default: empty)
     * @param   array       $attrs    Array of additional attribultes (ex: class, ...)
     * @param   null|array  $months   Array of custom wording
     *
     * @return  string  $select Return the select field
     */
    static function selectMonthName(string $name = '', array $attrs = [], null|array $months = null) {

        if($months == null || !is_array($months) || count($months) != 12) {
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
        }

        /* Autoselect current month if empty */
        if(!isset($_POST["$name"])) $months[sprintf('%02d', date('m'))] .= ' --selected';

        return self::select($name, $months, $attrs);

    }


    /**
     * Static function for generating a select field, to select a month name (FR)
     *
     * @param   string      $name     Name of the field (default: empty)
     * @param   array       $attrs    Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $select Return the select field
     */
    static function selectMonthNameFR(string $name = '', array $attrs = []) {

        $months = [
            '01' => 'janvier',
            '02' => 'février',
            '03' => 'mars',
            '04' => 'avril',
            '05' => 'mai',
            '06' => 'juin',
            '07' => 'juillet',
            '08' => 'août',
            '09' => 'septembre',
            '10' => 'octobre',
            '11' => 'novembre',
            '12' => 'décembre'
        ];

        return self::selectMonthName($name, $attrs, $months);

    }


    /**
     * Static function for generating a select field, to select a year (today-150 -> today)
     *
     * @param   string  $name       Name of the field (default: empty)
     * @param   array   $attrs      Array of additional attribultes (ex: class, ...)
     *
     * @return  string  $select Return the select field
     */
    static function selectYear(string $name = '', array $attrs = []) {

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
    static function textarea(string $name = '', array $attrs = []) {

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
