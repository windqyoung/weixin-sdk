<?php



namespace Chuntent\Extension\Tools\Weixin;



/**
 * 微信中心类
 * @author windq
 *
 */
class Weixin extends Base
{

    public function __construct($cache)
    {
        $this->setCache($cache);
    }

    /**
     * @var AccessToken
     */
    private $accessToken;

    /**
     * @return string
     */
    public function getAccessToken()
    {
        if ($this->accessToken === null)
        {
            $this->accessToken = $at = new AccessToken();
            $at->setApp($this->getApp())
                ->setLogger($this->getLogger())
                ->setCache($this->isCache())
            ;
        }

        return $this->accessToken->getToken();
    }


    private $ipList;
    /**
     * 微信服务器ip列表
     */
    public function getCallbackIp()
    {
        if ($this->ipList === null)
        {
            $il = $this->ipList = new IpList($this->getAccessToken());
            $il->setLogger($this->getLogger());
        }

        return $this->ipList->get();
    }

    /**
     * 从$_GET和Body中取数据, 解析消息
     */
    public function parseRequestMessage()
    {
        $xml = file_get_contents('php://input');
        $this->getLogger()->debug(sprintf('接收到xml: %s, GET数据: %s', $xml, var_export($_GET, true)));
        return $this->parseMessage($xml, $_GET);
    }

    /**
     * 解析一段xml, 并验证签名
     * @param string $xml
     * @param array $sigArray
     */
    public function parseMessage($xml, $sigArray)
    {
        $ms = new MessageSignature();
        $ms->checkArrayException($sigArray);

        return Message::createByXmlString($xml);
    }


    /**
     * 获取相应用户的信息
     * @param string $openId
     */
    public function getUserInfo($openId)
    {
        $ui = new UserInfo($openId, $this->getAccessToken());
        $ui->setLogger($this->getLogger());

        return $ui;
    }

    /**
     * @var JsapiTicket
     */
    private $jsapiTicket;

    /**
     * @return string
     */
    public function getJsapiTicket()
    {

        if ($this->jsapiTicket === null)
        {
            $this->jsapiTicket = $jt = new JsapiTicket($this->getAccessToken());

            $jt->setLogger($this->getLogger())
                ->setCache($this->isCache())
                ->setApp($this->getApp())
            ;
        }

        return $this->jsapiTicket->getTicket();
    }


    /**
     * @return CustomMessage
     */
    public function getCustomMessage($openId)
    {
        $cm = new CustomMessage($this->getAccessToken(), $openId);
        $cm->setLogger($this->getLogger());

        return $cm;
    }


    /**
     * 此公众号的关注用户列表
     * @return FollowUser
     */
    public function getFollowUser()
    {
        $fu = new FollowUser($this->getAccessToken());
        $fu->setLogger($this->getLogger());

        return $fu;
    }

    /**
     * 用于生成用户授权的地址
     * @return OAuth2
     */
    public function getOAuth2()
    {
        $oa = new OAuth2();
        $oa->setApp($this->getApp());
        $oa->setLogger($this->getLogger());

        return $oa;
    }

    /**
     * 此对象可以直接获取到用户的openid, 如果需要详细信息, 用getWebPageUserInfo
     * @return WebPageAccessToken
     */
    public function getWebPageAccessToken($code)
    {
        $wpat = new WebPageAccessToken($code);
        $wpat->setApp($this->getApp())
            ->setLogger($this->getLogger());

        return $wpat;
    }

    /**
     * 获取用户授权过的详情信息
     * @return WebPageUserInfo
     */
    public function getWebPageUserInfoByWebPageAccessToken($wpat)
    {
        $wpui = new WebPageUserInfo($wpat);
        $wpui->setLogger($this->getLogger());

        return $wpui;
    }

    /**
     * 获取用户授权过的详情信息
     * @return WebPageUserInfo
     */
    public function getWebPageUserInfoByCode($code)
    {
        return $this->getWebPageUserInfoByWebPageAccessToken($this->getWebPageAccessToken($code));
    }
}
