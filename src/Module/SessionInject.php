<?php

namespace JqueryTokyo\Api\Module;

use Aura\Session\Session;

trait SessionInject
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Session $session
     *
     * @\Ray\Di\Di\Inject
     */
    public function setSession(Session $session = null)
    {
        $this->session = $session;
    }
}
