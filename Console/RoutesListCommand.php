<?php

namespace Svi\HttpBundle\Console;

use Svi\HttpBundle\BundleTrait;
use Svi\Service\ConsoleService\ConsoleCommand;

class RoutesListCommand extends ConsoleCommand
{
    use BundleTrait;

	public function getName()
	{
		return 'routes:list';
	}

	public function getDescription()
	{
		return 'Prints asc list of routes';
	}

	public function execute(array $args)
	{
		$routes = $this->getRoutingService()->getAllRoutes();
		ksort($routes);

		foreach ($routes as $key => $r) {
			$this->writeLn($key . $r['url'] . ':' . $r['controller']);
		}
	}

}