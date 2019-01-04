<?php

namespace Wapschool;

class ConsumerUtil
{

  /**
   * Just testing
   * @return void
   */
  public static function consumerHelloWorld($msg){
    echo "[".date('Y-m-d H:i:s')."] Receive: ".$msg->getBody()."\n";
  }

}
