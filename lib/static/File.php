<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/21/2016
 * Time: 2:44 PM
 */
class File
{
    public static function unlink($strPath, $mixContext = null)
    {
        $intReturn = 1;
        if(self::exists($strPath))
        {
            if(unlink($strPath, $mixContext))
                $intReturn = 2;
            else
                $intReturn = 3;
        }

        return $intReturn;
    }

    public static function exists($strPath)
    {
        return file_exists($strPath);
    }

    public static function mkdir($strPath, $intPermission = "0777", $boolRecursive = false, $mixContext = null)
    {
        return mkdir($strPath, $intPermission, $boolRecursive, $mixContext);
    }

    public static function move_uploaded_file($strTmpName, $strPath)
    {
        return move_uploaded_file($strTmpName, $strPath);
    }

    public static function copy($strSourcePath, $strDestionationPath, $mixContext = null)
    {
        return copy($strSourcePath, $strDestionationPath, $mixContext);
    }

    public static function rename($strOldPath, $strNewPath, $mixContext = null)
    {
        return rename($strOldPath, $strNewPath, $mixContext);
    }

    public static function scandir($strPath, $intSort = SCANDIR_SORT_ASCENDING, $mixContext = null)
    {
        $arrData = null;

        $arrDataTemp = scandir($strPath, $intSort, $mixContext);
        if(FM::is_variable($arrDataTemp))
        {
            foreach($arrDataTemp as $key => $val)
            {
                if($val != '.' && $val != "..")
                    $arrData[] = $val;
            }
        }

        return $arrData;
    }

    public static function is_dir($strPath)
    {
        return is_dir($strPath);
    }

    public static function chmod($strPath, $intMode)
    {
        return chmod($strPath, $intMode);
    }

    public static function file_get_contents($strPath)
    {
        $mixReturn = null;

        if(self::exists($strPath))
            $mixReturn = file_get_contents($strPath);
        return $mixReturn;
    }
}