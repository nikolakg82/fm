<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/22/2016
 * Time: 1:16 PM
 */
class Fpdo extends Fmysql
{
    /**
     * Vrsi se priprema mysql stringa za upit
     *
     * @param $strQuery - MYSQL upit
     */
    public function prepare($strQuery)
    {
        if($this->is_connect())
        {
            $this->set_result($this->get_connection()->prepare($strQuery));
        }
    }

    /**
     * Vrsi se mysql upit, sa prosledjenim parametrima za prepare statment
     *
     * @param null $mixStatments - parametri prepare statment
     */
    public function execute($mixStatments = null)
    {
        $this->get_result()->execute($mixStatments);
    }

    /**
     * Vraca rezultat upita, jedan ili vise reziltata, formatiranih na odredjeni nacin
     *
     * @param string $strFetchMode - Mod za vracanje rezultata ako je FM_FETCH_ASSOC - vraca kao niz, FM_FETCH_KEY_PAIR - vraca tako sto je prvo polje u upitu kljuc niza a drugo
     * vrenost niza
     * @param bool $boolAll - Ako je true onda vraca sve rezultate u niz, a false vraca samo prvi rezultat
     * @return mixed
     */
    public function fetch($strFetchMode = FM_FETCH_ASSOC, $boolAll = true)
    {
        $strResultMode = PDO::FETCH_ASSOC;
        if($strFetchMode == FM_FETCH_KEY_PAIR)
            $strResultMode = PDO::FETCH_KEY_PAIR;

        if($boolAll)
            $arrData = $this->get_result()->fetchAll($strResultMode);
        else
            $arrData = $this->get_result()->fetch($strResultMode);

        return $arrData;
    }

    /**
     * Koristi se kad se radi SELECT count(id), da vrati broj rezultata
     *
     * @return int|null
     */
    public function fetch_count()
    {
        return Finteger::convert_to_integer(Farray::reset($this->get_result()->fetch(PDO::FETCH_ASSOC)));
    }

    /**
     * Brise rezultate upita
     *
     */
    public function free()
    {
        $this->set_result(null);
    }

    /**
     * Vraca poslednji upisani id
     *
     * @return mixed
     */
    public function last_insert_id()
    {
        return $this->get_connection()->lastInsertId();
    }

    /**
     * Vraca broj kolona na koje je uticao prethodni upit
     *
     * @return mixed
     */
    public function row_count()
    {
        return $this->get_result()->rowCount();
    }

    /**
     * PDO konekcija na bazu
     */
    public function connect()
    {
        if(!$this->is_connect())
        {
            $this->set_connection(new PDO("mysql:host=" . $this->get_host() . ";dbname=" . $this->get_name() . ";charset=" . $this->get_charset(), $this->get_username(), $this->get_password()));

            // @TODO - ako konekcija nije uspela upisati u log
        }
    }
}