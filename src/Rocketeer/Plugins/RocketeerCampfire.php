<?php
namespace Rocketeer\Plugins;

use Illuminate\Container\Container;
use rcrowe\Campfire;
use Rocketeer\TasksQueue;
use Rocketeer\Traits\Plugin;

class RocketeerCampfire extends Plugin
{
	/**
	 * Setup the plugin
	 */
	public function __construct()
	{
		$this->configurationFolder = __DIR__.'/../../config';
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
	 * Register Tasks with Rocketeer
	 *
	 * @param TasksQueue $queue
	 *
	 * @return void
	 */
	public function onQueue(TasksQueue $queue)
	{
		$me = $this;
		$queue->after('deploy', function ($task) use ($me) {
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
