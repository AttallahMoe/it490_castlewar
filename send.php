<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//This is an example from offical RabbitMQ documentation & tutorials
$connection = new AMQPStreamConnection('18.223.223.39', 5672, 'admin', 'kwsadmin');
$channel = $connection->channel();
$channel->queue_Declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

?>
