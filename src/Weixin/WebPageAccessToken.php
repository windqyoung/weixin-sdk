<?php


namespace Chuntent\Extension\Tools\Weixin;

/**
 * 注意, 此token仅用于网页授权
 * 用户登录每次的code只有5分种有效期.
 *
 * {
 *    "access_token":"ACCESS_TOKEN",
 *    "expires_in":7200,
 *    "refresh_token":"REFRESH_TOKEN",
 *    "openid":"OPENID",
 *    "scope":"SCOPE",
 *    "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
 * }
 */
class WebPageAccessToken extends Base
{
    private $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid={{APPID}}&secret={{SECRET}}&code={{CODE}}&grant_type=authorization_code';

    /**
     * 此code为一次性, 一次即失效.
     */
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function getOpenId()
    {
        return $this->getResponse()->getOpenId();
    }

    public function getAccessToken()
    {
        return $this->getResponse()->getAccessToken();
    }

    public function getRequestUrl()
    {
        return strtr($this->url, [
            '{{APPID}}' => $this->getApp()->getAppId(),
            '{{SECRET}}' => $this->getApp()->getAppSecret(),
            '{{CODE}}' => $this->code,
        ]);
    }
}
