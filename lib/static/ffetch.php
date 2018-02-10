<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/30/2016
 * Time: 6:39 PM
 */
class Ffetch
{
    public static function name($strName, $strType = FM_STRING, $mixMethod = array(FM_POST, FM_GET))
    {
        $mixValue = null;

        if(FM::is_variable($mixMethod))
        {
            if(Fstring::is_string($mixMethod))
                $mixMethod = array($mixMethod);

            if(Farray::is_array($mixMethod))
            {
                foreach($mixMethod as $key => $val)
                {
                    if($val == FM_POST)
                    {
                        if(FM::is_variable($mixValue = FM::convert_value(self::post($strName), $strType)))
                            break;
                    }
                    elseif($val == FM_GET)
                    {
                        if(FM::is_variable($mixValue = FM::convert_value(self::get($strName), $strType)))
                            break;
                    }
                    elseif($val == FM_COOKIE)
                    {
                        if(FM::is_variable($mixValue == FM::convert_value(self::cookie($strName), $strType)))
                            break;
                    }
                    elseif($val == FM_SESSION)
                    {
                        if(FM::is_variable($mixValue == FM::convert_value(self::session($strName), $strType)))
                            break;
                    }
                    elseif($val == FM_FILES)
                    {
                        if(FM::is_variable($mixValue == FM::convert_value(self::files($strName), $strType)))
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