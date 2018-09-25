<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
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

    /**
     * Add interface to register
     *
     * @param $strName - Name of interface
     * @param $strPath - Path to the interface
     * @param null $strParent - Name of interface parent
     * @throws \Exception
     */
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

    /**
     * Load interface
     *
     * @param $strName - Name of interface
     * @throws \Exception
     */
    public static function load($strName)
    {
        if(!self::issetItem($strName))
            throw new \Exception("Interface $strName not exist. Can't load interface.");

        if(isset(self::$data[$strName]['parent']))
            self::load(self::$data[$strName]['parent']);

        FM::includer(self::$data[$strName]['path']);
    }

    /**
     * Check if interface registered
     *
     * @param $strName - Name of interface
     * @return bool
     */
    public static function issetItem($strName)
    {
        $boolReturn = false;

        if(isset(self::$data[$strName]))
            $boolReturn = true;

        return $boolReturn;
    }
}