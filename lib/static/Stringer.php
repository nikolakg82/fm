<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/6/2016
 * Time: 2:49 PM
 */

namespace fm\lib\help;

class Stringer
{
    /**
     * Cat text to passed length and add character to end.
     *
     * @param $strString - Text to cat
     * @param $intLength - Length of text
     * @param string $strEnd - Character to added on the end of text
     * @return string
     */
    public static function truncate($strString, $intLength, $strEnd = "...")
    {
        return self::subStr($strString, 0, $intLength) . $strEnd;
    }

    /**
     * Return part of the string
     *
     * @param $strString
     * @param $intStart
     * @param int $intLength
     * @return bool|string
     */
    public static function subStr($strString, $intStart, $intLength = PHP_INT_MAX)
    {
        return substr($strString, $intStart, $intLength);
    }

    /**
     * Count all or part of the string, too can to search and count found character
     *
     * @param $strString
     * @param null $strStringSearch
     * @param int $intStartCount
     * @param null $mixLengthCount
     * @return int
     */
    public static function substCount($strString, $strStringSearch = null, $intStartCount = 0, $mixLengthCount = null)
    {
        return substr_count($strString, $strStringSearch, $intStartCount, $mixLengthCount);
    }

    /**
     * Split string to the array by delimiter
     *
     * @param $strString
     * @param $strDelimiter
     * @param int $mixLimit
     * @return array
     */
    public static function explode($strString, $strDelimiter, $mixLimit = PHP_INT_MAX)
    {
        return explode($strDelimiter, $strString, $mixLimit);
    }

    /**
     * Return length of the string
     *
     * @param $strString
     * @return int
     */
    public static function strCount($strString)
    {
        return strlen($strString);
    }

    /**
     * Remove html tahs from string
     *
     * @param $strString
     * @param $strAllowableTags - Tags that will not be removed ('<p><a>')
     * @return string
     */
    public static function stripTags($strString, $strAllowableTags)
    {
        return strip_tags($strString, $strAllowableTags);
    }

    /**
     * Remove white space from end and start of the string
     *
     * @param $strString
     * @param string $strCharacterMask
     * @return string
     */
    public static function trim($strString, $strCharacterMask = "\t\n\r\0\x0B")
    {
        return trim($strString, $strCharacterMask);
    }

    /**
     * Convert string to md5
     *
     * @param $strString
     * @param bool $boolRawOutput
     * @return string
     */
    public static function md5($strString, $boolRawOutput = false)
    {
        return md5($strString, $boolRawOutput);
    }

    /**
     * Replace part of string
     *
     * @param $strString
     * @param $strSearch
     * @param $strReplace
     * @param null $mixCount
     * @return mixed
     */
    public static function strReplace($strString, $strSearch, $strReplace, $mixCount = null)
    {
        return str_replace($strSearch, $strReplace, $strString, $mixCount);
    }

    /**
     * Check is value string
     *
     * @param $mixValue
     * @return bool
     */
    public static function isString($mixValue)
    {
        return is_string($mixValue);
    }

    /**
     * Convert value to string
     *
     * @param $mixValue
     * @return string
     */
    public static function strVal($mixValue)
    {
        return strval($mixValue);
    }

    /**
     * Check value string and convert to string if not return null
     *
     * @param $mixValue
     * @return null|string
     */
    public static function convertToString($mixValue)
    {
        $mixReturn = null;

        if(self::isString($mixValue))
            $mixReturn = (string)$mixValue;

        return $mixReturn;
    }

    /**
     * Get string position of text
     *
     * @param $strString
     * @param $strFind
     * @param int $intOffset
     * @return bool|int
     */
    public static function strPos($strString, $strFind, $intOffset = 0)
    {
        return strpos($strString, $strFind, $intOffset);
    }

    /**
     * Check if string exist in text
     *
     * @param $strWord
     * @param $strCharacter
     * @return bool
     */
    public static function findCharacter($strWord, $strCharacter)
    {
        $boolReturn = false;

        $mixPos = self::strPos($strWord, $strCharacter);

        if($mixPos !== false)
            $boolReturn = true;

        return $boolReturn;
    }

    /**
     * Upper all letter on string
     *
     * @param $strWord
     * @return string
     */
    public static function uppercase($strWord)
    {
        return strtoupper($strWord);
    }
}