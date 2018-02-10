<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/30/2016
 * Time: 3:12 PM
 */
class Fdb
{
    /**
     * @var db_object - Objekat koji se kaci na bazu
     */
    private $db_object;

    /**
     * Izvrsava upit na bazu, poziva metode prepare i execute
     *
     * @param string $strQuery - MYSQL upit
     * @param null $mixStatments - Niz za prepare statments
     */
    public function query($strQuery, $mixStatments = null)
    {
        $this->db_object->prepare($strQuery);
        $this->db_object->execute($mixStatments);
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
        return $this->db_object->fetch($strFetchMode, $boolAll);
    }

    /**
     * Koristi se kad se radi SELECT count(id), da vrati broj rezultata
     * @return int|null
     */
    public function fetch_count()
    {
        return $this->db_object->fetch_count();
    }

    /**
     * Brise rezultate upita
     */
    public function free()
    {
        $this->db_object->free();
    }

    /**
     * Vraca poslednji upisani id
     *
     * @return mixed
     */
    public function last_insert_id()
    {
        return $this->db_object->last_insert_id();
    }

    /**
     * Vraca broj kolona na koje je uticao prethodni upit
     *
     * @return mixed
     */
    public function row_count()
    {
        return $this->db_object->row_count();
    }

    /**
     * Setuje parametre za bazu i kaci se na bazu
     *
     * @param $arrConnectData
     */
    public function connect($arrConnectData)
    {
        $this->db_object->set_host($arrConnectData['host']);
        $this->db_object->set_username($arrConnectData['username']);
        $this->db_object->set_password($arrConnectData['password']);
        $this->db_object->set_name($arrConnectData['name']);
        $this->db_object->connect();
    }

    /**
     * Fdb constructor., proverava da li je instaliran PDO na serveru, ako jeste pravi PDO instancu
     * @throws Exception
     */
    public function __construct()
    {
        if (defined('PDO::ATTR_DRIVER_NAME'))
            $this->db_object = Floader::load('Fpdo');
        else
            throw new Exception("PDO nije instaliran, konekcija na bazu nije moguca");
    }
}