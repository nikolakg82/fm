<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/28/2016
 * Time: 12:23 PM
 */
abstract class Fmysql
{
    /**
     * @var - MYSQL host name
     */
    private $host;

    /**
     * @var - Naziv baze
     */
    private $name;

    /**
     * @var - Korisnicko ime
     */
    private $username;

    /**
     * @var - Sifra
     */
    private $password;

    /**
     * @var - Istanca konekcija na bazu
     */
    private $connection;

    /**
     * @var string - Karakter set
     */
    private $charset = "utf8";

    /**
     * @var - Rezultat upita
     */
    private $result;


    /**
     * Craca host name
     *
     * @return mixed
     */
    public function get_host()
    {
        return $this->host;
    }

    /**
     * Vraca naziv baze
     *
     * @return mixed
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Vraca korisnicko ime
     *
     * @return mixed
     */
    public function get_username()
    {
        return $this->username;
    }

    /**
     * Vraca siftu
     *
     * @return mixed
     */
    public function get_password()
    {
        return $this->password;
    }

    /**
     * Vraca konekciju
     *
     * @return mixed
     */
    public function get_connection()
    {
        return $this->connection;
    }

    /**
     * Vraca karakter set
     *
     * @return string
     */
    public function get_charset()
    {
        return $this->charset;
    }

    /**
     * Vraca rezultat upita
     *
     * @return mixed
     */
    public function get_result()
    {
        return $this->result;
    }


    /**
     * Setuje host name
     *
     * @param $strHost
     */
    public function set_host($strHost)
    {
        $this->host = $strHost;
    }

    /**
     * Setuje naziv baze
     *
     * @param $strName
     */
    public function set_name($strName)
    {
        $this->name = $strName;
    }

    /**
     * Setuje korisnicko ime
     *
     * @param $strUsername
     */
    public function set_username($strUsername)
    {
        $this->username = $strUsername;
    }

    /**
     * Setuje sifru
     *
     * @param $strPassword
     */
    public function set_password($strPassword)
    {
        $this->password = $strPassword;
    }

    /**
     * Setuje karakter set
     *
     * @param $strCharset
     */
    public function set_charset($strCharset)
    {
        $this->charset = $strCharset;
    }

    /**
     * Setuje rezultat upita
     *
     * @param $mixData
     */
    public function set_result($mixData)
    {
        $this->result = $mixData;
    }

    /**
     * Setuje konekciju na bazu
     *
     * @param $objConnection
     */
    public function set_connection($objConnection)
    {
        $this->connection = $objConnection;
    }

    /**
     * Proverava da li postoji konekcija na bazu
     *
     * @return bool
     */
    public function is_connect()
    {
        $boolReturn = false;

        if(FM::is_variable($this->get_connection()))
            $boolReturn = true;

        return $boolReturn;
    }
}