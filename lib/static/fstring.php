<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/6/2016
 * Time: 2:49 PM
 */

/**
 * Class Fstring
 */
class Fstring
{
    public static function truncate($strString, $intLength, $strEnd = "...")
    {
        return self::substr($strString, 0, $intLength) . $strEnd;
    }

    public static function substr($strString, $intStart, $intLength)
    {
        return substr($strString, $intStart, $intLength);
    }

    public static function subst_count($strString, $strStringSearch = null, $intStartCount = 0, $mixLengthCount = null)
    {
        return substr_count($strString, $strStringSearch, $intStartCount, $mixLengthCount);
    }

    public static function explode($strString, $strDelimiter, $mixLimit = PHP_INT_MAX)
    {
        return explode($strDelimiter, $strString, $mixLimit);
    }

    public static function strlen($strString)
    {
        return strlen($strString);
    }

    public static function strip_tags($strString, $strAllowableTags)
    {
        return strip_tags($strString, $strAllowableTags);
    }

    public static function trim($strString, $strCharacterMask = "\t\n\r\0\x0B")
    {
        return trim($strString, $strCharacterMask);
    }

    public static function md5($strString, $boolRawOutput = false)
    {
        return md5($strString, $boolRawOutput);
    }

    public static function str_replace($strString, $strSearch, $strReplace, $mixCount = null)
    {
        return str_replace($strSearch, $strReplace, $strString, $mixCount);
    }

    public static function is_string($mixValue)
    {
        return is_string($mixValue);
    }

    public static function strval($mixValue)
    {
        return strval($mixValue);
    }

    public static function convert_to_string($mixValue)
    {
        $mixReturn = null;

        if(self::is_string($mixValue))
            $mixReturn = (string)$mixValue;

        return $mixReturn;
    }
}