<?php
/**
 * Logic Plugin for Turbine
 * Keal Jones
 *
 * http://github.com/kealjones
 *
 */
/**
 * Adds conditional logic to change output based on if statement.
 * 
 * 
 * @param mixed &$parsed
 * @return void
 */
function ifLogic(&$parsed){
	global $cssp, $browser;
	foreach($parsed as $block => $css){
		foreach($parsed[$block] as $selector => $styles){
			foreach($styles as $property => $values){
				if(strpos($values,'if(') !== false){
					/*
					MODIFY TO WORK, and format better.
					*/
					
$var = get_string_between($var,"if(",")");

$ifParams = explode(",",$var);

$ifCond = explode(" ",$ifParams[0]);
$ifCond[0] = parse($ifCond[0]);
//echo $ifCond[0];
$test = compare($ifCond[0],$ifCond[1],$ifCond[2]);

if($test){
	echo $ifParams[1]; }
else {
	echo $ifParams[2]; }
	
	
function parse($phpString){
		/*
		I KNOW I SHOULDN'T USE EVAL, LOOKING INTO ALTERNATE OPTIONS...
		Maybe something like how I handle compare, would limit full potential though.
		/*
    return eval("return( ".$phpString.");");
}
function compare($value1, $op, $value2) {
    $known_ops = array(
        '==' => function($a, $b) { return $a == $b; },
        '!=' => function($a, $b) { return $a != $b; },
        'eq' => function($a, $b) { return "$a" === "$b"; }
    );
    $func = $known_ops[$op];
    return $func($value1, $value2);
}
    
function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strrpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}
				}
			}
		}
	}
}
/**
 * Register the plugin
 */
$cssp->register_plugin('ifLogic', 'ifLogic', 'before_glue', 0);
?>