<?php

/**
 * Ovde se definisu sve konstante
 */

/**
 * Putanje do foldera
 */
    define('FM_LIB',            FM_ROOT         . "lib/");
    define('FM_ABSTRACT',       FM_LIB          . "abstract/");
    define('FM_PUBLIC',         FM_LIB          . "public/");
    define('FM_STATIC',         FM_LIB          . "static/");

    define('FM_RESOURCES',      FM_ROOT         . "resources/");

/**
 *  Tipovi varijabli
 */
    define('FM_STRING',         'string');
    define('FM_INTEGER',        'integer');
    define('FM_ARRAY',          'array');
    define('FM_FLOAT',          'float');
    define('FM_BOOLEAN',        'boolean');

/**
 * Hederi
 */
    define('FM_POST',           'post');
    define('FM_GET',            'get');
    define('FM_COOKIE',         'cookie');
    define('FM_SESSION',        'session');
    define('FM_FILES',          'files');

/**
 * Tipovi prikaza
 */
    define('FM_HTML',           'html');
    define('FM_RSS',            'rss');
    define('FM_JSON',           'json');

/**
 * Tipovi polja
 */
    define('FM_AUTO',           'auto');
    define('FM_MLC',            'mlc');
    define('FM_TEXT',           'text');
    define('FM_DATE',           'date');
    define('FM_NUMERIC',        'numeric');
    define('FM_TEXT_AREA',      'textarea');
    define('FM_TEXT_EDITOR',    'texteditor');
    define('FM_SWITCH',         'switch');
    define('FM_SELECT',         'select');

/**
 * Ostale konstante
 */
    define('FM_FETCH_ASSOC',    'fetch_assoc');// Rezultat da bude asocijaticni niz
    define('FM_FETCH_KEY_PAIR', 'fetch_key_pair');// Rezultat da bude u formatu kljuc => vrednost
    define('FM_DATA',           'data');
    define('FM_FIELDS',         'fields');
    define('FM_SUBTABLES',      'subtables');
    define('FM_TITLE',          'title');