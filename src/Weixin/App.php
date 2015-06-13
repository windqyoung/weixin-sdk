<?php


namespace Chuntent\Extension\Tools\Weixin;


/**
 * 保存微信的appid, appsecret的对象
 * @author windq
 * $Id: App.php 14650 2015-06-11 06:42:04Z yangfeng $
 */
class App
{

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $appSecret;

    /**
     * @throws Exception
     * @return App
     */
    public static function createDefault()
    {
        $obj = new static();
        if (! defined('WEIXIN_APPID'))
        {
            throw new Exception('请设置常量WEIXIN_APPID');
        }
        $obj->setAppId(WEIXIN_APPID);

        if (! defined('WEIXIN_APPSECRET'))
        {
            throw new Exception('请设置常量WEIXIN_APPSECRET');
        }
        $obj->setAppSecret(WEIXIN_APPSECRET);

        return $obj;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @return App
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return App
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
        return $this;
    }

}
