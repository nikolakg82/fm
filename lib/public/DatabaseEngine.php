<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/30/2016
 * Time: 3:12 PM
 */

namespace fm\lib\publisher;

use fm\lib\help\ClassLoader;

class DatabaseEngine
{
    /**
     * @var \fm\lib\interfaces\DatabaseEngine
     */
    protected $engine;

    /**
     * Izvrsava upit na bazu, poziva metode prepare i execute
     *
     * @param string $strQuery - MYSQL upit
     * @param null $mixStatments - Niz za prepare statments
     */
    public function query($strQuery, $mixStatments = null)
    {
        $this->engine->prepare($strQuery);
        $this->engine->execute($mixStatments);
    }

    /**
     * Vraca rezultat prethodnog upita na bazu, poziva fetch metodu glavnog objekta
     *
     * @param string $strFetchMode - Mod za vracanje rezultata ako je FM_FETCH_ASSOC - vraca kao niz, FM_FETCH_KEY_PAIR - vraca tako sto je prvo polje u upitu kljuc niza a drugo
     * vrenost niza
     * @param bool $boolAll - Ako je true onda vraca sve rezultate u niz, a false vraca samo prvi rezultat
     * @return mixed - Rezultat upita
     */
    public function fetch($strFetchMode = FM_FETCH_ASSOC, $boolAll = true)
    {
        return $this->engine->fetch($strFetchMode, $boolAll);
    }

    /**
     * Koristi se kad se radi SELECT count(id), da vrati broj rezultata
     * @return int|null
     */
    public function fetchCount()
    {
        return $this->engine->fetchCount();
    }

    /**
     * Brise rezultate upita
     */
    public function free()
    {
        $this->engine->free();
    }

    /**
     * Vraca poslednji upisani id
     *
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->engine->lastInsertId();
    }

    /**
     * Vraca broj kolona na koje je uticao prethodni upit
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->engine->rowCount();
    }

    /**
     * Setuje parametre za bazu i kaci se na bazu
     *
     * @param $arrConnectData
     */
    public function connect($arrConnectData)
    {
        $this->engine->setHost($arrConnectData['host']);
        $this->engine->setUsername($arrConnectData['username']);
        $this->engine->setPassword($arrConnectData['password']);
        $this->engine->setName($arrConnectData['name']);
        $this->engine->connect();
    }

    /**
     * Fdb constructor., proverava da li je instaliran PDO na serveru, ako jeste pravi PDO instancu
     * @throws \Exception
     */
    public function __construct()
    {
        if (defined('PDO::ATTR_DRIVER_NAME'))
            $this->engine = ClassLoader::load('fm\lib\publisher\DatabasePdoEngine');
        else
            throw new \Exception("PDO nije instaliran, konekcija na bazu nije moguca");
    }
}