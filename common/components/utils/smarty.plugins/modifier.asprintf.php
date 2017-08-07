<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.asprintf.php
 * Type:     modifier
 * Name:     asprintf
 * Purpose:  print a string with format
 * -------------------------------------------------------------
 */
function smarty_modifier_asprintf($data, $delimeter = ",", $format = null)
{
	if (!is_array($data)) {
		$data = (array)$data;
	}
	
	$temp = [];
	foreach ($data as $term) {
		if (!$format) {
			$temp[] = $term;
		} else {
			$temp[] = sprintf($format, $term);	
		}
	}
	
	$temp = array_filter($temp);
	$str = trim(implode($delimeter, $temp));
	return $str;
}
?>