<?php


namespace Chuntent\Extension\Tools\Weixin;

/**
 * Array
 * (
 *     [total] => 2
 *     [count] => 2
 *     [data] => Array
 *         (
 *             [openid] => Array
 *                 (
 *                     [0] => oyrzZsqcou3RNUY7btQWr6Q0Yjg0
 *                     [1] => oyrzZsvts57lelTE6VWc-lly_wPg
 *                 )
 *
 *         )
 *
 *     [next_openid] => oyrzZsvts57lelTE6VWc-lly_wPg
 * )
 *
 * @author windq
 *
 */
class FollowUserResponse extends Response
{
    public function getNextOpenid()
    {
        return $this->get('next_openid');
    }

    public function getOpenIds()
    {
        return $this->get('data')['openid'];
    }

    public function getTotal()
    {
        return $this->get('total');
    }

    public function getCount()
    {
        return $this->get('count');
    }
}
