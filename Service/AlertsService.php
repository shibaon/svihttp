<?php

namespace Svi\HttpBundle\Service;

use Svi\AppContainer;
use Svi\HttpBundle\BundleTrait;

class AlertsService extends AppContainer
{
    use BundleTrait;

	public function addAlert($type, $text)
	{
		$alerts = $this->getSessionService()->get('alerts');
		if (!$alerts) {
			$alerts = [];
		}
		$alerts[] = ['type' => $type, 'text' => $text];

		$this->getSessionService()->set('alerts', $alerts);
	}

	public function getAlerts()
	{
		$alerts = $this->getSessionService()->get('alerts');
		$this->getSessionService()->uns('alerts');

		return $alerts;
	}

}
