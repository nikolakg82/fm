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
     * Execute query on database, call methods prepare and execute
     *
     * @param string $strQuery - MYSQL query
     * @param null $mixStatements - Array for prepare statements
     * @return void
     */
    public function query($strQuery, $mixStatements = null)
    {
        $this->engine->prepare($strQuery);
        $this->engine->execute($mixStatements);
    }

    /**
     * Return result of query, call fetch method from main object
     *
     * @param string $strFetchMode - Result format. Allowed params is FM_FETCH_ASSOC|FM_FETCH_KEY_PAIR. FM_FETCH_ASSOC return array. FM_FETCH_KEY_PAIR return array but first field
     *                               in query is key and second is value
     * @param bool $boolAll - If true return all result else return first result
     * @return mixed - Result of query
     */
    public function fetch($strFetchMode = FM_FETCH_ASSOC, $boolAll = true)
    {
        return $this->engine->fetch($strFetchMode, $boolAll);
    }

    /**
     * Usage if query is like 'SELECT count(id)', return number of result
     *
     * @return int|null
     */
    public function fetchCount()
    {
        return $this->engine->fetchCount();
    }

    /**
     * Delete result of query
     *
     * @return void
     */
    public function free()
    {
        $this->engine->free();
    }

    /**
     * Return last insert id
     *
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->engine->lastInsertId();
    }

    /**
     * Returns the number of columns affected by the last query
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->engine->rowCount();
    }

    /**
     * Set parameter for database and connect it
     *
     * @param $arrConnectData - Params for connection of database
     * @return void
     */
    public function connect($arrConnectData)
    {
        $this->engine
            ->setHost($arrConnectData['host'])
            ->setUsername($arrConnectData['username'])
            ->setPassword($arrConnectData['password'])
            ->setName($arrConnectData['name'])
            ->connect();
    }

    /**
     * Check is PDO installed on the server, if yes make instance of DatabasePdoEngine class
     *
     * @throws \Exception
     * @return void
     */
    public function __construct()
    {
        if (defined('PDO::ATTR_DRIVER_NAME'))
            $this->engine = ClassLoader::load('fm\lib\publisher\DatabasePdoEngine');
        else
            throw new \Exception("PDO not installed, connection to the database is not possible.");
    }
}