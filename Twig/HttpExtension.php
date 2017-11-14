<?php

namespace Svi\HttpBundle\Twig;

use Svi\Application;
use Svi\HttpBundle\BundleTrait;

class HttpExtension extends \Twig_Extension
{
    use BundleTrait;

    /**
     * @var Application
     */
    private $app;

    function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('asset', [$this, 'assetFunction']),
            new \Twig_SimpleFunction('path', [$this, 'pathFunction']),
            new \Twig_SimpleFunction('url', [$this, 'urlFunction']),
            new \Twig_SimpleFunction('getRequestUri', [$this, 'getRequestUriFunction'])
        ];
    }

    public function assetFunction($asset)
    {
        return '/bundles/' . $asset . '?' . $this->app->getConfigService()->get('assetsVersion');
    }

    public function pathFunction($route, array $parameters = [])
    {
        return $this->getRoutingService()->getUrl($route, $parameters);
    }

    public function urlFunction($route, array $parameters = [])
    {
        return $this->getRoutingService()->getUrl($route, $parameters, true);
    }

    public function getRequestUriFunction()
    {
        return $this->getHttpService()->getRequest()->getRequestUri();
    }

}