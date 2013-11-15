<?php
namespace Rocketeer\Plugins;

use Rocketeer\Facades\Rocketeer;
use Illuminate\Support\ServiceProvider;

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
    $this->app['config']->package('anahkiasen/rocketeer-campfire', __DIR__.'/../../config');

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
			$branch     = $task->rocketeer->getRepositoryBranch();
			$stage      = $task->rocketeer->getStage();
			$connection = $task->rocketeer->getConnection();

			$message = 'Just deployed branch %s on %s@%s';
			$message = sprintf($message, $branch, $stage, $connection);

			$task->campfire->send($message);
		});
	}
}