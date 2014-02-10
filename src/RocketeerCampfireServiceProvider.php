<?php
namespace Rocketeer\Plugins\Campfire;

use Illuminate\Support\ServiceProvider;
use Rocketeer\Facades\Rocketeer;

/**
 * Register the Campfire plugin with the Laravel framework and Rocketeer
 */
class RocketeerCampfireServiceProvider extends ServiceProvider
{
  /**
   * Register classes
   *
   * @return void
   */
  public function register()
  {
    // ...
  }

  /**
   * Boot the plugin
   *
   * @return void
   */
  public function boot()
  {
    Rocketeer::plugin('Rocketeer\Plugins\Campfire\RocketeerCampfire');
  }
}
