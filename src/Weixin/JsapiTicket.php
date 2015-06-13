<?php


namespace Chuntent\Extension\Tools\Weixin;



/**
 * {"errcode":0,"errmsg":"ok","ticket":"sM4AOVdWfPE4DxkXGEs8VOyg37G4e6fECnZP5Wn0BwCU7UrgHnvnxq85FWrcSLGqacp-v0XPDfLv-FrP6GlM5g","expires_in":7200}
 * @return Response
 */
class JsapiTicket extends Base
{

    private $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={{ACCESS_TOKEN}}&type=jsapi';

    /**
     * @var string
     */
    private $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getTicket()
    {
        return $this->getResponse()->getTicket();
    }

    /**
     * @return string
     */
    public function getRedisKey()
    {
        return sprintf('weixin.jsapi_ticket.%s.%s', md5(__CLASS__), $this->getApp()->getAppId());
    }

    public function getRequestUrl()
    {
        return strtr($this->url, [
            '{{ACCESS_TOKEN}}' => $this->accessToken,
        ]);
    }
}
