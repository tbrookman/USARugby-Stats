<?php

namespace Source;

use Phive\Queue\InMemoryQueue;
use Phive\Queue\Db\Pdo\MysqlQueue;
use Source\Job\GroupMembersSyncGroupsJob;
use Source\Job\GroupMembersSyncJob;
use Source\Job\GroupSyncJob;

class QueueHelper
{
    private $queue;

    public function __construct()
    {
        include __DIR__ . '/../../app/config.php';
        $host = $config['server'] ? $config['server'] : 'localhost';
        $dbname = $config['database'];
        $conn = new \PDO("mysql:host=$host;dbname=$dbname", $config['username'], $config['password']);
        $this->queue = new MysqlQueue($conn, 'queue');
    }

    public function Queue()
    {
        return $this->queue;
    }

    /**
     * Enqueue Group sync job to be processed.
     *
     * @param $sessionattributes
     */
    public function GroupSync($sessionattributes = null)
    {
        if (empty($sessionattributes)) {
            $sessionattributes = $_SESSION['_sf2_attributes'];
        }
        $this->queue->push(serialize(new GroupSyncJob($sessionattributes)));
    }

    /**
     * Enqueue Group memebers sync job to be processed.
     *
     * @param string $group_uuid
     * @param $sessionattributes
     */
    public function GroupMembersSync($group_uuid = null, $sessionattributes = null)
    {
        if (empty($sessionattributes)) {
            $sessionattributes = $_SESSION['_sf2_attributes'];
        }
        if (empty($group_uuid)) {
            $this->queue->push(serialize(new GroupMembersSyncGroupsJob($sessionattributes)));
        }
        else {
            $this->queue->push(serialize(new GroupMembersSyncJob($sessionattributes, $group_uuid)));
        }
    }

    public function RunQueue()
    {
        $payload = $this->queue->pop();
        $payload = unserialize($payload) === 0 ? $payload : unserialize($payload);
        return is_object($payload) ? $payload->run() : $payload;

        // @TODO: Handle a general class of exception here to re-queue items with failures (in the future?).
    }
}
