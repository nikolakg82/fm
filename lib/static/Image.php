<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/21/2016
 * Time: 3:09 PM
 */

namespace fm\lib\help;

use fm\FM;

class Image
{
    public static function getImageSize($strPath, $mixImageInfo = null)
    {
        $mixReturn = null;

        if(File::exists($strPath))
        {
            $arrData = getimagesize($strPath, $mixImageInfo);

            if(FM::is_variable($arrData))
            {
                $mixReturn['width'] = $arrData[0];
                $mixReturn['height'] = $arrData[1];
                $mixReturn['type'] = $arrData[2];
            }
        }

        return $mixReturn;
    }

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

    public static function createCrop($strDestinationFolder, $strFileName, $strSourcePath, $intCropWidth, $intCropHeight, $arrPosition = null)
    {
        $intReturn = 1;

        $arrImageData = self::getImageSize($strSourcePath);

        if(FM::is_variable($arrImageData))
        {
            if(!(FM::is_variable($arrPosition)))
                $arrPosition = self::create_crop_position($arrImageData['width'], $arrImageData['height'], $intCropWidth, $intCropHeight);

            $intReturn = self::createImage($strDestinationFolder, $strFileName, $strSourcePath, $arrImageData['type'], $intCropWidth, $intCropHeight, $arrPosition['start_x'],
                                                $arrPosition['start_y'], $arrPosition['end_x'], $arrPosition['end_y']);
        }
        else
            $intReturn = 4;

        return $intReturn;
    }

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

            $tempWidth = Numeric::intval($tempWidth);
            $tempHeight = Numeric::intval($tempHeight);

            $tempStartPositionX = ($intImageWidth - $tempWidth) / 2;
            $tempStartPositionY = ($intImageHeight - $tempHeight) / 2;

            $arrReturn['start_x'] = Numeric::intval($tempStartPositionX);
            $arrReturn['start_y'] = Numeric::intval($tempStartPositionY);

            $arrReturn['end_x'] = $tempWidth;
            $arrReturn['end_y'] = $tempHeight;
        }

        return $arrReturn;
    }
}