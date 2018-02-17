<?php

/**
 * Created by PhpStorm.
 * User: IMS-WS01
 * Date: 2/11/2018
 * Time: 6:13 PM
 */

namespace fm\lib\publisher;

class Response
{
    protected $responseCode = 200;

    protected $data;

    protected $templatePath;

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param int $intResponseCode
     *
     * @return Response
     */
    public function setResponseCode($intResponseCode)
    {
        $this->responseCode = $intResponseCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed
     *
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * @param mixed $templatePath
     *
     * @return Response
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }
}