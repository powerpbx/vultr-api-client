<?php

namespace Vultr\ApiCall;

use Vultr\Adapter\AdapterInterface;

abstract class AbstractApiCall
{
    const ENDPOINT = 'https://api.vultr.com/v1/';
    const VERSION  = '1.0';
    const AGENT    = 'Vultr.com PHP API Client';

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }
}
