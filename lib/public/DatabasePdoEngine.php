<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/22/2016
 * Time: 1:16 PM
 */

namespace fm\lib\publisher;

use fm\lib\abstracts\Database;
use fm\lib\help\Arrays;
use fm\lib\help\Numeric;

class DatabasePdoEngine extends Database
{
    /**
     * Vrsi se priprema mysql stringa za upit
     *
     * @param $strQuery - MYSQL upit
     */
    public function prepare($strQuery)
    {
        if($this->isConnect())
        {
            $this->setResult($this->getConnection()->prepare($strQuery));
        }
    }

    /**
     * Vrsi se mysql upit, sa prosledjenim parametrima za prepare statment
     *
     * @param null $mixStatments - parametri prepare statment
     */
    public function execute($mixStatments = null)
    {
        $this->getResult()->execute($mixStatments);
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
        $strResultMode = \PDO::FETCH_ASSOC;
        if($strFetchMode == FM_FETCH_KEY_PAIR)
            $strResultMode = \PDO::FETCH_KEY_PAIR;

        if($boolAll)
            $arrData = $this->getResult()->fetchAll($strResultMode);
        else
            $arrData = $this->getResult()->fetch($strResultMode);

        return $arrData;
    }

    /**
     * Koristi se kad se radi SELECT count(id), da vrati broj rezultata
     *
     * @return int|null
     */
    public function fetchCount()
    {
        //@TODO - ovo verovatno treba malo prepraviti, ako nema rezultat baca error
        return Numeric::convertToInteger(Arrays::reset($this->getResult()->fetch(\PDO::FETCH_ASSOC)));
    }

    /**
     * Brise rezultate upita
     *
     */
    public function free()
    {
        $this->setResult(null);
    }

    /**
     * Vraca poslednji upisani id
     *
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }

    /**
     * Vraca broj kolona na koje je uticao prethodni upit
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->getResult()->rowCount();
    }

    /**
     * PDO konekcija na bazu
     */
    public function connect()
    {
        if(!$this->isConnect())
        {
            $this->setConnection(new \PDO("mysql:host=" . $this->getHost() . ";dbname=" . $this->getName() . ";charset=" . $this->getCharset(), $this->getUsername(), $this->getPassword()));

            // @TODO - ako konekcija nije uspela upisati u log
        }
    }
}