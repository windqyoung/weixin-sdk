<?php


namespace Chuntent\Extension\Tools\Weixin;


class CacheObjectExpiresIn implements CacheObjectInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $timestamp;

    public function __construct($data, $timestamp = null)
    {
        $this->data = $data;

        $this->timestamp = $timestamp ?: time();
    }

    public function isValid()
    {
        return $this->data && (time() - $this->timestamp < $this->data['expires_in']);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

}
