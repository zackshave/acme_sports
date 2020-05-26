<?php

namespace Drupal\acme_sports\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Block of NFL teams divided by division, presented as an accordion widget
 *
 * @Block(
 *   id = "acme_sports_block",
 *   admin_label = @Translation("NFL Team Divisions")
 * )
 */
class AcmeSports extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\acme_sports\AcmeSportsClient
   */
  protected $AcmeSportsClient;

  /**
   * AcmeSports constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param $acme_sports_client \Drupal\acme_sports\AcmeSportsClient
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, $acme_sports_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->AcmeSportsClient = $acme_sports_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('acme_sports_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    /**
     * get data from client
     */
    $acme_sports = $this->AcmeSportsClient->getData();

    /**
     * drill down to team data
     */
    $acme_sports = $acme_sports['results']['data']['team'];

    /**
     * create empty division arrays
     */

    $north_division = [];
    $east_division = [];
    $south_division = [];
    $west_division = [];

    /**
     * sort teams into division arrays
     */

    foreach ($acme_sports as $acme_sport) {
      if ($acme_sport['division'] == 'North') {
        $north_division[] = $acme_sport;
      }
      elseif ($acme_sport['division'] == 'East') {
        $east_division[] = $acme_sport;
      }
      elseif ($acme_sport['division'] == 'South') {
        $south_division[] = $acme_sport;
      }
      elseif ($acme_sport['division'] == 'West') {
        $west_division[] = $acme_sport;
      }
    }

    /**
     * build variables for twig template
     */

    return [
      '#theme' => 'acme_sports_template',
      '#north' => $north_division,
      '#east' => $east_division,
      '#south' => $south_division,
      '#west' => $west_division,
    ];
  }

}
