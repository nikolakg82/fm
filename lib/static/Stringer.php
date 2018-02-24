<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/6/2016
 * Time: 2:49 PM
 */

namespace fm\lib\help;

class Stringer
{
    public static function truncate($strString, $intLength, $strEnd = "...")
    {
        return self::subStr($strString, 0, $intLength) . $strEnd;
    }

    public static function subStr($strString, $intStart, $intLength)
    {
        return substr($strString, $intStart, $intLength);
    }

    public static function substCount($strString, $strStringSearch = null, $intStartCount = 0, $mixLengthCount = null)
    {
        return substr_count($strString, $strStringSearch, $intStartCount, $mixLengthCount);
    }

    public static function explode($strString, $strDelimiter, $mixLimit = PHP_INT_MAX)
    {
        return explode($strDelimiter, $strString, $mixLimit);
    }

    public static function strCount($strString)
    {
        return strlen($strString);
    }

    public static function stripTags($strString, $strAllowableTags)
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

    public static function strReplace($strString, $strSearch, $strReplace, $mixCount = null)
    {
        return str_replace($strSearch, $strReplace, $strString, $mixCount);
    }

    public static function isString($mixValue)
    {
        return is_string($mixValue);
    }

    public static function strVal($mixValue)
    {
        return strval($mixValue);
    }

    public static function convertToString($mixValue)
    {
        $mixReturn = null;

        if(self::isString($mixValue))
            $mixReturn = (string)$mixValue;

        return $mixReturn;
    }
}