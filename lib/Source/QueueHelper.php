<?php

namespace Source;
use Source\Job\GroupSyncJob;
use Phive\Queue\InMemoryQueue;
use Phive\Queue\Db\Pdo\MysqlQueue;

class QueueHelper
{
    private $queue;

    public function __construct()
    {
        include __DIR__ . '/../../app/config.php';
        $host = $config['server'] ? $config['server'] : 'localhost';
        $dbname = $config['database'];
        $conn = new \PDO("mysql:host=$host;dbname=$dbname", $config['username'], $config['password'], $options);
        $this->queue = new MysqlQueue($conn, 'queue');
    }

    public function Queue()
    {
        return $this->queue;
    }

    public function GroupSync($user)
    {
        $this->queue->push(serialize(new GroupSyncJob($user)));
    }

    public function RunQueue()
    {
        $payload = $this->queue->pop();
        $payload = unserialize($payload) === 0 ? $payload : unserialize($payload);
        return is_object($payload) ? $payload->run() : $payload;

        // @TODO: Handle a general class of exception here to re-queue items with failures (in the future?).
    }
}
