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
function if(&$parsed)
{
    global $cssp, $browser;
    foreach ($parsed as $block => $css) {
        foreach ($parsed[$block] as $selector => $styles) {
            foreach ($styles as $property => $values) {
                if (strpos($values, 'if(') !== false) {
                    /**
                     * Clean up variable names and Formatting.
                     */
                    
                    $var = get_string_between($var, "if(", ")");
                    
                    $ifParams = explode(",", $var);
                    
                    $ifCond    = explode(" ", $ifParams[0]);
                    $ifCond[0] = parse($ifCond[0]);
                    //echo $ifCond[0];
                    $test      = compare($ifCond[0], $ifCond[1], $ifCond[2]);
                    
                    if ($test) {
                        echo $ifParams[1];
                    } else {
                        echo $ifParams[2];
                    }
                }
            }
        }
    }
}

/**
 * Utility Functions
 */
function parse($phpString)
{
    /**
     * Find alternate methody than eval, Maybe something like compare function, would limit full potential though.
     * Has very high chance for hacking by modifying cache of cssp file.
     */
    return eval("return( " . $phpString . ");");
}
function compare($value1, $op, $value2)
{
    $known_ops = array(
        '==' => function($a, $b)
        {
            return $a == $b;
        },
        '===' => function($a, $b)
        {
            return "$a" === "$b";
        },
        '!=' => function($a, $b)
        {
            return $a != $b;
        },
        '<>' => function($a, $b)
        {
            return $a <> $b;
        },
        '!==' => function($a, $b)
        {
            return $a !== $b;
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
        },
        '<=>' => function($a, $b)
        {
            return $a <=> $b;
        },
        '??' => function($a, $b)
        {
            return $a ?? $b;
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
$cssp->register_plugin('if', 'if', 'before_glue', 0);
?>