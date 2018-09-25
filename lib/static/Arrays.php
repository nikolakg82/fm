<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/30/2016
 * Time: 3:08 PM
 */

namespace fm\lib\help;

class Arrays
{
    /**
     * Call php reset function
     *
     * @param array $arrData
     * @return mixed
     */
    public static function reset($arrData)
    {
        return reset($arrData);
    }

    /**
     * Call php is_array function
     *
     * @param mixed $mixData
     * @return bool
     */
    public static function isArray($mixData)
    {
        return is_array($mixData);
    }

    /**
     * Call php serialize function
     *
     * @param array $arrData
     * @return string
     */
    public static function serialize($arrData)
    {
        return serialize($arrData);
    }

    /**
     * Call php unserialize function
     *
     * @param string $strData
     * @return mixed
     */
    public static function unSerialize($strData)
    {
        return unserialize($strData);
    }

    /**
     * Count array length
     *
     * @param mixed $arrData
     * @return int
     */
    public static function count($arrData)
    {
        $intCount = 0;

        if(self::isArray($arrData))
            $intCount =  count($arrData);

        return $intCount;
    }
}