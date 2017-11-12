<?php

namespace Svi\HttpBundle\Service;

use Svi\AppContainer;
use Svi\Application;

class SessionService extends AppContainer
{

	public function __construct(Application $app)
	{
		parent::__construct($app);

		session_start();
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function uns($key)
	{
		unset($_SESSION[$key]);
	}

	public function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}

} 