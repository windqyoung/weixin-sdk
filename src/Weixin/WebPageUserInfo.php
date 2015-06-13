<?php


namespace Chuntent\Extension\Tools\Weixin;

class WebPageUserInfo extends UserInfo
{
    private $url = 'https://api.weixin.qq.com/sns/userinfo?access_token={{ACCESS_TOKEN}}&openid={{OPENID}}&lang=zh_CN';

    private $wpat;

    public function __construct(WebPageAccessToken $wpat)
    {
        $this->wpat = $wpat;
    }

    public function getRequestUrl()
    {
        return strtr($this->url, [
            '{{ACCESS_TOKEN}}' => $this->wpat->getAccessToken(),
            '{{OPENID}}' => $this->wpat->getOpenId(),
        ]);
    }
}
