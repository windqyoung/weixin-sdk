<?php


namespace Chuntent\Extension\Tools\Weixin;

class Exception extends \Exception
{

    private $data;
    public function getData()
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
