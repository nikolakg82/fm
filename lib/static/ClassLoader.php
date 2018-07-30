<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/29/2016
 * Time: 7:36 PM
 */
namespace fm\lib\help;

use fm\FM;

class ClassLoader
{
    /**
     * @var array - Class registry
     *
     * Example: array(
     *                   'Class name' => array(
     *                                          'path'  => 'Path to the file',
     *                                          'parent'=> 'Parent class, if exist'
     *                                          'type'  => 'public|abstract'
     *                                          'interfaces' => array() - array with interfaces name
     *                                          'traits'     => array() - array with traits name
     *                                          ),
     *                  );
     */
    protected static $classData;

    /**
     * @var - Registry static class
     *
     * Example: array(
     *                   'Class name' => array(
     *                                          'path'  => 'Path to the file',
     *                                          'parent'=> 'Parent class, if exist'
     *                                          ),
     *                  );
     */
    protected static $staticClass;

    /**
     * Add class to registry
     *
     * @param $strClassName - Class name
     * @param $strClassPath - Path to class file
     * @param string $strClassType - Type of class (static|public|abstract)
     * @param null $strClassParent - Parent class
     * @param array $arrInterfaces - Array with interfaces
     * @param array $arrTraits - Array with traits
     * @throws \Exception
     */
    public static function addClass($strClassName, $strClassPath, $strClassType = 'static', $strClassParent = null, $arrInterfaces = [], $arrTraits = [])
    {
        if($strClassType == 'static' || $strClassType == 'public' || $strClassType == 'abstract')
        {
            if(!file_exists($strClassPath))
                throw new \Exception("File $strClassPath does not exist, $strClassName class can not be registered");

            if($strClassType == 'public' || $strClassType == 'abstract')
            {
                if(isset($strClassParent) && !(self::existClass($strClassParent)))
                    throw new \Exception("Class $strClassParent does not exist in registry and can't be parent of class $strClassName");

                if(self::existClass($strClassName))
                    throw new \Exception("Class $strClassName is already registered, can't registry again");

                self::$classData[$strClassName] = array('path' => $strClassPath, 'parent' => $strClassParent, 'type' => $strClassType, 'interfaces' => $arrInterfaces, 'traits' => $arrTraits);
            }
            else
            {
                if(isset($strClassParent) && !(self::existStaticClass($strClassParent)))
                    throw new \Exception("Class $strClassParent does not exist in registry and can't be parent of class $strClassName");

                if(self::existStaticClass($strClassName))
                    throw new \Exception("Static class $strClassName is already registered, can't registry again");

                self::$staticClass[$strClassName] = array('path' => $strClassPath, 'parent' => $strClassParent);
            }
        }
        else
            throw new \Exception("Type of class $strClassType is not supported, supported class types are static|public");

    }

    /**
     * Check if class exist
     *
     * @param string $strClassName - Class name
     * @return bool - Status
     */
    public static function existClass($strClassName)
    {
        $boolStatus = false;

        if(isset(self::$classData[$strClassName]))
            $boolStatus = true;

        return $boolStatus;
    }

    /**
     * Check if static class exist
     *
     * @param string $strClassName - Class name
     * @return bool - Status
     */
    public static function existStaticClass($strClassName)
    {
        $boolStatus = false;

        if(isset(self::$staticClass[$strClassName]))
            $boolStatus = true;

        return $boolStatus;
    }

    /**
     * Load class
     *
     * @param string $strClassName - Class name
     * @throws \Exception
     * @return object
     */
    public static function load($strClassName)
    {
        if(!self::existClass($strClassName))
            throw new \Exception("Class $strClassName is not registered, class can not be loaded");

        if(isset(self::$classData[$strClassName]['parent']))
            self::load(self::$classData[$strClassName]['parent']);

        if(!empty(self::$classData[$strClassName]['interfaces']))
        {
            foreach (self::$classData[$strClassName]['interfaces'] as $strInterfaceName)
                InterfaceLoader::load($strInterfaceName);
        }

        if(!empty(self::$classData[$strClassName]['traits']))
        {
            foreach (self::$classData[$strClassName]['traits'] as $strTraitName)
                TraitLoader::load($strTraitName);
        }

        FM::includer(self::$classData[$strClassName]['path']);

        //@TODO check whether the trend is always to go out, or only the requested class, if a class that is not
        // abstract is extending then it will be expelled, and it as a prant class is essentially what is needed

        if(self::$classData[$strClassName]['type'] == 'public')
            return new $strClassName();
    }

    /**
     * Load all static class
     */
    public static function loadStaticClass()
    {
        if(isset(self::$staticClass))
        {
            foreach(self::$staticClass as $key => $val)
                FM::includer($val['path']);

            self::$staticClass = null;
        }
    }
}