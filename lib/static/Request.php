<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/30/2016
 * Time: 6:39 PM
 */

namespace fm\lib\help;

use fm\FM;

class Request
{
    /**
     * Get value from request
     *
     * @param $strName - Request field name
     * @param string $strType - Type of value
     * @param array $mixMethod - Array of methods or headers
     * @return float|int|null|string
     */
    public static function name($strName, $strType = FM_STRING, $mixMethod = array(FM_POST, FM_GET))
    {
        $mixValue = null;

        if(!empty($mixMethod))
        {
            if(Stringer::isString($mixMethod))
                $mixMethod = array($mixMethod);

            if(Arrays::isArray($mixMethod))
            {
                foreach($mixMethod as $key => $val)
                {
                    if($val == FM_POST)
                    {
                        $mixValue = FM::convertValue(self::post($strName), $strType);
                        if(isset($mixValue))
                            break;
                    }
                    elseif($val == FM_GET)
                    {
                        $mixValue = FM::convertValue(self::get($strName), $strType);
                        if(isset($mixValue))
                            break;
                    }
                    elseif($val == FM_COOKIE)
                    {
                        $mixValue = FM::convertValue(self::cookie($strName), $strType);
                        if(isset($mixValue))
                            break;
                    }
                    elseif($val == FM_SESSION)
                    {
                        $mixValue = FM::convertValue(self::session($strName), $strType);
                        if(isset($mixValue))
                            break;
                    }
                    elseif($val == FM_FILES)
                    {
                        $mixValue = FM::convertValue(self::files($strName), $strType);
                        if(isset($mixValue))
                            break;
                    }
                }
            }
        }

        return $mixValue;
    }

    /**
     * Return value from post by name
     *
     * @param $strName
     * @return null
     */
    public static function post($strName)
    {
        $mixValue = null;

        if(isset($_POST[$strName]))
            $mixValue = $_POST[$strName];

        return $mixValue;
    }

    /**
     * Return value from get by name
     *
     * @param null $strName
     * @return null
     */
    public static function get($strName = null)
    {
        $mixValue = null;

        if(isset($strName))
        {
            if(isset($_GET[$strName]))
                $mixValue = $_GET[$strName];
        }
        elseif (isset($_GET))
            $mixValue = $_GET;

        return $mixValue;
    }

    /**
     * Return value from cookie by name
     *
     * @param $strName
     * @return null
     */
    public static function cookie($strName)
    {
        $mixValue = null;

        if(isset($_COOKIE[$strName]))
            $mixValue = $_COOKIE[$strName];

        return $mixValue;
    }

    /**
     * Return value from session by name
     *
     * @param $strName
     * @return null
     */
    public static function session($strName)
    {
        $mixValue = null;

        if(isset($_SESSION[$strName]))
            $mixValue = $_SESSION[$strName];

        return $mixValue;
    }

    /**
     * Return value from files by name
     *
     * @param $strName
     * @return null
     */
    public static function files($strName)
    {
        $mixValue = null;

        if(isset($_FILES[$strName]))
            $mixValue = $_FILES[$strName];

        return $mixValue;
    }
}