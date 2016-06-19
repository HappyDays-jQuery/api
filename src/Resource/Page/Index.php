<?php

namespace JqueryTokyo\Api\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /**
     * @param string $name
     * @return $this
     */
    public function onGet($name = 'BEAR.Sunday')
    {
        $this['greeting'] = 'Hello ' . $name;

        return $this;
    }
}
