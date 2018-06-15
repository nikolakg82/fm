<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/21/2016
 * Time: 2:44 PM
 */

namespace fm\lib\help;

class File
{
    /**
     * Delete file
     *
     * @param string $strPath - Path of the file
     * @param null $mixContext
     * @return int - Status(1-file don't exist, 2-file deleted, 3-file not deleted)
     */
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

    /**
     * Check if file exist
     *
     * @param string $strPath - Path of the file
     * @return bool
     */
    public static function exists($strPath)
    {
        return file_exists($strPath);
    }

    /**
     * Make directory
     *
     * @param string $strPath - Path of the folder
     * @param string $intPermission - Permission of the folder
     * @param bool $boolRecursive - Allows the creation of nested directories specified in the pathname.
     * @param null $mixContext
     * @return bool
     */
    public static function makeDir($strPath, $intPermission = "0777", $boolRecursive = false, $mixContext = null)
    {
        return mkdir($strPath, $intPermission, $boolRecursive, $mixContext);
    }

    /**
     * Upload file from HTTP POST
     *
     * @param string $strTmpName - The filename of the uploaded file.
     * @param string $strPath - The destination of the moved file.
     * @return bool
     */
    public static function moveUploadedFile($strTmpName, $strPath)
    {
        return move_uploaded_file($strTmpName, $strPath);
    }

    /**
     * Copy file
     *
     * @param string $strSourcePath - Resources path of file
     * @param string $strDestinationPath - Destination path of file
     * @param null $mixContext
     * @return bool
     */
    public static function copy($strSourcePath, $strDestinationPath, $mixContext = null)
    {
        return copy($strSourcePath, $strDestinationPath, $mixContext);
    }

    /**
     * Rename file moving it between directories if necessary
     *
     * @param string $strOldPath - Path of old file
     * @param string $strNewPath - Path of new file
     * @param null $mixContext
     * @return bool
     */
    public static function rename($strOldPath, $strNewPath, $mixContext = null)
    {
        return rename($strOldPath, $strNewPath, $mixContext);
    }

    /**
     * List files and directories of one directory
     *
     * @param string $strPath - Path of the directory
     * @param int $intSort - How to sort files and directories
     * @param null $mixContext
     * @return array|null
     */
    public static function scanDir($strPath, $intSort = SCANDIR_SORT_ASCENDING, $mixContext = null)
    {
        $arrData = null;

        $arrDataTemp = scandir($strPath, $intSort, $mixContext);

        if(isset($arrDataTemp))
        {
            foreach($arrDataTemp as $key => $val)
            {
                if($val != '.' && $val != "..")
                    $arrData[] = $val;
            }
        }

        return $arrData;
    }

    /**
     * Check if directory exist
     *
     * @param string $strPath - Path of directory
     * @return bool
     */
    public static function isDir($strPath)
    {
        return is_dir($strPath);
    }

    /**
     * Change permission of directory
     *
     * @param string $strPath - Path of directory
     * @param int $intMode - Permission mode
     * @return bool
     */
    public static function chmod($strPath, $intMode)
    {
        return chmod($strPath, $intMode);
    }

    /**
     * Get content of the file
     *
     * @param string $strPath - Path of the file
     * @return bool|null|string
     */
    public static function fileGetContents($strPath)
    {
        $mixReturn = null;

        if(self::exists($strPath))
            $mixReturn = file_get_contents($strPath);

        return $mixReturn;
    }
}