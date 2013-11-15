<?php
namespace Rocketeer\Plugins;

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
    $app['config']->package('anahkiasen/rocketeer-campfire', __DIR__.'/../../config');

		$this->app->bind('rocketeer.campfire', function ($app) {
			return new Campfire($app['config']->get('rocketeer-campfire.config'));
		});
	}

	/**
	 * Register Campfire in the Rocketeer hooks
	 *
	 * @return void
	 */
	public function boot()
	{
		Rocketeer::after('deploy', function ($task) {
			$task->campfire->send('Just deployed branch {branch} on {stage}@{server}');
		});
	}
}