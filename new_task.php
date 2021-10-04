<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//This is an example from offical RabbitMQ documentation & tutorials
$connection = new AMQPStreamConnection('18.216.70.84', 5672, 'admin', 'kwsadmin');
$channel = $connection->channel();
$channel->queue_Declare('test', false, false, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
	$data = "Hello World!";
}
$msg = new AMQPMessage($data);
$channel->basic_publish($msg, '', 'test');

echo '[x] Sent ' , $data, "\n";

$channel->close();
$connection->close();

?>
