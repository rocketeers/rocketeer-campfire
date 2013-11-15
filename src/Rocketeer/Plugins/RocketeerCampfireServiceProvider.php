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
		Rocketeer::execute(function ($task) {
			// Get what was deployed
			$branch     = $task->rocketeer->getRepositoryBranch();
			$stage      = $task->rocketeer->getStage();
			$connection = $task->rocketeer->getConnection();

			// Get hostname and username
			$credentials = array_get($task->rocketeer->getAvailableConnections(), $connection);
			$host        = array_get($credentials, 'host');
			$user        = array_get($credentials, 'username');
			if ($stage) {
				$connection = $stage.'@'.$connection;
			}

			// Build message
			$message = '%s finished deploying branch "%s" on "%s" (%s)';
			$message = sprintf($message, $user, $branch, $connection, $host);

			$task->campfire->send($message);
		});
	}
}