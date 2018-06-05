<?php

/**
 * FM Main class
 *
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/6/2016
 * Time: 2:47 PM
 */
namespace fm;

use fm\lib\help\Arrays;
use fm\lib\help\ClassLoader;
use fm\lib\help\Numeric;
use fm\lib\help\Request;
use fm\lib\help\Stringer;

class FM
{
    /**
     * Include php file
     *
     * @param string $strPath - Path to the file
     * @param bool $boolOnce - Include once or multi time
     * @return mixed - Value of included file
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
     *
     * @deprecated - Method is deprecated, need to be removed
     */
    public static function is_variable($mixData)
    {
        $boolReturn = false;
        if(isset($mixData) && !empty($mixData))
            $boolReturn = true;

        return $boolReturn;
    }

    public static function convertValue($mixValue, $strType)
    {
        $mixReturn = null;

        if($strType == FM_STRING)
            $mixReturn = Stringer::convertToString($mixValue);
        elseif($strType == FM_INTEGER)
            $mixReturn = Numeric::convertToInteger($mixValue);
        elseif($strType == FM_FLOAT)
            $mixReturn = Numeric::floatVal($mixValue);
        elseif($strType == FM_ARRAY)
        {
            if(!empty($mixValue) && Arrays::isArray($mixValue))
                $mixReturn = $mixValue;
        }

        return $mixReturn;
    }

    public static function getServerProtocol()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    }

    public static function getSiteDomain()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public static function referer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public static function requestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getCustomHttpHeader($strKey)
    {
        $mixReturn = null;

        if(isset($_SERVER['HTTP_' . Stringer::uppercase($strKey)]))
            $mixReturn = $_SERVER['HTTP_' . Stringer::uppercase($strKey)];

        return $mixReturn;
    }

    public static function header($strHeader, $boolReplace = true, $intHttpResponseCode = null)
    {
        header($strHeader, $boolReplace, $intHttpResponseCode);
    }

    public static function redirect($strUrl, $intResponseCode = 301)
    {
        self::header("Location: $strUrl", true, $intResponseCode);
    }

    public static function startSession($strSessionName, $boolFromCookie = false)
    {
        $boolStartSession = true;

        // @TODO - check point of this condition
        if($boolFromCookie)
        {
            $strDataTemp = Request::cookie($strSessionName);

            if(!isset($strDataTemp))
                $boolStartSession = false;
        }

        if($boolStartSession)
        {
            session_name($strSessionName);
            session_start();
        }
    }

    public static function setSessionData($strKey, $strData)
    {
        $_SESSION[$strKey] = $strData;
    }

    public static function killSession($strKey, $strName)
    {
        unset($_SESSION[$strKey]);
        self::killCookie($strName);
    }

    public static function killCookie($strName)
    {
        self::setCookie($strName, '', time() + 50);
        unset($_COOKIE[$strName]);
    }

    public static function setCookie($strName, $strValue, $intTimeExpire = 0, $strPath = "/", $strDomain = "", $boolSecure = false, $boolHttpOnly = false)
    {
        setcookie($strName, $strValue, $intTimeExpire, $strPath, $strDomain, $boolSecure, $boolHttpOnly);
    }
}

define('FM_ROOT', realpath(dirname(__FILE__)) . '/');

FM::includer(FM_ROOT . 'resources/constants.php');
FM::includer(FM_STATIC . 'ClassLoader.php');
FM::includer(FM_RESOURCES . 'registry.php');

ClassLoader::loadStaticClass();