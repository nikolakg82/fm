<?php

/**
 * @copyright Copyright (c) 2005-2018 MSD - All Rights Reserved
 * @link http://www.nikolamilenkovic.com
 * @email info@nikolamilenkovic.com
 * @author Nikola Milenkovic info@nikolamilenkovic.com dzoni82.kg@gmail.com http://www.nikolamilenkovic.com
 * Date: 2/11/2018
 * Time: 6:13 PM
 */

namespace fm\lib\publisher;

use cms\CMS;
use cms\lib\help\ControllerLoader;
use cms\lib\help\Lang;

class Response
{
    /**
     * @var int - Default response code
     */
    protected $responseCode = 200;

    /**
     * @var array - Data for display
     */
    protected $data;

    /**
     * @var string - Path of template for display
     */
    protected $templatePath;

    /**
     * Get response code
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Get display data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get template path
     *
     * @return mixed
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * Set response code
     *
     * @param int $intResponseCode
     * @return Response
     * @TODO Add validation to check if response code valid (use 'config/responseCode.php')
     */
    public function setResponseCode($intResponseCode)
    {
        $this->responseCode = $intResponseCode;

        return $this;
    }

    /**
     * Set response data
     *
     * @param mixed
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Set template path
     *
     * @param mixed $templatePath
     * @return Response
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }

    /**
     * Call view and display data
     *
     * @return void
     */
    public function showView()
    {
        CMS::$view->assign('data', $this->getData());
        CMS::$view->display($this->getTemplatePath());

        CMS::$view->show();
    }
}