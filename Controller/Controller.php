<?php

namespace Svi\HttpBundle\Controller;

use Svi\AppContainer;
use Svi\HttpBundle\BundleTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class Controller extends AppContainer
{
    use BundleTrait;
    use \Svi\TengineBundle\BundleTrait;

	function createForm(array $parameters = [])
	{
		return $this->getFormService()->createForm($parameters);
	}

    public function render($template, array $parameters = array())
    {
        if (strpos($template, '/') === false) {
            $parts = explode('\\', get_class($this));
            $lastPart = str_replace('Controller', '', $parts[count($parts) - 1]);
            unset($parts[count($parts) - 1]);
            unset($parts[count($parts) - 1]);
            $template = implode('/', $parts) . '/Views/' . $lastPart . '/' . $template;
        }

        return $this->getTemplateService()->render($template, $parameters);
    }

    public function generateUrl($name, array $parameters = [], $absolute = false)
    {
        return $this->getRoutingService()->getUrl($name, $parameters, $absolute);
    }

    protected function getTemplateParameters(array $parameters = [])
    {
        return $parameters;
    }

    public function getParameter($key)
    {
        return $this->app->getConfigService()->getParameter($key);
    }

    public function redirect($route, array $parameters = [])
    {
        return $this->redirectToUrl($this->generateUrl($route, $parameters));
    }

    public function redirectToUrl($url)
    {
        return new RedirectResponse($url);
    }

    public function getRequest()
    {
        return $this->getHttpService()->getRequest();
    }

    public function csrfCheck()
    {
        $referer = $this->getRequest()->headers->get('referer');

        if (strtolower($this->getRequest()->getHost()) != strtolower(parse_url($referer, PHP_URL_HOST))) {
            throw new \Exception('Csrf check failed');
        }
    }

}