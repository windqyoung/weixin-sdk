<?php


namespace Chuntent\Extension\Tools\Weixin;


class Message
{

    /**
     * @var \SimpleXMLElement
     */
    private $simpleXml;

    public function __construct($simpleXml)
    {
        $this->simpleXml = $simpleXml;
    }

    /**
     * @param string $xml
     * @throws \Chuntent\Extension\Tools\Weixin\Exception
     * @return \Chuntent\Extension\Tools\Weixin\Message
     */
    public function createByXmlString($xml)
    {
        $simple = simplexml_load_string($xml);

        if (empty($simple))
        {
            $e = new Exception('xml文件错误');
            $e->setData($xml);
            throw $e;
        }

        $type = (string)$simple->MsgType;
        $class = __CLASS__ . ucfirst($type);

        if (class_exists($class))
        {
            return new $class($simple);
        } else
        {
            return new self($simple);
        }
    }


    /**
     * @return \SimpleXMLElement
     */
    public function getSimpleXml()
    {
        return $this->simpleXml;
    }

    public function getToUserName()
    {
        return (string) $this->simpleXml->ToUserName;
    }

    public function getFromUserName()
    {
        return (string) $this->simpleXml->FromUserName;
    }

    public function getCreateTime()
    {
        return (string) $this->simpleXml->CreateTime;
    }

    public function getMsgType()
    {
        return (string) $this->simpleXml->MsgType;
    }

    public function getContent()
    {
        return (string) $this->simpleXml->Content;
    }

    public function getMsgId()
    {
        return (string) $this->simpleXml->MsgId;
    }

    public function isTypeOf($type)
    {
        return strcasecmp($this->getMsgType(), $type) === 0;
    }

    public function getMediaId()
    {
        return (string) $this->simpleXml->MediaId;
    }

}
