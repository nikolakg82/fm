<?php

/**
 * Main database class
 *
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
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
     * @var - name of database
     */
    protected $name;

    /**
     * @var - Username
     */
    protected $username;

    /**
     * @var - Password
     */
    protected $password;

    /**
     * @var - Instance of connection on database
     */
    protected $connection;

    /**
     * @var string - Character set
     */
    protected $charset = "utf8";

    /**
     * @var - Result from query
     */
    protected $result;


    /**
     * Getter hostname
     *
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Getter name of database
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Getter username
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Getter password
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Getter connection on database
     *
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Getter character set
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Getter result of query
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }


    /**
     * Set hostname
     *
     * @param string $strHost
     */
    public function setHost($strHost)
    {
        $this->host = $strHost;
    }

    /**
     * Set name of database
     *
     * @param string $strName
     */
    public function setName($strName)
    {
        $this->name = $strName;
    }

    /**
     * Set username
     *
     * @param string $strUsername
     */
    public function setUsername($strUsername)
    {
        $this->username = $strUsername;
    }

    /**
     * Set password
     *
     * @param string $strPassword
     */
    public function setPassword($strPassword)
    {
        $this->password = $strPassword;
    }

    /**
     * Set character set
     *
     * @param string $strCharset
     */
    public function setCharset($strCharset)
    {
        $this->charset = $strCharset;
    }

    /**
     * Set result of query
     *
     * @param mixed $mixData
     */
    public function setResult($mixData)
    {
        $this->result = $mixData;
    }

    /**
     * Set connection on database
     *
     * @param object $objConnection
     */
    public function setConnection($objConnection)
    {
        $this->connection = $objConnection;
    }

    /**
     * Check if already connected on database, if yes return true
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