<?php

namespace Svi\HttpBundle\Service;

use Svi\AppContainer;
use Svi\HttpBundle\BundleTrait;

abstract class UserService extends AppContainer
{
    use BundleTrait;

	public function logout()
	{
		$this->getSessionService()->uns('uid');
		$this->getCookiesService()->remove('REMEMBERME');
	}

	protected function loginUser($id, $remember = false)
	{
		$this->getSessionService()->set('uid', $id);
		if ($remember) {
			$this->remember($id);
		}
	}

	protected function getAuthorisedUserId()
	{
		if ($id = $this->getSessionService()->get('uid')) {
			return $id;
		} elseif ($id = $this->getRememberId()) {
			$this->loginUser($id);
			return $id;
		}

		return null;
	}

	protected function getRememberId()
	{
		if ($this->getCookiesService()->has('REMEMBERME')) {
			$cookie = openssl_decrypt(
                base64_decode($this->getCookiesService()->get('REMEMBERME')),
			    'BF-CBC',
                $this->app->getConfigService()->getParameter('secret'), 0, 'fL34SpFw'
            );
			$data = explode('[|]', $cookie);
			if (array_key_exists(1, $data)) {
				return $data[1];
			}
		}

		return null;
	}

	protected function remember($id)
	{
		$login = openssl_encrypt(
            time() . '[|]' . $id . '[|]' . microtime(),
            'BF-CBC',
			$this->app->getConfigService()->getParameter('secret'), 0, 'fL34SpFw');
		$this->getCookiesService()->set('REMEMBERME', base64_encode($login), 60*60*24*365);
	}

} 