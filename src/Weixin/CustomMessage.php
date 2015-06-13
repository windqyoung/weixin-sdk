<?php



namespace Chuntent\Extension\Tools\Weixin;


/**
 * 客服消息
 * @author windq
 *
 */
class CustomMessage extends Base
{
    private $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={{ACCESS_TOKEN}}';

    private $accessToken;
    private $openId;


    public function __construct($accessToken, $openId)
    {
        $this->accessToken = $accessToken;
        $this->openId = $openId;
    }

    /**
     * 给某用户发个信息, 如果没有异常, 那就是发送成功了
     * @param string $text
     * @return Response
     */
    public function sendText($text)
    {
        $data = [
            'touser' => $this->openId,
            'msgtype' => 'text',
            'text' => [
                'content' => $text,
            ],
        ];

        $json = json_encode($data);

        return $this->postResponse($json);
    }


    public function postRequestUrl()
    {
        return strtr($this->url, [
            '{{ACCESS_TOKEN}}' => $this->accessToken,
        ]);
    }
}
