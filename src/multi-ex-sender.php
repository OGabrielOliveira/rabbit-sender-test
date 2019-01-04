<?php

include __DIR__.'/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Wapschool\Config;

error_reporting(E_ALL ^ E_WARNING);

$connection = new AMQPStreamConnection(Config::HOST, Config::PORT, Config::USER, Config::PASSWORD);
$channel = $connection->channel();

$channel->exchange_declare('second-test', 'fanout', false, false, false);

$channel->queue_declare('hello-2', false, false, false, false);
$channel->queue_declare('hello-3', false, false, false, false);

$channel->queue_bind('hello-2', 'second-test');
$channel->queue_bind('hello-3', 'second-test');


foreach (range(1,10) as $key => $value) {
  $msg     = new AMQPMessage('Meu teste '.$value);
  $channel->basic_publish($msg, 'second-test');
}
