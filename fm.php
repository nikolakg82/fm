<?php

/**
 * FM glavna klasa
 *
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/6/2016
 * Time: 2:47 PM
 */
class FM
{
    /**
     * Radi php include fajla
     *
     * @param string $strPath - putanja do fajla
     * @param bool $boolOnce - includovanje samo jednom ili vise puta
     * @return mixed - Vraca includovan fajl, ako ima return u njemu
     */
    public static function includer($strPath, $boolOnce = true)
    {
        if($boolOnce)
            $mixData = require_once ($strPath);
        else
            $mixData = require ($strPath);

        return $mixData;
    }

    /**
     * @param $mixData
     * @return bool
     */
    public static function is_variable($mixData)
    {
        $boolReturn = false;
        if(isset($mixData) && !empty($mixData))
            $boolReturn = true;

        return $boolReturn;
    }

    public static function convert_value($mixValue, $strType)
    {
        $mixReturn = null;

        if($strType == FM_STRING)
            $mixReturn = Fstring::convert_to_string($mixValue);
        elseif($strType == FM_INTEGER)
            $mixReturn = Finteger::convert_to_integer($mixValue);
        elseif($strType == FM_FLOAT)
            $mixReturn = Finteger::floatval($mixValue);
        elseif($strType == FM_ARRAY)
        {
            if(self::is_variable($mixValue) && Farray::is_array($mixValue))
                $mixReturn = $mixValue;
        }

        return $mixReturn;
    }

    public static function get_server_protocol()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    }

    public static function get_site_domain()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public static function referer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public static function header($strHeader, $boolReplace = true, $intHttpResponseCode = null)
    {
        header($strHeader, $boolReplace, $intHttpResponseCode);
    }

    public static function redirect($strUrl, $intResponseCode = 301)
    {
        self::header("Location: $strUrl", true, $intResponseCode);
    }

    public static function start_session($strSessionName, $boolFromCookie = false)
    {
        $boolStartSession = true;

        if($boolFromCookie && !FM::is_variable(Ffetch::cookie($strSessionName)))
            $boolStartSession = false;

        if($boolStartSession)
        {
            session_name($strSessionName);
            session_start();
        }
    }

    public static function set_session_data($strKey, $strData)
    {
        $_SESSION[$strKey] = $strData;
    }

    public static function kill_session($strKey, $strName)
    {
        unset($_SESSION[$strKey]);
        self::kill_cookie($strName);
    }

    public static function kill_cookie($strName)
    {
        self::set_cookie($strName, '', time() + 50);
        unset($_COOKIE[$strName]);
    }

    public static function set_cookie($strName, $strValue, $intTimeExpire = 0, $strPath = "/", $strDomain = "", $boolSecure = false, $boolHttpOnly = false)
    {
        setcookie($strName, $strValue, $intTimeExpire, $strPath, $strDomain, $boolSecure, $boolHttpOnly);
    }
}

define('FM_ROOT', realpath(dirname(__FILE__)) . '/');

FM::includer(FM_ROOT . 'resources/constants.php');
FM::includer(FM_STATIC . 'floader.php');
FM::includer(FM_RESOURCES . 'registry.php');

Floader::load_static_class();