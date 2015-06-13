<?php


namespace Chuntent\Extension\Tools\Weixin;

class JssdkSignature
{
    private $jsapiTicket;
    private $url;
    private $noncestr;
    private $timestamp;


    public function __construct($jsapiTicket, $url = '', $noncestr = '', $timestamp = 0)
    {
        $this->jsapiTicket = $jsapiTicket;
        $this->url = $url ?: $this->genUrl();
        $this->noncestr = $noncestr ?: $this->genNoncestr();
        $this->timestamp = $timestamp ?: time();
    }

    private function genUrl()
    {
        $s = $_SERVER;
        return sprintf('http://%s%s', $s['HTTP_HOST'], $s['REQUEST_URI']);
    }

    private function genNoncestr()
    {
        $str = md5(mt_rand(1, 999999) . uniqid());
        return substr($str, -5);
    }
    public function getNoncestr()
    {
        return $this->noncestr;
    }
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getSig()
    {
        $str = "jsapi_ticket={$this->jsapiTicket}&noncestr={$this->noncestr}&timestamp={$this->timestamp}&url={$this->url}";
        return sha1($str);
    }

}
