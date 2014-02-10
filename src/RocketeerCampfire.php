<?php
namespace Rocketeer\Plugins\Campfire;

use Illuminate\Container\Container;
use rcrowe\Campfire;
use Rocketeer\Plugins\Notifier;

class RocketeerCampfire extends Notifier
{
  /**
   * Setup the plugin
   */
  public function __construct(Container $app)
  {
    parent::__construct($app);

    $this->configurationFolder = __DIR__.'/../config';
  }

  /**
   * Bind additional classes to the Container
   *
   * @param Container $app
   *
   * @return void
   */
  public function register(Container $app)
  {
    $app->bind('campfire', function ($app) {
      return new Campfire($app['config']->get('rocketeer-campfire::config'));
    });

    return $app;
  }

  /**
   * Get the default message format
   *
   * @return string
   */
  protected function getMessageFormat()
  {
    return $this->app['config']->get('rocketeer-campfire::message');
  }

  /**
   * Send a given message
   *
   * @param string $message
   *
   * @return void
   */
  protected function send($message)
  {
    $this->app['campfire']->send($message);
  }
}
