<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/30/2016
 * Time: 3:08 PM
 */
class Farray
{
    public static function reset($arrData)
    {
        return reset($arrData);
    }

    public static function is_array($mixData)
    {
        return is_array($mixData);
    }

    public static function serialize($arrData)
    {
        return serialize($arrData);
    }

    public static function unserialize($strData)
    {
        return unserialize($strData);
    }
}