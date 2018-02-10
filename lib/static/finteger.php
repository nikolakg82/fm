<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/22/2016
 * Time: 8:54 AM
 */
class Finteger
{
    public static function is_numeric($mixValue)
    {
        return is_numeric($mixValue);
    }

    public static function intval($mixValue, $intBase = 10)
    {
        return intval($mixValue, $intBase);
    }

    public static function is_int($mixValue)
    {
        return is_int($mixValue);
    }

    public static function is_float($mixValue)
    {
        return is_float($mixValue);
    }

    public static function floatval($mixValue)
    {
        $mixReturn = null;
        if(self::is_numeric($mixValue) || self::is_float($mixValue))
            $mixReturn = floatval($mixValue);

        return $mixReturn;
    }

    public static function convert_to_integer($mixValue)
    {
        $mixReturn = null;

        if(self::is_numeric($mixValue) || $mixValue == 0)
            $mixReturn = (integer)$mixValue;

        return $mixReturn;
    }

    public static function number_format($floatNumber, $intDecimals = 0, $strDecimalPoint = ",", $strThousandsPoint = ".")
    {
        return number_format($floatNumber, $intDecimals, $strDecimalPoint, $strThousandsPoint);
    }

    public static function ceil($floatValue)
    {
        return ceil($floatValue);
    }
}