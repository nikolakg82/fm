<?php

/**
 * Created by PhpStorm.
 * User: IMS-WS01
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