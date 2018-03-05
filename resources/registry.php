<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/29/2016
 * Time: 7:37 PM
 */

use fm\lib\help\ClassLoader, fm\lib\help\InterfaceLoader;

/**
 * Staticne klase
 */
ClassLoader::addClass('Stringer',          FM_STATIC . 'Stringer.php');
ClassLoader::addClass('Numeric',          FM_STATIC . 'Numeric.php');
ClassLoader::addClass('File',              FM_STATIC . 'File.php');
ClassLoader::addClass('Image',            FM_STATIC . 'Image.php');
ClassLoader::addClass('Arrays',            FM_STATIC . 'Arrays.php');
ClassLoader::addClass('Request',            FM_STATIC . 'Request.php');
ClassLoader::addClass('InterfaceLoader',   FM_STATIC . 'InterfaceLoader.php');
ClassLoader::addClass('TraitLoader',       FM_STATIC . 'TraitLoader.php');
ClassLoader::addClass('Router',             FM_STATIC . 'Router.php');

//Load staticnih klasa
ClassLoader::loadStaticClass();

InterfaceLoader::addItem('DatabaseEngine', FM_INTERFACE . 'DatabaseEngine.php');

/**
 * Abstraktne klase
 */
ClassLoader::addClass('Database',            FM_ABSTRACT . 'Database.php',         'abstract', null, ['DatabaseEngine']);

/**
 * Public klase
 */
ClassLoader::addClass('fm\lib\publisher\DatabasePdoEngine',              FM_PUBLIC . 'DatabasePdoEngine.php',             'public',   'Database');
ClassLoader::addClass('fm\lib\publisher\DatabaseEngine',               FM_PUBLIC . 'DatabaseEngine.php',              'public');
ClassLoader::addClass('fm\lib\publisher\Response',          FM_PUBLIC . 'Response.php',         'public');
ClassLoader::addClass('fm\lib\publisher\QueryBuilder',          FM_PUBLIC . 'QueryBuilder.php',         'public');