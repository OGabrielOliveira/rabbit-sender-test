<?php

include __DIR__.'/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Wapschool\Config;

error_reporting(E_ALL ^ E_WARNING);

$connection = new AMQPStreamConnection(Config::HOST, Config::PORT, Config::USER, Config::PASSWORD);
$channel = $connection->channel();

$channel->exchange_declare('topic-test', 'topic', false, false, false);

$channel->queue_declare('receive-topic-notice',false,false,false,false);
$channel->queue_declare('receive-topic-error',false,false,false,false);
$channel->queue_declare('receive-topic-all',false,false,false,false);


$channel->queue_bind('receive-topic-error', 'topic-test', "5.#");
$channel->queue_bind('receive-topic-notice','topic-test', "2.#");
$channel->queue_bind('receive-topic-notice','topic-test', "3.#");
$channel->queue_bind('receive-topic-notice','topic-test', "4.#");

$channel->queue_bind('receive-topic-all','topic-test', '#');

$code    = preg_replace('/\B/', '.', $argv[1]);
$message = $argv[2];

$message = new AMQPMessage($message);

$channel->basic_publish($message, 'topic-test', $code);
