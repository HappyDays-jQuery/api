<?php

namespace JqueryTokyo\Api\Module;

use josegonzalez\Dotenv\Loader as Dotenv;
use Koriym\DbAppPackage\DbAppPackage;
use Ray\Di\AbstractModule;
use Psr\Log\LoggerInterface;
use Ray\Di\Scope;
use JqueryTokyo\Api\Annotation\BenchMark;
use JqueryTokyo\Api\Interceptor\BenchMarker;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        Dotenv::load([
            'filepath' => dirname(dirname(__DIR__)) . '/.env',
            'toEnv' => true
        ]);
        $this->install(
            new DbAppPackage(
                $_ENV['DB_DSN'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                $_ENV['DB_READ']
            )
        );
        $this->bind(LoggerInterface::class)
            ->toProvider(MonologLoggerProvider::class)
            ->in(Scope::SINGLETON);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(BenchMark::class),
            [BenchMarker::class]
        );
    }
}
