<?php

namespace kiln2github\Kiln;

use GuzzleHttp\Client as BaseClient;

class ClientFactory {

  public static function get($token, $api) {
    return new BaseClient([
      'base_uri' => 'https://didev.kilnhg.com/Api/1.0/' . $api . '?token=' . $token
    ]);
  }
}
