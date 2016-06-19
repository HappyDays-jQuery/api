<?php

namespace JqueryTokyo\Api\Interceptor;

use Psr\Log\LoggerInterface;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

class BenchMarker implements MethodInterceptor
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function invoke(MethodInvocation $invocation)
    {
        $start = microtime(true);
        $result = $invocation->proceed();
        $time = microtime(true) - $start;
        $msg = sprintf(
            "%s: %s",
            $invocation->getMethod()->getName(),
            (int) $time * 1000 . 'ms'
        );
        $this->logger->info($msg);

        return $result;
    }
}
