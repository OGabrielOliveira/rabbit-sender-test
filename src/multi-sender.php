<?php

include __DIR__.'/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

error_reporting(E_ALL ^ E_WARNING);

$connection = new AMQPStreamConnection('localhost', 5672, 'webart', 'ab9732_c');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

foreach (range(1,10) as $key => $value) {
  $msg     = new AMQPMessage('Meu teste '.$value);
  $channel->basic_publish($msg, '', 'hello');
}
