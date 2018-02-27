<?php
/**
 * Created by PhpStorm.
 * User: IMS-WS01
 * Date: 2/24/2018
 * Time: 7:16 PM
 */

namespace fm\lib\help;


use fm\FM;

/**
 * Class Router
 * @package fm\lib\help
 * @TODO 1.napraviti router de parsuje i get, 2. kad u ruti postoji parametar vrednost parametra treba da se prosledi funkciji koja se poziva
 */
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

    public static function addRoute($strControllerName, $strRoutePath, $strFunctionName, $strMethod, $intPermission = CMS_GUEST | CMS_USER | CMS_ADMIN)
    {
        if(self::isRouteExist($strControllerName, $strRoutePath, $strMethod))
            throw new \Exception("Route $strRoutePath and method $strMethod already exist.");

        self::$routes[$strControllerName][$strRoutePath][$strMethod] = array(
            'function'  => $strFunctionName,
            'permission'=> $intPermission
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

                $strPath = Stringer::subStr($strPath, 1);

                $arrPath = Stringer::explode($strPath,"/");
                $arrRouteMatches = [];

                foreach($arrRoutes as $strRoute => $arrRouteData)
                {
                    $strRoute = Stringer::subStr($strRoute, 1);
                    $arrRouteExplode = Stringer::explode($strRoute, "/");


                    foreach ($arrPath as $keyPath => $valPath)
                    {
                        if(!isset($arrRouteExplode[$keyPath]))
                        {
                            if(isset($arrRouteMatches[$strRoute]))
                                unset($arrRouteMatches[$strRoute]);

                            break;
                        }

                        $arrParamsData = self::getParamsData($arrRouteExplode[$keyPath]);

                        if($arrParamsData['var'])
                        {
                            $arrRouteMatches[$strRoute] = $strRoute;

                            //@TODO svu validaciju premestiti u method validate routes
                            if(isset($arrParamsData['params'][FM_INTEGER]))
                            {
                                if(!Numeric::isNumeric($valPath))
                                {
                                    if(isset($arrRouteMatches[$strRoute]))
                                        unset($arrRouteMatches[$strRoute]);

                                    break;
                                }
                            }
                        }
                        else
                        {
                            if($arrParamsData['name'] != $valPath)
                            {
                                if(isset($arrRouteMatches[$strRoute]))
                                    unset($arrRouteMatches[$strRoute]);

                                break;
                            }
                            else
                                $arrRouteMatches[$strRoute] = $strRoute;
                        }
                    }
                }

                if(!empty($arrRouteMatches))
                {
                    $strActiveRoute = self::validateRoutes($arrPath, $arrRouteMatches);

                    if(isset($strActiveRoute))
                    {
                        if(isset($arrRoutes["/$strActiveRoute"][FM::requestMethod()]))
                            $arrReturn = $arrRoutes["/$strActiveRoute"][FM::requestMethod()];
                    }
                }

//                var_dump($arrReturn);
            }
        }

        return $arrReturn;
    }

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
                    $arrReturn['params'][$param] = $param;
            }
        }

        return $arrReturn;
    }

    public static function validateRoutes($arrPath, $arrRoutes)
    {
        $mixReturn = null;

        foreach ($arrRoutes as &$strRoute)
        {
            $arrRouteExplode = Stringer::explode($strRoute, "/");

            foreach ($arrRouteExplode as $keyRoute => $valRoute)
            {
                $arrParams = self::getParamsData($valRoute);

                if(isset($arrParams['params']))
                {
                    if(isset($arrParams['params'][FM_REQUIRED]))
                    {
                        if(!isset($arrPath[$keyRoute]))
                            unset($strRoute);
                    }
                }
            }
        }

        if(!empty($arrRoutes))
            $mixReturn = Arrays::reset($arrRoutes);

        return $mixReturn;
    }

}