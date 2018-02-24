<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/30/2016
 * Time: 6:39 PM
 */

namespace fm\lib\help;

use fm\FM;

class Request
{
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

    public static function post($strName)
    {
        $mixValue = null;

        if(isset($_POST[$strName]))
            $mixValue = $_POST[$strName];

        return $mixValue;
    }

    public static function get($strName)
    {
        $mixValue = null;

        if(isset($_GET[$strName]))
            $mixValue = $_GET[$strName];

        return $mixValue;
    }

    public static function cookie($strName)
    {
        $mixValue = null;

        if(isset($_COOKIE[$strName]))
            $mixValue = $_COOKIE[$strName];

        return $mixValue;
    }

    public static function session($strName)
    {
        $mixValue = null;

        if(isset($_SESSION[$strName]))
            $mixValue = $_SESSION[$strName];

        return $mixValue;
    }

    public static function files($strName)
    {
        $mixValue = null;

        if(isset($_FILES[$strName]))
            $mixValue = $_FILES[$strName];

        return $mixValue;
    }
}