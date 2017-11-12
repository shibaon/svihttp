<?php

namespace Svi\HttpBundle\Service;

use Svi\AppContainer;
use Svi\HttpBundle\BundleTrait;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CookiesService extends AppContainer
{
    use BundleTrait;

	function get($key)
	{
		return $this->getHttpService()->getRequest()->cookies->get($key);
	}

	function has($key)
	{
		return $this->getHttpService()->getRequest()->cookies->has($key);
	}

	public function set($name, $value, $lifeTime = 0)
	{
		$response = new Response();
		$response->headers->setCookie(new Cookie($name, $value, $lifeTime ? time() + $lifeTime : 0));
		$response->sendHeaders();
	}

	public function remove($name) {
		$response = new Response();
		$response->headers->clearCookie($name);
		$response->sendHeaders();
	}

}