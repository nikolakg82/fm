<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 2/16/2018
 * Time: 1:40 PM
 */

namespace fm\lib\help;

use fm\FM;

class TraitLoader
{
    /**
     * @var - array (Traits storage)
     *
     * array(
     *      'Trait name' => array(
     *                                  'path'      => 'Path to the trait',
     *                              (
     *      )
     */
    protected static $data;

    /**
     * Add trait to register
     *
     * @param $strName - Name of the trait
     * @param $strPath - Path to the trait
     * @throws \Exception
     */
    public static function addItem($strName, $strPath)
    {
        if(!isset($strName))
            throw new \Exception("Please forward trait name");

        if(self::issetItem($strName))
            throw new \Exception("Trait $strName already exist. Trait can't registry.");

        if(!isset($strPath))
            throw new \Exception("Please forward trait file path");

        if(!file_exists($strPath))
            throw new \Exception("Trait $strName on path $strPath not exist");

        self::$data[$strName]['path'] = $strPath;
    }

    /**
     * Load trait
     *
     * @param $strName - Name of the trait
     * @throws \Exception
     */
    public static function load($strName)
    {
        if(!self::issetItem($strName))
            throw new \Exception("Trait $strName not exist. Can't load trait.");

        FM::includer(self::$data[$strName]['path']);
    }

    /**
     * Check if trait registered
     *
     * @param $strName - name of the trait
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