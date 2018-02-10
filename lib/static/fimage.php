<?php

/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 4/21/2016
 * Time: 3:09 PM
 */
class Fimage
{
    public static function getimagesize($strPath, $mixImageInfo = null)
    {
        $mixReturn = null;

        if(Ffile::file_exists($strPath))
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

    public static function create_image($strDestinationFolder, $strFileName, $strSourcePath, $intFileType, $intWidth, $intHeight, $intPositionStartX, $intPositionStartY, $intPositionEndX, $intPositionEndY)
    {
        $intReturn = 1;

        if(Ffile::is_dir($strDestinationFolder))
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

    public static function create_crop($strDestinationFolder, $strFileName, $strSourcePath, $intCropWidth, $intCropHeight, $arrPosition = null)
    {
        $intReturn = 1;

        $arrImageData = self::getimagesize($strSourcePath);

        if(FM::is_variable($arrImageData))
        {
            if(!(FM::is_variable($arrPosition)))
                $arrPosition = self::create_crop_position($arrImageData['width'], $arrImageData['height'], $intCropWidth, $intCropHeight);

            $intReturn = self::create_image($strDestinationFolder, $strFileName, $strSourcePath, $arrImageData['type'], $intCropWidth, $intCropHeight, $arrPosition['start_x'],
                                                $arrPosition['start_y'], $arrPosition['end_x'], $arrPosition['end_y']);
        }
        else
            $intReturn = 4;

        return $intReturn;
    }

    public static function create_crop_position($intImageWidth, $intImageHeight, $intCropWidth, $intCropHeight)
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

            $tempWidth = Finteger::intval($tempWidth);
            $tempHeight = Finteger::intval($tempHeight);

            $tempStartPositionX = ($intImageWidth - $tempWidth) / 2;
            $tempStartPositionY = ($intImageHeight - $tempHeight) / 2;

            $arrReturn['start_x'] = Finteger::intval($tempStartPositionX);
            $arrReturn['start_y'] = Finteger::intval($tempStartPositionY);

            $arrReturn['end_x'] = $tempWidth;
            $arrReturn['end_y'] = $tempHeight;
        }

        return $arrReturn;
    }
}