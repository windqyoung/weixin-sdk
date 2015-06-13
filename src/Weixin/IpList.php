<?php


namespace Chuntent\Extension\Tools\Weixin;

/**
 * 微信服务器ip列表, 这个没有访问次数限制, 可以随意请求
 * @author windq
 *
 */
class IpList extends Base
{

    private $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token={{ACCESS_TOKEN}}';

    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->getResponse()->getIpList();
    }

    public function getRequestUrl()
    {
        return strtr($this->url, [
            '{{ACCESS_TOKEN}}' => $this->token,
        ]);
    }
}
