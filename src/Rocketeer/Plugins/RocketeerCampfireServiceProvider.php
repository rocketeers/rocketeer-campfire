<?php
namespace Rocketeer\Plugins;

use Illuminate\Support\ServiceProvider;
use rcrowe\Campfire;
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
    $this->app['config']->package('anahkiasen/rocketeer-campfire', __DIR__.'/../../config');

		$this->app->bind('campfire', function ($app) {
			return new Campfire($app['config']->get('rocketeer-campfire::config'));
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
			$path       = $task->releasesManager->getCurrentReleasePath();
			if ($stage) {
				$connection = $stage.'@'.$connection;
			}

			$message = 'Just deployed branch %s on server %s, in %s';
			$message = sprintf($message, $branch, $connection, $path);

			$task->campfire->send($message);
		});
	}
}