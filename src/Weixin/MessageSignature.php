<?php


namespace Chuntent\Extension\Tools\Weixin;

class MessageSignature
{

    private $token;

    public function __construct($token = null)
    {
        if (empty($token) && !defined('WEIXIN_TOKEN'))
        {
            throw new Exception('请输入token值');
        }

        $this->token = $token ?: WEIXIN_TOKEN;
    }

    /**
     * $d = array (
     *     'signature' => '3232ee11a26fe3810cb3bcba3af8e78fa7909932',
     *     'timestamp' => '1433842357',
     *     'nonce' => '1605429331',
     * );
     * @param array $array
     * @return boolean
     */
    public function checkArray($array)
    {
        $calced = $this->calcSig($array);
        return $calced === $array['signature'];
    }

    /**
     * @return string
     */
    public function calcSig($array)
    {
        $data = [$array['timestamp'], $array['nonce'], $this->token];
        sort($data, SORT_STRING);
        return sha1(implode('', $data));
    }

    /**
     * @throws Exception
     */
    public function checkArrayException($array)
    {
        if (false === $this->checkArray($array))
        {
            $e = new Exception('签名检查失败');
            $e->setData($array);
            throw $e;
        }
    }
}
