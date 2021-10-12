<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//This is an example from offical RabbitMQ documentation & tutorials
$connection = new AMQPStreamConnection('18.216.70.84', 5672, 'admin', 'kwsadmin');
$channel = $connection->channel();
$channel->queue_Declare('task_queue', false, true, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
	$data = "Hello World!";
}
$msg = new AMQPMessage(
    $data,
    array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
);
$channel->basic_publish($msg, '', 'task_queue');

echo '[x] Sent ' , $data, "\n";

$channel->close();
$connection->close();

?>
