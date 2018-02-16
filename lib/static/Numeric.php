<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/22/2016
 * Time: 8:54 AM
 */
namespace fm\lib\help;

class Numeric
{
    public static function isNumeric($mixValue)
    {
        return is_numeric($mixValue);
    }

    public static function intval($mixValue, $intBase = 10)
    {
        return intval($mixValue, $intBase);
    }

    public static function isInt($mixValue)
    {
        return is_int($mixValue);
    }

    public static function isFloat($mixValue)
    {
        return is_float($mixValue);
    }

    public static function floatVal($mixValue)
    {
        $mixReturn = null;
        if(self::isNumeric($mixValue) || self::isFloat($mixValue))
            $mixReturn = floatval($mixValue);

        return $mixReturn;
    }

    public static function convertToInteger($mixValue)
    {
        $mixReturn = null;

        if(self::isNumeric($mixValue) || $mixValue == 0)
            $mixReturn = (integer)$mixValue;

        return $mixReturn;
    }

    public static function numberFormat($floatNumber, $intDecimals = 0, $strDecimalPoint = ",", $strThousandsPoint = ".")
    {
        return number_format($floatNumber, $intDecimals, $strDecimalPoint, $strThousandsPoint);
    }

    public static function ceil($floatValue)
    {
        return ceil($floatValue);
    }
}