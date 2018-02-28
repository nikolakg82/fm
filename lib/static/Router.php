<?php
/**
 * Created by PhpStorm.
 * User: IMS-WS01
 * Date: 2/24/2018
 * Time: 7:16 PM
 */

namespace fm\lib\help;


use cms\CMS;
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
            foreach($arrRoutes as $strRoute => $arrRoute)
            {
                if($strRoute == "/")
                {
                    if($strPath == "/")
                    {
                        if(isset($arrRoutes[$strRoute][FM::requestMethod()]))
                            $arrReturn = $arrRoutes[$strRoute][FM::requestMethod()];

                        break;
                    }
                }
                else
                {
                    $strPath .= "/" . CMS::$viewFormat;

//                    var_dump(self::generateRegex($strRoute));
//                    var_dump($strPath);
//
//                    $str1 = "/aktivnosti/lorem-ipsum/html";
//                    $strpatern = "~\A\/json|html+\z~";

                    preg_match(self::generateRegex($strRoute), $strPath, $matches);

var_dump(self::generateRegex($strRoute));
                    if(isset($matches[0]) && $matches[0] == $strPath)
                    {
                        if(isset($arrRoutes[$strRoute][FM::requestMethod()]))
                            $arrReturn = $arrRoutes[$strRoute][FM::requestMethod()];

                        break;
                    }
                }
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
        $strRegex = '~\A';

        //@TODO - ovde treba da se hvata i get
        //@TODO - generisati regex za {view}

        $strRoute = Stringer::subStr($strRoute, 1);
        $arrRoute = Stringer::explode($strRoute,"/");

        if(!empty($arrRoute))
        {
            foreach($arrRoute as $strRouteParam)
            {
                $arrParamsData = self::getParamsData($strRouteParam);

                if($arrParamsData['var'])
                {
                    if(isset($arrParamsData['values']))
                    {
                        foreach ($arrParamsData['values'] as $strValue)
                            $strRegex .= "\/$strValue+|";

                        $strRegex = Stringer::subStr($strRegex, 0, -1);
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

        $strRegex .= '\Z~';

        return $strRegex;
    }
}