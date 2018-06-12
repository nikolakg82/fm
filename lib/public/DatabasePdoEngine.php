<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
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
     * Prepare mysql query for request
     *
     * @param $strQuery - MYSQL query
     * @return void
     */
    public function prepare($strQuery)
    {
        if($this->isConnect())
            $this->setResult($this->getConnection()->prepare($strQuery));
    }

    /**
     * Execute query with prepare statements
     *
     * @param null $mixStatements - parameter for prepare statements
     * @return void
     */
    public function execute($mixStatements = null)
    {
        $this->getResult()->execute($mixStatements);
    }

    /**
     * Return result of query
     *
     * @param string $strFetchMode - Result format. Allowed params is FM_FETCH_ASSOC|FM_FETCH_KEY_PAIR. FM_FETCH_ASSOC return array. FM_FETCH_KEY_PAIR return array but first field
     *                               in query is key and second is value
     * @param bool $boolAll - If true return all result else return first result
     * @return mixed - Result of query
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
     * Usage if query is like 'SELECT count(id)', return number of result
     *
     * @return int|null
     */
    public function fetchCount()
    {
        //@TODO - check this, if have't result have error
        return Numeric::convertToInteger(Arrays::reset($this->getResult()->fetch(\PDO::FETCH_ASSOC)));
    }

    /**
     * Delete result of query
     *
     * @return void
     */
    public function free()
    {
        $this->setResult(null);
    }

    /**
     * Return last insert id
     *
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }

    /**
     * Returns the number of columns affected by the last query
     *
     * @return mixed
     */
    public function rowCount()
    {
        return $this->getResult()->rowCount();
    }

    /**
     * PDO connect on database
     *
     * @return void
     */
    public function connect()
    {
        if(!$this->isConnect())
        {
            $this->setConnection(new \PDO("mysql:host=" . $this->getHost() . ";dbname=" . $this->getName() . ";charset=" . $this->getCharset(), $this->getUsername(), $this->getPassword()));

            // @TODO - if not connected put in log
        }
    }
}