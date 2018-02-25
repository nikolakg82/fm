<?php
/**
 * Created by PhpStorm.
 * User: IMS-WS01
 * Date: 2/24/2018
 * Time: 7:16 PM
 */

namespace fm\lib\help;


use fm\FM;

class Router
{
    /**
     * @var array ('route_path_route_method' => array(
     *                      'path'          => '',
     *                      'controller'    => 'controller_key',
     *                      'function'      => 'controller_method_name',
     *                      'method'        => 'POST|GET|DELETE|PUT'
     *              ));
     */
    protected static $routes;

    public static function addRoute($strControllerName, $strRoutePath, $strFunctionName, $strMethod)
    {
        if(self::isRouteExist($strControllerName, $strRoutePath, $strMethod))
            throw new \Exception("Route $strRoutePath and method $strMethod already exist.");

        self::$routes[$strControllerName][$strRoutePath][$strMethod] = array(
            'function'  => $strFunctionName,
        );
    }

    public static function isRouteExist($strControllerName, $strRoutePath, $strMethod)
    {
        return isset(self::$routes[$strControllerName][$strRoutePath][$strMethod]);
    }

    public static function getRoutesFromController($strController)
    {
        return isset(self::$routes[$strController]) ? self::$routes[$strController] : null;
    }

    public static function getRouteDetails($strController, $strPath)
    {
        $arrRoutes = self::getRoutesFromController($strController);

        $arrReturn = null;

        if(isset($arrRoutes))
        {
            if($strPath == "/")
            {
                if(isset($arrRoutes[$strPath][FM::requestMethod()]))
                    $arrReturn = $arrRoutes[$strPath][FM::requestMethod()];
            }
            else
            {

            }
        }

        return $arrReturn;
    }
}