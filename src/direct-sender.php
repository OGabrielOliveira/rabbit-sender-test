<?php

include __DIR__.'/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Wapschool\Config;

error_reporting(E_ALL ^ E_WARNING);

$connection = new AMQPStreamConnection(Config::HOST, Config::PORT, Config::USER, Config::PASSWORD);
$channel = $connection->channel();

$channel->exchange_declare('third-test', 'direct', false, false, false);

$channel->queue_declare('receive-post-data',false,false,false,false);
$channel->queue_declare('receive-delete',false,false,false,false);

$channel->queue_bind('receive-post-data', 'third-test', 'update');
$channel->queue_bind('receive-post-data', 'third-test', 'insert');

$channel->queue_bind('receive-delete', 'third-test', 'delete');


$code    = $argv[1];
$message = $argv[2];

$message = new AMQPMessage($message);

$channel->basic_publish($message, 'third-test', $code);
