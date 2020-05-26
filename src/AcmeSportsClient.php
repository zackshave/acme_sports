<?php

namespace Drupal\acme_sports;

use Drupal\Component\Serialization\Json;

class AcmeSportsClient {

  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * AcmeSportsClient constructor.
   *
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */
  public function __construct($http_client_factory) {
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'http://delivery.chalk247.com/',
    ]);
  }

  /**
   * Get data
   *
   * @param int $amount
   *
   * @return array
   */
  public function getData() {
    $response = $this->client->get('team_list/NFL.JSON?api_key=74db8efa2a6db279393b433d97c2bc843f8e32b0');

    $data = Json::decode($response->getBody());

    return $data;
  }

}
