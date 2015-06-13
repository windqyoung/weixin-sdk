<?php

namespace Chuntent\Extension\Tools\Weixin;


/**
 * 容错日志对象
 * 在微信模块里, 使用的日志系统是Monolog, 如果不提供这个对象, 那使用本类代替
 *
 * @author windq
 * $Id: Logger.php 14650 2015-06-11 06:42:04Z yangfeng $
 */
class Logger
{
    public function alert($message, array $context = array())
    {
    }

    public function critical($message, array $context = array())
    {
    }

    public function debug($message, array $context = array())
    {
    }

    public function emergency($message, array $context = array())
    {
    }

    public function error($message, array $context = array())
    {
    }

    public function info($message, array $context = array())
    {
    }

    public function log($level, $message, array $context = array())
    {
    }

    public function notice($message, array $context = array())
    {
    }

    public function warning($message, array $context = array())
    {
    }
}
