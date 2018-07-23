<?php
/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 2/24/2018
 * Time: 7:16 PM
 */

namespace fm\lib\help;

use cms\CMS;
use fm\FM;

/**
 * Class Router
 * @package fm\lib\help
 */
class Router
{
    /**
     * @TODO - Prepraviti primer strukture niza
     * @var array ('route_path_route_method' => array(
     *                      'path'          => '',
     *                      'controller'    => 'controller_key',
     *                      'function'      => 'controller_method_name',
     *                      'method'        => 'POST|GET|DELETE|PUT'
     *              ));
     */
    protected static $routes;

    /**
     * Add route to register
     *
     * @param $strControllerName - Controller of the router
     * @param $strRoutePath - Route
     * @param $strFunctionName - Function of the controller to be started
     * @param $strMethod - Method request
     * @param int $intPermission - Permission od the route
     * @throws \Exception
     */
    public static function addRoute($strControllerName, $strRoutePath, $strFunctionName, $strMethod, $intPermission = CMS_GUEST | CMS_USER | CMS_ADMIN)
    {
        if(self::isRouteExist($strControllerName, $strRoutePath, $strMethod))
            throw new \Exception("Route $strRoutePath and method $strMethod already exist.");

        self::$routes[$strControllerName][$strMethod][$strRoutePath] = array(
            'function'  => $strFunctionName,
            'permission'=> $intPermission
        );
    }

    /**
     * Check if route exist
     *
     * @param $strControllerName - Controller of the router
     * @param $strRoutePath - Route
     * @param $strMethod - Method request
     * @return bool
     */
    public static function isRouteExist($strControllerName, $strRoutePath, $strMethod)
    {
        return isset(self::$routes[$strControllerName][$strMethod][$strRoutePath]);
    }

    /**
     * Get routes from controller and method
     *
     * @param $strController
     * @param $strMethod
     * @return null
     */
    public static function getRoutesFromController($strController, $strMethod)
    {
        return isset(self::$routes[$strController][$strMethod]) ? self::$routes[$strController][$strMethod] : null;
    }

