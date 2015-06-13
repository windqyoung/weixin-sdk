<?php


namespace Chuntent\Extension\Tools\Weixin;


/**
 * 获取微信的access_token, 此类有缓存. 微信文档也要求缓存
 * 因为这个数据在微信那边有次数限制
 * @author windq
 *
 * {"errcode":40001,"errmsg":"invalid credential, access_token is invalid or not latest"}
 * {"access_token":"ElVk3KP7CaQ41lWAZu4yqWZEj5oGth1OZlvJzq2A_1du9o21hDxZPyVkNyTBtfLCF73frWfvWlKwbndnGdnKDL52k8ApGfea8WQVVaBOeAQ","expires_in":7200}
 */
class AccessToken extends Base
{

    private $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={{APPID}}&secret={{APPSECRET}}';

    public function getToken()
    {
        return $this->getResponse()->getAccessToken();
    }

    /**
     * @return string
     */
    public function getRedisKey()
    {
        return sprintf('weixin.access_token.%s.%s', md5(__CLASS__), $this->getApp()->getAppId());
    }

    public function getRequestUrl()
    {
        return strtr($this->url, [
            '{{APPID}}' => $this->getApp()->getAppId(),
            '{{APPSECRET}}' => $this->getApp()->getAppSecret(),
        ]);
    }
}
