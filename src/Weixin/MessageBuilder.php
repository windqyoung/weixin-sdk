<?php


namespace Chuntent\Extension\Tools\Weixin;


class MessageBuilder
{

    private $data = array();

    public function add($key, $value, $isRaw = false)
    {
        $this->data[] = array($key, $value, $isRaw);
        return $this;
    }

    public function ToUserName($value)
    {
        return $this->add('ToUserName', $value);
    }

    public function FromUserName($value)
    {
        return $this->add('FromUserName', $value);
    }

    public function CreateTime($value)
    {
        return $this->add('CreateTime', $value);
    }

    public function MsgType($value)
    {
        return $this->add('MsgType', $value);
    }

    public function Content($value)
    {
        return $this->add('Content', $value);
    }


    public function asXML()
    {
        $w = new \XMLWriter();
        $w->openMemory();

        $w->startDocument();
        $w->startElement('xml');

        foreach ($this->data as $one)
        {
            if ($one[2])
            {
                $w->startElement($one[0]);
                $w->writeRaw($one[1]);
                $w->endElement();
            } else
            {
                $w->writeElement($one[0], $one[1]);
            }
        }

        $w->endElement();
        $w->endDocument();

        $this->data = []; // 清空, 以备下次使用

        return $w->outputMemory();
    }


    public function Image($MediaId)
    {
        $w = new \XMLWriter();
        $w->openMemory();

        $w->writeElement('MediaId', $MediaId);

        $this->add('Image', $w->outputMemory(), true);
    }

    public function Voice($MediaId)
    {
        $w = new \XMLWriter();
        $w->openMemory();

        $w->writeElement('MediaId', $MediaId);

        $this->add('Voice', $w->outputMemory(), true);
    }
}
