<?php


namespace Chuntent\Extension\Tools\Weixin;

/**
 * 微信的响应信息
 * @author windq
 * $Id: Response.php 14884 2015-06-12 07:12:24Z yangfeng $
 */
class Response
{
    private $data;

    private $rawData;

    public function __construct($data, $rawData = null)
    {
        if (empty($data) || !is_array($data))
        {
            throw new Exception('错误的数据类型');
        }

        $this->data = $data;
        $this->rawData = $rawData;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    public function getRawData()
    {
        return $this->rawData;
    }

    public function get($key, $exception = true)
    {
        if (isset($this->data[$key]))
        {
            return $this->data[$key];
        }

        if ($exception)
        {
            throw new Exception('未找到键: ' . $key);
        }
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->get('access_token');
    }

    /**
     * @return string
     */
    public function getExpiresIn()
    {
        return $this->get('expires_in');
    }

    /**
     * @return boolean
     */
    public function isError()
    {
        return isset($this->data['errcode']) && $this->data['errcode'] != 0;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->get('errmsg', false);
    }


    public function checkErrorAndException()
    {
        if ($this->isError())
        {
            $e = new Exception('微信发生错误: ' . $this->getErrorMessage());
            $e->setData($this);
            throw $e;
        }
    }

    /**
     * @param string $jsonStr
     * @return Response
     */
    public static function createByJsonStr($jsonStr)
    {
        $json = json_decode($jsonStr, true);
        return new self($json, $jsonStr);
    }


    /**
     * @return array
     */
    public function getIpList()
    {
        return $this->get('ip_list');
    }


    public function getTicket()
    {
        return $this->get('ticket');
    }


    public function getOpenId()
    {
        return $this->get('openid');
    }
}
