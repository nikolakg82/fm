<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 4/21/2016
 * Time: 3:09 PM
 */

namespace fm\lib\help;

class Image
{
    /**
     * Get image size and image type
     *
     * @param string $strPath - Path to the image
     * @param null|array $mixImageInfo
     * @return null|array
     */
    public static function getImageSize($strPath, $mixImageInfo = null)
    {
        $mixReturn = null;

        if(File::exists($strPath))
        {
            $arrData = getimagesize($strPath, $mixImageInfo);

            if(isset($arrData))
            {
                $mixReturn['width'] = $arrData[0];
                $mixReturn['height'] = $arrData[1];
                $mixReturn['type'] = $arrData[2];
            }
        }

        return $mixReturn;
    }

    /**
     * Create an image
     *
     * @param string $strDestinationFolder - Destination folder of new image
     * @param string $strFileName - Name of new image
     * @param string $strSourcePath - Path of source image
     * @param int $intFileType - Type of image
     * @param int $intWidth - With of new image
     * @param int $intHeight - Height of new image
     * @param int $intPositionStartX - Start x position of source image
     * @param int $intPositionStartY - Start Y position of source image
     * @param int $intPositionEndX - End x position of source image
     * @param int $intPositionEndY - End y position of source image
     * @return int
     */
    public static function createImage($strDestinationFolder, $strFileName, $strSourcePath, $intFileType, $intWidth, $intHeight, $intPositionStartX, $intPositionStartY, $intPositionEndX, $intPositionEndY)
    {
        $intReturn = 1;

        if(File::isDir($strDestinationFolder))
        {
            $objDestImg = imagecreatetruecolor($intWidth, $intHeight);

            if ($intFileType == 1)
            {
                $objSrcImg = imagecreatefromgif($strSourcePath);
                imagecopyresampled($objDestImg, $objSrcImg, 0, 0, $intPositionStartX, $intPositionStartY, $intWidth, $intHeight, $intPositionEndX, $intPositionEndY);
                imagegif($objDestImg, $strDestinationFolder . "/" . $strFileName);
            }
            elseif ($intFileType == 2)
            {

                $objSrcImg = imagecreatefromjpeg($strSourcePath);
                imagecopyresampled($objDestImg, $objSrcImg, 0, 0, $intPositionStartX, $intPositionStartY, $intWidth, $intHeight, $intPositionEndX, $intPositionEndY);
                imagejpeg($objDestImg, $strDestinationFolder . "/" . $strFileName);
            }
            elseif ($intFileType == 3)
            {
                $objSrcImg = imagecreatefrompng($strSourcePath);
                imagecopyresampled($objDestImg, $objSrcImg, 0, 0, $intPositionStartX, $intPositionStartY, $intWidth, $intHeight, $intPositionEndX, $intPositionEndY);
                imagepng($objDestImg, $strDestinationFolder . "/" . $strFileName);
            }
            else
                $intReturn = 3;

            imagedestroy($objDestImg);
            imagedestroy($objSrcImg);
        }
        else
            $intReturn = 2;

        return $intReturn;
    }

    /**
     * Create cropped image from original image
     *
     * @param string $strDestinationFolder - Destination folder of new image
     * @param string $strFileName - Name of new image
     * @param string $strSourcePath - Path of source image
     * @param int $intCropWidth - New image width
     * @param int $intCropHeight - New image height
     * @param null|array $arrPosition - Position of destination image for crop
     * @return int
     */
    public static function createCrop($strDestinationFolder, $strFileName, $strSourcePath, $intCropWidth, $intCropHeight, $arrPosition = null)
    {
        $intReturn = 4;

        $arrImageData = self::getImageSize($strSourcePath);

        if(isset($arrImageData))
        {
            if(!(isset($arrPosition)))
                $arrPosition = self::createCropPosition($arrImageData['width'], $arrImageData['height'], $intCropWidth, $intCropHeight);

            $intReturn = self::createImage($strDestinationFolder, $strFileName, $strSourcePath, $arrImageData['type'], $intCropWidth, $intCropHeight, $arrPosition['start_x'],
                                                $arrPosition['start_y'], $arrPosition['end_x'], $arrPosition['end_y']);
        }

        return $intReturn;
    }

    /**
     * Creating parameters for automatically image cropping
     *
     * @param $intImageWidth - Original image width
     * @param $intImageHeight - Original image height
     * @param $intCropWidth - Cropped image width
     * @param $intCropHeight - Cropped image height
     * @return mixed
     */
    public static function createCropPosition($intImageWidth, $intImageHeight, $intCropWidth, $intCropHeight)
    {
        $arrReturn['start_x'] = 0;
        $arrReturn['start_y'] = 0;
        $arrReturn['end_x'] = $intCropWidth;
        $arrReturn['end_y'] = $intCropHeight;

        if($intImageWidth > $intCropWidth && $intImageHeight > $intCropHeight)
        {
            $ratioWidth = $intImageWidth / $intCropWidth;

            $ratioHeight = $intImageHeight / $intCropHeight;

            $ratio = $ratioWidth;

            if($ratioHeight < $ratioWidth)
                $ratio = $ratioHeight;

            $tempWidth = $intCropWidth * $ratio;
            $tempHeight = $intCropHeight * $ratio;

            $tempWidth = Numeric::intVal($tempWidth);
            $tempHeight = Numeric::intVal($tempHeight);

            $tempStartPositionX = ($intImageWidth - $tempWidth) / 2;
            $tempStartPositionY = ($intImageHeight - $tempHeight) / 2;

            $arrReturn['start_x'] = Numeric::intVal($tempStartPositionX);
            $arrReturn['start_y'] = Numeric::intVal($tempStartPositionY);

            $arrReturn['end_x'] = $tempWidth;
            $arrReturn['end_y'] = $tempHeight;
        }

        return $arrReturn;
    }
}