    /**
     * Get details of route
     *
     * @param $strController
     * @param $strPath
     * @return null
     */
    public static function getRouteDetails($strController, $strPath)
    {
        $arrRoutes = self::getRoutesFromController($strController, FM::requestMethod());

        $arrReturn = null;

        $strPathMod = $strPath . "." . CMS::$viewFormat;

        if(isset($arrRoutes))
        {
            foreach($arrRoutes as $strRoute => $arrRoute)
            {
                if($strRoute == "/")
                {
                    if($strPath == "/")
                    {
                        if(isset($arrRoutes[$strRoute]))
                            $arrReturn = $arrRoutes[$strRoute];
                    }
                }
                else
                {
                    if(preg_match(self::generateRegex($strRoute), $strPathMod) >= 1)
                    {
                        if(isset($arrRoutes[$strRoute]))
                        {
                            $boolSetRouteData = true;

                            $arrRouteData = Stringer::explode($strRoute, "?");

                            if(isset($arrRouteData[0]))
                                $arrQueryParams = self::getParamsDataValue($strPathMod, $arrRouteData[0]);

                            if(isset($arrRouteData[1]))
                            {
                                $arrRouteQuery = Stringer::explode($arrRouteData[1], "&");

                                if(!empty($arrRouteQuery))
                                {
                                    foreach ($arrRouteQuery as $strQuery)
                                    {
                                        $arrQueryData = self::getParamsData($strQuery);

                                        if($arrQueryData['var'])
                                        {
                                            $arrQueryParams[$arrQueryData['name']] = Request::get($arrQueryData['name']);

                                            if(isset($arrQueryData['params'][FM_REQUIRED]) && !isset($arrQueryParams[$arrQueryData['name']]))
                                            {
                                                $boolSetRouteData = false;
                                                break;
                                            }

                                            if(isset($arrQueryData['params'][FM_INTEGER]))
                                            {
                                                if(isset($arrQueryParams[$arrQueryData['name']]))
                                                {
                                                    if(!Numeric::isNumeric($arrQueryParams[$arrQueryData['name']]))
                                                    {
                                                        $boolSetRouteData = false;
                                                        break;
                                                    }
                                                    else
                                                        $arrQueryParams[$arrQueryData['name']] = Numeric::intVal($arrQueryParams[$arrQueryData['name']]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if($boolSetRouteData)
                            {
                                $arrReturn = $arrRoutes[$strRoute];

                                if(isset($arrQueryParams))
                                    $arrReturn['params'] = $arrQueryParams;
                            }
                        }
                    }
                }

                if(isset($arrReturn))
                    break;
            }
        }

        return $arrReturn;
    }

    /**
     * Get route params data
     *
     * @param $strParam
     * @return mixed
     */
    public static function getParamsData($strParam)
    {
        $arrReturn['name'] = $strParam;
        $arrReturn['var'] = false;
        $regex = '/{(.*)}/';
        preg_match_all($regex, $strParam, $matches);

        if(!empty($matches[1]))
        {
            $arrParams = Stringer::explode($matches[1][0], "|");

            $arrReturn['name'] = $arrParams[0];
            $arrReturn['var'] = true;

            unset($arrParams[0]);

            if(!empty($arrParams))
            {
                foreach ($arrParams as $param)
                {
                    $arrParamsValue = Stringer::explode($param, ":");
                    if(isset($arrParamsValue[1]))
                    {
                        unset($arrParamsValue[0]);
                        foreach ($arrParamsValue as $strValue)
                            $arrReturn['values'][] = $strValue;
                    }
                    else
                        $arrReturn['params'][$param] = $param;
                }
            }
        }

        return $arrReturn;
    }

    public static function generateRegex($strRoute)
    {
        $strRegex = '/^';

        $strRoute = Stringer::subStr($strRoute, 1);

        $arrRoutes = Stringer::explode($strRoute, "?");

        if(isset($arrRoutes[0]))
        {
            $arrRoute = Stringer::explode($arrRoutes[0], ".");

            if(isset($arrRoute[0]))
            {
                $arrPath = Stringer::explode($arrRoute[0], "/");

                if(!empty($arrPath))
                {
                    foreach($arrPath as $strRouteParam)
                    {
                        $arrParamsData = self::getParamsData($strRouteParam);

                        if($arrParamsData['var'])
                        {
                            if(isset($arrParamsData['values']))
                            {
                                $strRegex .= "\/(";
                                foreach ($arrParamsData['values'] as $strValue)
                                    $strRegex .= "$strValue|";

                                $strRegex = Stringer::subStr($strRegex, 0, -1);

                                $strRegex .= ")";
                            }
                            else
                            {
                                if(isset($arrParamsData['params'][FM_REQUIRED]))
                                    $strRegex .= "\/";
                                else
                                    $strRegex .= "\/*";

                                if(isset($arrParamsData['params'][FM_INTEGER]))
                                    $strRegex .= "\d";
                                else
                                    $strRegex .= ".";

                                if(isset($arrParamsData['params'][FM_REQUIRED]))
                                    $strRegex .= "+";
                                else
                                    $strRegex .= "*";
                            }

                        }
                        else
                            $strRegex .= "\/" . $arrParamsData['name'];
                    }
                }
            }

            if(isset($arrRoute[1]))
            {
                $arrParamsData = self::getParamsData($arrRoute[1]);

                if(isset($arrParamsData['values']))
                {
                    $strRegex .= ".";

                    if(Arrays::count($arrParamsData['values']) > 1)
                    {
                        $strRegex .= "(";
                        foreach ($arrParamsData['values'] as $strValue)
                            $strRegex .= "$strValue|";

                        $strRegex = Stringer::subStr($strRegex, 0, -1);

                        $strRegex .= ")";
                    }
                    else
                        $strRegex .= $arrParamsData['values'][0];
                }
            }
        }

        $strRegex .= '$/';

        return $strRegex;
    }

    /**
     * Get values of params
     *
     * @param $strPath
     * @param $strRoute
     * @return null
     */
    public static function getParamsDataValue($strPath, $strRoute)
    {
        $arrReturn = null;

        $arrRoute = Stringer::explode($strRoute, ".");
        $arrPath =  Stringer::explode($strPath, ".");

        $arrRoutes = Stringer::explode($arrRoute[0], "/");
        $arrPaths =  Stringer::explode($arrPath[0], "/");

        foreach ($arrRoutes as $intKeyRouteParam => $strRouteParam)
        {
            $arrParamsData = self::getParamsData($strRouteParam);

            if($arrParamsData['var'])
            {
                $arrReturn[$arrParamsData['name']] = $arrPaths[$intKeyRouteParam];
            }
        }

        return $arrReturn;
    }
}