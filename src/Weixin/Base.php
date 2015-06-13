<?php


namespace Chuntent\Extension\Tools\Weixin;


use Chuntent\Extension\Tools\Cache\RedisAwareTrait;


class Base
{
    use RedisAwareTrait;

    /**
     * @var App
     */
    private $app;

    /**
     * @return App
     */
    public function getApp()
    {
        if ($this->app === null)
        {
            $this->app = App::createDefault();
        }

        return $this->app;
    }


    public function setApp(App $app)
    {
        $this->app = $app;
        return $this;
    }

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * @return \Monolog\Logger
     */
    public function getLogger()
    {
        if ($this->logger === null)
        {
            $this->logger = new Logger(); // 这个对象啥也不做, 只是保证程序不出错.
        }

        return $this->logger;
    }
    public function setLogger($log)
    {
        $this->logger = $log;
        return $this;
    }


    private $cache = false;

    /**
     * @return boolean
     */
    public function isCache()
    {
        return $this->cache;
    }
    public function setCache($cache)
    {
        $this->cache = $cache;
        return $this;
    }


    ///////////////////////////////////////////////////////////////////////
    // RESPONSE {{{

    /**
     * @return Response
     */
    public function getResponseByUrl($url)
    {
        $res = Response::createByJsonStr($this->httpGetRequest($url));
        $res->checkErrorAndException();

        return $res;
    }

    public function httpGetRequest($url)
    {
        $rs = file_get_contents($url);
        $this->getLogger()->debug(sprintf('HTTP(GET)请求: %s, %s', $url, $rs));
        return $rs;
    }

    /**
     * @var Response
     */
    private $response;

    /**
     * @return Response
     */
    public function getResponse()
    {
        if ($this->response)
        {
            return $this->response;
        }

        return $this->response = $this->getResponseFromRemote();
    }

    /**
     * 远端, 包括本地的缓存和QQ服务器
     * @return Response
     */
    private function getResponseFromRemote()
    {
        // 从缓存中取
        if ($this->isCache() && $cacheData = $this->getFromCache())
        {
            return $cacheData;
        }

        // https取
        return $this->getFromQQ();
    }

    /**
     * @return Response
     */
    private function getFromCache()
    {
        $redisStr = $this->getRedis()->get($rkey = $this->getRedisKey());

        $cache = unserialize($redisStr);

        if ($cache instanceof CacheObjectInterface && $cache->isValid())
        {
            $this->getLogger()->debug(sprintf( '从Redis中获取到: %s ==> %s', $rkey, $redisStr));
            return new Response($cache->getData());
        } else
        {
            $this->getLogger()->debug(sprintf( '从Redis中获取, 无效, %s ==> %s', $rkey, $redisStr));
        }
    }

    /**
     * @return Response
     */
    private function getFromQQ()
    {
        /**
         * @var $res Response
         */
        $res = $this->getResponseByUrl($this->getRequestUrl());

        if ($this->isCache())
        {
            $cache = new CacheObjectExpiresIn($res->getData());
            $this->getRedis()->set($rkey = $this->getRedisKey(), $save = serialize($cache));
            $this->getLogger()->debug(sprintf('Redis数据已保存: %s <== %s', $rkey, $save));
        } else
        {
            $this->getLogger()->debug(sprintf('从QQ获取到数据, 不缓存: %s', $res->getRawData()));
        }

        return $res;
    }

    /**
     * @return string
     */
    protected function getRedisKey()
    {
        throw new Exception('请实现此方法: ' . __METHOD__);
    }

    protected function getRequestUrl()
    {
        throw new Exception('请实现此方法: ' . __METHOD__);
    }



    /**
     * @return Response
     */
    public function postResponseByUrl($url, $body)
    {
        $res = Response::createByJsonStr($this->httpPostRequest($url, $body));
        $res->checkErrorAndException();

        return $res;
    }

    public function httpPostRequest($url, $body)
    {
        $options = [
            'http' => [
                'method' => 'POST',
                'content' => $body,
            ],
        ];

        $context = stream_context_create($options);
        $rs = file_get_contents($url, false, $context);
        $this->getLogger()->debug(sprintf('HTTP(POST)请求: %s, %s, %s', $url, $body, $rs));
        return $rs;
    }


    public function postResponse($body)
    {
        return $this->postResponseByUrl($this->postRequestUrl(), $body);
    }

    public function postRequestUrl()
    {
        throw new Exception('请实现此方法: ' . __METHOD__);
    }

    // RESPONSE }}}
    ////////////////////////////////////////////////////////////////////////

}
