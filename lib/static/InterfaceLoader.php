<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 2/14/2018
 * Time: 1:34 PM
 */

namespace fm\lib\help;

use fm\FM;

class InterfaceLoader
{
    /**
     * @var - array (Interfaces storage)
     *
     * array(
     *      'Interface name' => array(
     *                                  'path'      => 'Path to the interface',
     *                                  'parent'    => 'Name of parent interface'
     *                              (
     *      )
     */
    protected static $data;

    public static function addItem($strName, $strPath, $strParent = null)
    {
        if(!isset($strName))
            throw new \Exception("Please forward interface name");

        if(self::issetItem($strName))
            throw new \Exception("Interface $strName already exist. Interface can't registry.");

        if(!isset($strPath))
            throw new \Exception("Please forward interface file path");

        if(!file_exists($strPath))
            throw new \Exception("Interface $strName on path $strPath not exist");

        if(isset($strParent))
        {
            if(!self::issetItem($strParent))
                throw new \Exception("Parent interface $strParent not defined");

            self::$data[$strName]['parent'] = $strParent;
        }

        self::$data[$strName]['path'] = $strPath;

    }

    public static function load($strName)
    {
        if(!self::issetItem($strName))
            throw new \Exception("Interface $strName not exist. Can't load interface.");

        if(isset(self::$data[$strName]['parent']))
            self::load(self::$data[$strName]['parent']);

        FM::includer(self::$data[$strName]['path']);
    }

    public static function issetItem($strName)
    {
        $boolReturn = false;

        if(isset(self::$data[$strName]))
            $boolReturn = true;

        return $boolReturn;
    }
}