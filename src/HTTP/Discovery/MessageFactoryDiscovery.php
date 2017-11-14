<?php

namespace PhpHttpRpc\HTTP\Discovery;

use Http\Message\MessageFactory as MessageFactoryInterface;
use PhpHttpRpc\HTTP\MessageFactory;

class MessageFactoryDiscovery
{
    /**
     * @return MessageFactoryInterface
     *
     * @todo make this a bit more flexible
     */
    public static function find()
    {
        return new MessageFactory();
    }
}
