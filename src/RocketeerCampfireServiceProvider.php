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
		$this->app['config']->package('anahkiasen/rocketeer-campfire', __DIR__.'/../config');

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
			// Get user name
			$user = $task->server->getValue('campfire.name');
			if (!$user) {
				$user = $task->command->ask('Who is deploying ?');
				$task->server->setValue('campfire.name', $user);
			}

			// Get what was deployed
			$branch     = $task->rocketeer->getRepositoryBranch();
			$stage      = $task->rocketeer->getStage();
			$connection = $task->rocketeer->getConnection();

			// Get hostname
			$credentials = array_get($task->rocketeer->getAvailableConnections(), $connection);
			$host        = array_get($credentials, 'host');
			if ($stage) {
				$connection = $stage.'@'.$connection;
			}

			// Build message
			$message = $task->config->get('rocketeer-campfire::message');
			$message = preg_replace('#\{([0-9])\}#', '%$1\$s', $message);
			$message = sprintf($message, $user, $branch, $connection, $host);

			$task->campfire->send($message);
		});
	}
}