<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/29/2016
 * Time: 7:37 PM
 */

/**
 * Staticne klase
 */
Floader::add_class('Fstring',           FM_STATIC . 'fstring.php');
Floader::add_class('Finteger',          FM_STATIC . 'finteger.php');
Floader::add_class('Ffile',             FM_STATIC . 'ffile.php');
Floader::add_class('Fimage',            FM_STATIC . 'fimage.php');
Floader::add_class('Farray',            FM_STATIC . 'farray.php');
Floader::add_class('Ffetch',            FM_STATIC . 'ffetch.php');

/**
 * Abstraktne klase
 */
Floader::add_class('Fmysql',            FM_ABSTRACT . 'fmysql.php',         'abstract');

/**
 * Public klase
 */
Floader::add_class('Fpdo',              FM_PUBLIC . 'fpdo.php',             'public',   'Fmysql');
Floader::add_class('Fdb',               FM_PUBLIC . 'fdb.php',              'public');