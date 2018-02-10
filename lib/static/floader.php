<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/29/2016
 * Time: 7:36 PM
 */
class Floader
{
    /**
     * @var array - Registar klasa
     * Tip niza je array(
     *                   'Naziv klase' => array(
     *                                          'path'  => 'putanja do fajla',
     *                                          'parent'=> 'Klasa koja se nasledjuje, ako postoji'
     *                                          'type'  => 'public|abstract'
     *                                          ),
     *                  );
     */
    private static $class_data;

    /**
     * @var - Registar staticnih klasa
     * Tip niza je array(
     *                   'Naziv klase' => array(
     *                                          'path'  => 'putanja do fajla',
     *                                          'parent'=> 'Klasa koja se nasledjuje, ako postoji'
     *                                          ),
     *                  );
     */
    private static $static_class;

    /**
     * Dodavanje klase
     *
     * @param string $strClassName - Naziv klase
     * @param string $strClassPath - Putanja do klase
     * @param string $strClassType - Tip klase, podrzani tipovi static|public|abstract
     * @param null $strClassParent
     * @throws Exception
     */
    public static function add_class($strClassName, $strClassPath, $strClassType = 'static', $strClassParent = null)
    {
        if($strClassType == 'static' || $strClassType == 'public' || $strClassType == 'abstract')
        {
            if(!file_exists($strClassPath))
                throw new Exception("Fajl $strClassPath ne postoji, $strClassName klasa se ne moze registrovati");


            if($strClassType == 'public' || $strClassType == 'abstract')
            {
                if(FM::is_variable($strClassParent) && !(self::issset_class($strClassParent)))
                    throw new Exception("Klasa $strClassParent se ne nalazi u registru klasa i ne moze biti parent klasi $strClassName");

                if(self::issset_class($strClassName))
                    throw new Exception("Klasa $strClassName je vec registrovana i ne moze se ponovo registrovati");

                self::$class_data[$strClassName] = array('path' => $strClassPath, 'parent' => $strClassParent, 'type' => $strClassType);
            }
            else
            {
                if(FM::is_variable($strClassParent) && !(self::isset_static_class($strClassParent)))
                    throw new Exception("Klasa $strClassParent se ne nalazi u registru klasa i ne moze biti parent klasi $strClassName");

                if(self::isset_static_class($strClassName))
                    throw new Exception("Staticna klasa $strClassName je vec registrovana i nemo ze se ponovo registrovati");

                self::$static_class[$strClassName] = array('path' => $strClassPath, 'parent' => $strClassParent);
            }
        }
        else
            throw new Exception("Tip klase $strClassType nije podrzan, porzani tipovi su static|public");

    }

    /**
     * Provera da li je klasa dodata
     *
     * @param string $strClassName - Naziv klase
     * @return bool - Status
     */
    public static function issset_class($strClassName)
    {
        $boolStatus = false;

        if(isset(self::$class_data[$strClassName]))
            $boolStatus = true;

        return $boolStatus;
    }

    /**
     * Provera da li je staticna klasa dodata
     *
     * @param string $strClassName - Naziv klase
     * @return bool - Status
     */
    public static function isset_static_class($strClassName)
    {
        $boolStatus = false;

        if(isset(self::$static_class[$strClassName]))
            $boolStatus = true;

        return $boolStatus;
    }

    /**
     * Includovanje klase
     *
     * @param string $strClassName - Naziv klase
     * @throws Exception
     */
    public static function load($strClassName)
    {
        if(!self::issset_class($strClassName))
            throw new Exception("Klasa $strClassName nije registrovana, klase se ne moze includovati");

        if(isset(self::$class_data[$strClassName]['parent']))
            self::load(self::$class_data[$strClassName]['parent']);

        FM::includer(self::$class_data[$strClassName]['path']);

        if(self::$class_data[$strClassName]['type'] == 'public')
            return new $strClassName();
    }

    /**
     * Includovanje staticnih klasa iz registra
     *
     */
    public static function load_static_class()
    {
        if(FM::is_variable(self::$static_class))
        {
            foreach(self::$static_class as $key => $val)
                FM::includer($val['path']);

            self::$static_class = null;
        }
    }
}