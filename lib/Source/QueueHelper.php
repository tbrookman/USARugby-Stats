<?php

namespace Source;
use Phive\Queue\InMemoryQueue;
use Phive\Queue\Db\Pdo\MysqlQueue;
use Kue\Job;

class HelloJob implements Job
{
    function run()
    {
        echo "Hello world\n";
        sleep(10);
        echo "Ready\n";
    }
}

class QueueHelper {
    public static function InMemoryness() {
        $queue = new InMemoryQueue();

        $queue->push(new HelloJob());

        while ($payload = $queue->pop()) {
            echo $payload->run(), PHP_EOL;
        }

        $queue->clear();

        echo $queue->count(), PHP_EOL;
    }

    public static function Mysqlness() {
        include __DIR__ . '/../../app/config.php';
        $host = $config['server'] ? $config['server'] : 'localhost';
        $dbname = $config['database'];
        $conn = new \PDO("mysql:host=$host;dbname=$dbname", $config['username'], $config['password'], $options);
        $mysqlqueue = new MysqlQueue($conn, 'queue');

        $mysqlqueue->push('payload1');
        $mysqlqueue->push('payload2', new \DateTime());
        $mysqlqueue->push('payload3', time());
        $mysqlqueue->push('payload4', '+5 seconds');

        while ($payload = $mysqlqueue->pop()) {
            echo $payload, PHP_EOL;
        }

        echo $mysqlqueue->count(), PHP_EOL;
    }
}
