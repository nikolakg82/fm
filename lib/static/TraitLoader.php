<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 2/16/2018
 * Time: 1:40 PM
 */
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

    public static function addItem($strName, $strPath)
    {
        if(!isset($strName))
            throw new Exception("Please forward trait name");

        if(self::issetItem($strName))
            throw new Exception("Trait $strName already exist. Trait can't registry.");

        if(!isset($strPath))
            throw new Exception("Please forward trait file path");

        if(!file_exists($strPath))
            throw new Exception("Trait $strName on path $strPath not exist");

        self::$data[$strName]['path'] = $strPath;
    }

    public static function load($strName)
    {
        if(!self::issetItem($strName))
            throw new Exception("Trait $strName not exist. Can't load interface.");

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