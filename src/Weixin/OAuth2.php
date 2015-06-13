<?php


namespace Chuntent\Extension\Tools\Weixin;


/**
 * 微信在回跳的时候, 会带两参数: code=xxx&state=yyy
 * code是临时值, 应该随时在变.
 * 在两个地址中, 都会带这两参数. 所不同的只是在用户明确授权以后, 可以通过此code获取用户信息.
 */
class OAuth2 extends Base
{
    private $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid={{APPID}}&redirect_uri={{REDIRECT_URI}}&response_type=code&scope={{SCOPE}}&state={{STATE}}#wechat_redirect';

    const SCOPE_OPENID      = 'snsapi_base';
    const SCOPE_USERINFO    = 'snsapi_userinfo';

    public function getOpenIdUrl($redirectUri, $state)
    {
        $url = strtr($this->url, [
            '{{APPID}}' => $this->getApp()->getAppId(),
            '{{REDIRECT_URI}}' => urlencode($redirectUri),
            '{{SCOPE}}' => self::SCOPE_OPENID,
            '{{STATE}}' => $state, // 微信回跳的时候, 会带上此参数.
        ]);

        return $url;
    }

    public function getUserInfoUrl($redirectUri, $state)
    {
        $url = strtr($this->url, [
            '{{APPID}}' => $this->getApp()->getAppId(),
            '{{REDIRECT_URI}}' => urlencode($redirectUri),
            '{{SCOPE}}' => self::SCOPE_USERINFO,
            '{{STATE}}' => $state,
        ]);

        return $url;
    }
}
