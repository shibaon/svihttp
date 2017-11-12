<?php

namespace Svi\HttpBundle;

use Svi\Application;
use Svi\HttpBundle\Service\AlertsService;
use Svi\HttpBundle\Service\FormService;
use Svi\HttpBundle\Service\CookiesService;
use Svi\HttpBundle\Service\HttpService;
use Svi\HttpBundle\Service\RoutingService;
use Svi\HttpBundle\Service\SessionService;

class Bundle extends \Svi\Service\BundlesService\Bundle
{

    function __construct(Application $app)
    {
        parent::__construct($app);

        if (!$app->isConsole()) {
            $app[FormService::class] = function () use ($app) {
                return new FormService($app);
            };
            $app[AlertsService::class] = function () use ($app) {
                return new AlertsService($app);
            };
            $app[SessionService::class] = function () use ($app) {
                return new SessionService($app);
            };
            $app[CookiesService::class] = function () use ($app) {
                return new CookiesService($app);
            };
            $app[HttpService::class] = new HttpService($app);
        }
    }

    protected function getServices()
    {
        return [
            RoutingService::class,
        ];
    }

}