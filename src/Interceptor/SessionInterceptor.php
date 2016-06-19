<?php

namespace JqueryTokyo\Api\Interceptor;

use Aura\Session\SegmentFactory;
use Aura\Session\CsrfTokenFactory;
use Aura\Session\Randval;
use Aura\Session\Phpfunc;
use Aura\Session\Session;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

class SessionInterceptor implements MethodInterceptor
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @param MethodInvocation $invocation
     * @return mixed
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();

        $this->session = new Session(
            new SegmentFactory,
            new CsrfTokenFactory(
                new Randval(
                    new Phpfunc
                )
            ),
            new Phpfunc,
            $_COOKIE
        );

        $object->setSession($this->session);

        return $invocation->proceed();
    }
}
