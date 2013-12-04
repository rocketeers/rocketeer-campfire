<?php
namespace Rocketeer\Plugins;

use Illuminate\Support\ServiceProvider;
use Rocketeer\Facades\Rocketeer;

/**
 * Register the Campfire plugin with the Laravel framework and Rocketeer
 */
class RocketeerCampfireServiceProvider extends ServiceProvider
{
	/**
	 * Register the actions
	 *
	 * @return void
	 */
	public function register()
	{
		Rocketeer::plugin('Rocketeer\Plugins\Campfire');
	}
}