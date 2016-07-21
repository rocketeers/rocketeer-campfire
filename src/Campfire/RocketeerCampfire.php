<?php
namespace Rocketeer\Plugins\Campfire;

use rcrowe\Campfire;
use Rocketeer\Plugins\AbstractNotifier;

class RocketeerCampfire extends AbstractNotifier
{
    /**
     * @var string
     */
    protected $name = 'rocketeer-campfire';

	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->share('campfire', function () {
			return new Campfire($this->getPluginOption());
		});
	}

	/**
	 * {@inheritdoc}
	 */
	public function send($message)
	{
        /** @var Campfire $campfire */
        $campfire = $this->container->get('campfire');
        $campfire->send($message);
	}
}
