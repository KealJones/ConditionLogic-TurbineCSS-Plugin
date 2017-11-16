<?php
/**
 * Main class for TurbineCSS ternary plugin
 * https://github.com/KealJones/ternary-turbinecss-plugin
 *
 * Copyright Keal Jones
 * Licensed under GNU LGPL 3, see LICENSE or http://www.gnu.org/licenses/
 */


/**
 * Ternary
 * Adds ternary logic for setting values based on a condition
 *
 * Usage:   #foo { color: true == true ? 'green' : 'red'; }
 * Result:  #foo { color: 'green'; }
 * Advanced Useage: #foo { color: date("Y")==2018?"#87AE4F":"#".date("Y")."BB"; }
 * Result for True:  #foo { color: #87AE4F; }
 * Result for False: #foo { color: #2017BB; } // the 2017 part of hex would be the year
 * Status:  Stable
 * Version: 1.0
 *
 * @param mixed &$parsed
 * @return void
 */

function ternary(&$parsed)
{
    global $browser, $cssp;
    $pattern = '/(?:\s|)(.*?)(?:\s|)\?(?:\s|)(.*?)(?:\s|)\:(?:\s|)(.*?)(?:\s|)$/';
    foreach ($parsed as $block => $css) {
        foreach ($parsed[$block] as $selector => $styles) {
            foreach ($styles as $property => $values) {
                preg_match($pattern, $values[0], $matches, PREG_OFFSET_CAPTURE, 0);
                if ($matches) {
                    $condition      = interp($matches[1][0]);
                    $parsed[$block][$selector][$property] = []; // Remove existing Ternary Statement
                    if ($condition) {
                        $parsed[$block][$selector][$property][] = interp($matches[2][0]); // Place True Value
                    } else {
                        $parsed[$block][$selector][$property][] = interp($matches[3][0]); // Place False Value
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
     * Potential Security Hole... Find alternate method for eval.
     */
    return eval("return $phpString;");
}

/**
 * Register the plugin
 */
$cssp->register_plugin('ternary', 'ternary', 'before_glue', 0);
