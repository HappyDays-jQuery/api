<?php

namespace JqueryTokyo\Api\Resource\App;

use BEAR\Resource\ResourceObject;
use JqueryTokyo\Api\Module\SessionInject;
use Koriym\Now\NowInject;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;
use Psr\Log\LoggerInterface;
use JqueryTokyo\Api\Annotation\BenchMark;

class Task extends ResourceObject
{
    private $logger;
    use AuraSqlInject;
    use NowInject;
    use QueryLocatorInject;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function onGet($id = null)
    {
        $this->body = $id ?
            $this->pdo->fetchOne($this->query['task/item'], ['id' => $id])
            : $this->pdo->fetchAssoc($this->query['task/list']);

        return $this;
    }

    /**
     * @BenchMark
     */
    public function onPost($title)
    {
        $params = [
            'title' => $title,
            'created' => $this->now,
            'completed' => false
        ];
        $this->pdo->perform($this->query['task/insert'], $params);
        $id = $this->pdo->lastInsertId('id');
        $this->code = 201;
        $this->headers['Location'] = "/task?id={$id}";
        $this->logger->info("post {$title}");

        return $this;
    }

    public function onPatch($id)
    {
        $params = [
            'id' => $id,
            'completed' => true
        ];
        $this->pdo->perform($this->query['task/update'], $params);

        return $this;
    }
}
