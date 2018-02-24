<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/28/2016
 * Time: 12:23 PM
 */

namespace fm\lib\abstracts;

use fm\lib\interfaces\DatabaseEngine;

abstract class Database implements DatabaseEngine
{
    /**
     * @var - MYSQL host name
     */
    protected $host;

    /**
     * @var - Naziv baze
     */
    protected $name;

    /**
     * @var - Korisnicko ime
     */
    protected $username;

    /**
     * @var - Sifra
     */
    protected $password;

    /**
     * @var - Istanca konekcija na bazu
     */
    protected $connection;

    /**
     * @var string - Karakter set
     */
    protected $charset = "utf8";

    /**
     * @var - Rezultat upita
     */
    protected $result;


    /**
     * Craca host name
     *
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Vraca naziv baze
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Vraca korisnicko ime
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Vraca siftu
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Vraca konekciju
     *
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Vraca karakter set
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Vraca rezultat upita
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }


    /**
     * Setuje host name
     *
     * @param $strHost
     */
    public function setHost($strHost)
    {
        $this->host = $strHost;
    }

    /**
     * Setuje naziv baze
     *
     * @param $strName
     */
    public function setName($strName)
    {
        $this->name = $strName;
    }

    /**
     * Setuje korisnicko ime
     *
     * @param $strUsername
     */
    public function setUsername($strUsername)
    {
        $this->username = $strUsername;
    }

    /**
     * Setuje sifru
     *
     * @param $strPassword
     */
    public function setPassword($strPassword)
    {
        $this->password = $strPassword;
    }

    /**
     * Setuje karakter set
     *
     * @param $strCharset
     */
    public function setCharset($strCharset)
    {
        $this->charset = $strCharset;
    }

    /**
     * Setuje rezultat upita
     *
     * @param $mixData
     */
    public function setResult($mixData)
    {
        $this->result = $mixData;
    }

    /**
     * Setuje konekciju na bazu
     *
     * @param $objConnection
     */
    public function setConnection($objConnection)
    {
        $this->connection = $objConnection;
    }

    /**
     * Proverava da li postoji konekcija na bazu
     *
     * @return bool
     */
    public function isConnect()
    {
        $boolReturn = false;

        if(isset($this->connection))
            $boolReturn = true;

        return $boolReturn;
    }
}