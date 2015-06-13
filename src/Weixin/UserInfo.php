<?php

namespace Chuntent\Extension\Tools\Weixin;


/**
 *
 * 参数	说明
 * subscribe	用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息。
 * openid	用户的标识，对当前公众号唯一
 * nickname	用户的昵称
 * sex	用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
 * city	用户所在城市
 * country	用户所在国家
 * province	用户所在省份
 * language	用户的语言，简体中文为zh_CN
 * headimgurl	用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像），用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。
 * subscribe_time	用户关注时间，为时间戳。如果用户曾多次关注，则取最后关注时间
 * unionid	只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。详见：获取用户个人信息（UnionID机制）
 * remark	公众号运营者对粉丝的备注，公众号运营者可在微信公众平台用户管理界面对粉丝添加备注
 * groupid	用户所在的分组ID
 * @author windq
 * {
 *     "subscribe": 1,
 *     "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
 *     "nickname": "Band",
 *     "sex": 1,
 *     "language": "zh_CN",
 *     "city": "广州",
 *     "province": "广东",
 *     "country": "中国",
 *     "headimgurl":    "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
 *    "subscribe_time": 1382694957,
 *    "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
 *    "remark": "",
 *    "groupid": 0
 * }
 */
class UserInfo extends Base
{

    private $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token={{ACCESS_TOKEN}}&openid={{OPENID}}&lang=zh_CN';

    /**
     * @var string
     */
    private $openId;

    /**
     * @var string
     */
    private $accessToken;

    public function __construct($openId, $accessToken)
    {
        $this->openId = $openId;
        $this->accessToken = $accessToken;
    }

    public function getRequestUrl()
    {
        return strtr($this->url, [
            '{{ACCESS_TOKEN}}' => $this->accessToken,
            '{{OPENID}}' => $this->openId,
        ]);
    }

    public function get($key, $exception = true)
    {
        return $this->getResponse()->get($key, $exception);
    }

    public function getSubscribe()
    {
        $key = 'subscribe';
        return $this->get($key);
    }
    public function getOpenid()
    {
        $key = 'openid';
        return $this->get($key);
    }
    public function getNickname()
    {
        $key = 'nickname';
        return $this->get($key);
    }
    public function getSex()
    {
        $key = 'sex';
        return $this->get($key);
    }
    public function getLanguage()
    {
        $key = 'language';
        return $this->get($key);
    }
    public function getCity()
    {
        $key = 'city';
        return $this->get($key);
    }
    public function getProvince()
    {
        $key = 'province';
        return $this->get($key);
    }
    public function getCountry()
    {
        $key = 'country';
        return $this->get($key);
    }
    public function getHeadimgurl()
    {
        $key = 'headimgurl';
        return $this->get($key);
    }
    public function getSubscribeTime()
    {
        $key = 'subscribe_time';
        return $this->get($key);
    }
    public function getUnionid()
    {
        $key = 'unionid';
        return $this->get($key);
    }
    public function getRemark()
    {
        $key = 'remark';
        return $this->get($key);
    }
    public function getGroupid()
    {
        $key = 'groupid';
        return $this->get($key);
    }

    /**
     * 这个号码在关注我? 如果没关注, 什么信息也获取不到.
     */
    public function isFollowMe()
    {
        return $this->getSubscribe() == 1;
    }
}
