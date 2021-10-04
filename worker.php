<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
//This is from the official documentation for RabbitMQ tutorials.
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('test', false, false, false ,false);
echo "[*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo '[x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo "[x] Done\n";
};

$channel->basic_consume('test', '', false, false, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}
?>
