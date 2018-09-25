<?php

/**
 * Database engine interface
 *
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 2/17/2018
 * Time: 6:39 PM
 */

namespace fm\lib\interfaces;

interface DatabaseEngine
{
    public function connect();

    public function prepare($strQuery);

    public function execute($mixStatments);

    public function fetch($strFetchMode = FM_FETCH_ASSOC, $boolAll = true);

    public function fetchCount();

    public function free();

    public function rowCount();

    public function lastInsertId();
}