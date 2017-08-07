<?php
namespace app\components\utils;

class KSolrUtils
{
	/**
	 * http://lucene.apache.org/core/3_6_0/queryparsersyntax.html#Escaping%20Special%20Characters
	 * @param unknown $str
	 * @return string
	 */
	public static function escapeQueryChars($str){
		//list taken from http://lucene.apache.org/java/docs/queryparsersyntax.html#Escaping%20Special%20Characters
		$pattern = '/(\+|-|&&|\|\||!|\(|\)|\{|}|\[|]|\^|"|~|\*|\?|:|\\\)/';
		$replace = '\\\$1';

		return preg_replace($pattern, $replace, $str);
	}
}
?>