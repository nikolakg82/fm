<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/22/2016
 * Time: 8:54 AM
 */

namespace fm\lib\help;

class Numeric
{
    /**
     * Check is value number
     *
     * @param $mixValue
     * @return bool
     */
    public static function isNumeric($mixValue)
    {
        return is_numeric($mixValue);
    }

    /**
     * Convert value to integer
     *
     * @param $mixValue
     * @param int $intBase
     * @return int
     */
    public static function intVal($mixValue, $intBase = 10)
    {
        return intval($mixValue, $intBase);
    }

    /**
     * Check is value integer
     *
     * @param $mixValue
     * @return bool
     */
    public static function isInt($mixValue)
    {
        return is_int($mixValue);
    }

    public static function isFloat($mixValue)
    {
        return is_float($mixValue);
    }

    /**
     * Check is value float
     *
     * @param $mixValue
     * @return float|null
     */
    public static function floatVal($mixValue)
    {
        $mixReturn = null;
        if(self::isNumeric($mixValue) || self::isFloat($mixValue))
            $mixReturn = floatval($mixValue);

        return $mixReturn;
    }

    /**
     * Convert value to integer, if value not number return null
     *
     * @param $mixValue
     * @return int|null
     */
    public static function convertToInteger($mixValue)
    {
        $mixReturn = null;

        if(self::isNumeric($mixValue) || $mixValue == 0)
            $mixReturn = (integer)$mixValue;

        return $mixReturn;
    }

    /**
     * Format number
     *
     * @param $floatNumber - Number
     * @param int $intDecimals - Round on decimals
     * @param string $strDecimalPoint - Separate decimal
     * @param string $strThousandsPoint - Separate thousands
     * @return string
     */
    public static function numberFormat($floatNumber, $intDecimals = 0, $strDecimalPoint = ",", $strThousandsPoint = ".")
    {
        return number_format($floatNumber, $intDecimals, $strDecimalPoint, $strThousandsPoint);
    }

    /**
     * Round fractions up
     *
     * @param $floatValue
     * @return float
     */
    public static function ceil($floatValue)
    {
        return ceil($floatValue);
    }
}