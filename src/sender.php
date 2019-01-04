<?php

include __DIR__.'/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

error_reporting(E_ALL ^ E_WARNING);

$connection = new AMQPStreamConnection('localhost', 5672, 'webart', 'ab9732_c');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

while (true) {
  $msgText = readline('Message to send: ');

  $msg     = new AMQPMessage($msgText);
  $channel->basic_publish($msg, '', 'hello');
}
