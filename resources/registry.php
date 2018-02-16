<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/29/2016
 * Time: 7:37 PM
 */
use fm\lib\help\Floader;

/**
 * Staticne klase
 */
Floader::add_class('Stringer',          FM_STATIC . 'Stringer.php');
Floader::add_class('Numeric',          FM_STATIC . 'Numeric.php');
Floader::add_class('File',              FM_STATIC . 'File.php');
Floader::add_class('Image',            FM_STATIC . 'Image.php');
Floader::add_class('Arrays',            FM_STATIC . 'Arrays.php');
Floader::add_class('Request',            FM_STATIC . 'Request.php');
Floader::add_class('InterfaceLoader',   FM_STATIC . 'InterfaceLoader.php');
Floader::add_class('TraitLoader',       FM_STATIC . 'TraitLoader.php');

//Load staticnih klasa
Floader::load_static_class();

/**
 * Abstraktne klase
 */
Floader::add_class('Fmysql',            FM_ABSTRACT . 'fmysql.php',         'abstract');

/**
 * Public klase
 */
Floader::add_class('Fpdo',              FM_PUBLIC . 'fpdo.php',             'public',   'Fmysql');
Floader::add_class('Fdb',               FM_PUBLIC . 'fdb.php',              'public');
Floader::add_class('Response',          FM_PUBLIC . 'Response.php',         'public');