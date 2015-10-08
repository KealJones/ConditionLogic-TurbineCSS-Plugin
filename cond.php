<?php
/**
 * if Statement Plugin for Turbine
 * Keal Jones
 *
 * http://github.com/kealjones
 *
 */
/**
 * Adds if statement logic to change output based on if statement.
 * 
 * 
 * @param mixed &$parsed
 * @return void
 */
function cond(&$parsed)
{
    global $cssp, $browser;
    foreach ($parsed as $block => $css) {
        foreach ($parsed[$block] as $selector => $styles) {
            foreach ($styles as $property => $values) {
                if (strpos($values[0], 'cond(') !== false) {
                    /**
                     * Clean up variable names and Formatting.
                     */
                    $condition = get_string_between($values[0], "cond(", ")");
                    $ifParams  = explode("?", $condition);
                    $ifResults = explode(":", $ifParams[1]); 
                    $ifCond    = explode(" ", $ifParams[0]);
                    $ifCond[0] = interp($ifCond[0]); //Convert PHP string to Values
                    $ifCond[2] = interp($ifCond[2]); //Convert PHP string to Values
                    $test      = compare($ifCond[0], $ifCond[1], $ifCond[2]);
                    $parsed[$block][$selector][$property]   = ''; //Remove existing Cond Statement
                    if ($test) {
                        $parsed[$block][$selector][$property][] = $ifResults[0]; //Place True Value
                    } else {
                        $parsed[$block][$selector][$property][] = $ifResults[1]; //Place False Value
                    }
                }
            }
        }
    }
}

/**
 * Utility Functions
 */
function interp($phpString)
{
    /**
     * Find alternate method than eval, Maybe something like compare function, would limit full potential though.
     * Has very high chance for hacking by modifying cache of cssp file.
     */
    return eval("return( " . $phpString . ");");
}
function compare($value1, $op, $value2)
{
    $known_ops = array(
        "==" => function($a, $b)
        {
            return $a == $b;
        },
        "===" => function($a, $b)
        {
            return "$a" === "$b";
        },
        "!=" => function($a, $b)
        {
            return $a != $b;
        },
        '<>' => function($a, $b){
        return ($a <> $b);
        },
        '!==' => function($a, $b){
        return ($a !== $b);
        },
        '<' => function($a, $b)
        {
        return $a < $b;
        },
        '>' => function($a, $b)
        {
        return $a > $b;
        },
        '<=' => function($a, $b)
        {
        return $a <= $b;
        },
        '>=' => function($a, $b)
        {
        return $a >= $b;
        }
    );
    $func      = $known_ops[$op];
    return $func($value1, $value2);
}

function get_string_between($string, $start, $end)
{
    $string = " " . $string;
    $ini    = strpos($string, $start);
    if ($ini == 0)
        return "";
    $ini += strlen($start);
    $len = strrpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

/**
 * Register the plugin
 */
$cssp->register_plugin('cond', 'cond', 'before_glue', 0);

?>
