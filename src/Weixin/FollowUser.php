<?php


namespace Chuntent\Extension\Tools\Weixin;


class FollowUser extends Base
{
    private $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token={{ACCESS_TOKEN}}&next_openid={{NEXT_OPENID}}';

    private $accessToken;

    /**
     * 一次会取会1W个数据, 如果数据不全, 把此参数加上, 再请求
     * @var string
     */
    private $nextOpenId;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }


    public function getRequestUrl()
    {
        return strtr($this->url, [
            '{{ACCESS_TOKEN}}' => $this->accessToken,
            '{{NEXT_OPENID}}' => $this->nextOpenId,
        ]);
    }

    /**
     * 如果用户超过10000, 重复调用此方法, 最终没用户的时候, 就是取完了.
     * @return FollowUserResponse
     */
    public function get()
    {
        $res = $this->getResponseByUrl($this->getRequestUrl());

        $fres = new FollowUserResponse($res->getData(), $res->getRawData());

        $this->nextOpenId = $fres->getNextOpenid();

        return $fres;
    }

}
