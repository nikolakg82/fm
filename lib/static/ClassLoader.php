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
     * @var array - Registar klasa
     * Tip niza je array(
     *                   'Naziv klase' => array(
     *                                          'path'  => 'putanja do fajla',
     *                                          'parent'=> 'Klasa koja se nasledjuje, ako postoji'
     *                                          'type'  => 'public|abstract'
     *                                          'interfaces' => array() - niz sa nazivima interface-a
     *                                          'traits'     => array() - niz sa nazivima trait-a
     *                                          ),
     *                  );
     */
    protected static $classData;

    /**
     * @var - Registar staticnih klasa
     * Tip niza je array(
     *                   'Naziv klase' => array(
     *                                          'path'  => 'putanja do fajla',
     *                                          'parent'=> 'Klasa koja se nasledjuje, ako postoji'
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
     * @param null $strClassParent
     * @param array $arrInterfaces
     * @param array $arrTraits
     * @throws \Exception
     */
    public static function addClass($strClassName, $strClassPath, $strClassType = 'static', $strClassParent = null, $arrInterfaces = [], $arrTraits = [])
    {
        if($strClassType == 'static' || $strClassType == 'public' || $strClassType == 'abstract')
        {
            if(!file_exists($strClassPath))
                throw new \Exception("Fajl $strClassPath ne postoji, $strClassName klasa se ne moze registrovati");


            if($strClassType == 'public' || $strClassType == 'abstract')
            {
                if(isset($strClassParent) && !(self::existClass($strClassParent)))
                    throw new \Exception("Klasa $strClassParent se ne nalazi u registru klasa i ne moze biti parent klasi $strClassName");

                if(self::existClass($strClassName))
                    throw new \Exception("Klasa $strClassName je vec registrovana i ne moze se ponovo registrovati");

                self::$classData[$strClassName] = array('path' => $strClassPath, 'parent' => $strClassParent, 'type' => $strClassType, 'interfaces' => $arrInterfaces, 'traits' => $arrTraits);
            }
            else
            {
                if(isset($strClassParent) && !(self::existStaticClass($strClassParent)))
                    throw new \Exception("Klasa $strClassParent se ne nalazi u registru klasa i ne moze biti parent klasi $strClassName");

                if(self::existStaticClass($strClassName))
                    throw new \Exception("Staticna klasa $strClassName je vec registrovana i nemo ze se ponovo registrovati");

                self::$staticClass[$strClassName] = array('path' => $strClassPath, 'parent' => $strClassParent);
            }
        }
        else
            throw new \Exception("Tip klase $strClassType nije podrzan, porzani tipovi su static|public");

    }

    /**
     * Provera da li je klasa dodata
     *
     * @param string $strClassName - Naziv klase
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
     * Provera da li je staticna klasa dodata
     *
     * @param string $strClassName - Naziv klase
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
     * Includovanje klase
     *
     * @param string $strClassName - Naziv klase
     * @throws \Exception
     * @return object
     */
    public static function load($strClassName)
    {
        if(!self::existClass($strClassName))
            throw new \Exception("Klasa $strClassName nije registrovana, klase se ne moze includovati");

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

        //@TODO proveri da li treba da ide istanciranje uvek ili samo trazene klase, ako se extenduje klasa koja nije
        // abstraktna onda ce da se istancira i ona kao prant klasa sto u sustini i nije potrebno

        if(self::$classData[$strClassName]['type'] == 'public')
            return new $strClassName();
    }

    /**
     * Includovanje staticnih klasa iz registra
     *
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