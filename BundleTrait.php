<?php

namespace Svi\HttpBundle;

use Svi\HttpBundle\Service\AlertsService;
use Svi\HttpBundle\Service\FormService;
use Svi\HttpBundle\Service\CookiesService;
use Svi\HttpBundle\Service\HttpService;
use Svi\HttpBundle\Service\RoutingService;
use Svi\HttpBundle\Service\SessionService;

trait BundleTrait
{
    /**
     * @return FormService
     */
    public function getFormService()
    {
        return $this->app[FormService::class];
    }

    /**
     * @return AlertsService
     */
    public function getAlertsService()
    {
        return $this->app[AlertsService::class];
    }

    /**
     * @return RoutingService
     */
    public function getRoutingService()
    {
        return $this->app[RoutingService::class];
    }

    /**
     * @return SessionService
     */
    public function getSessionService()
    {
        return $this->app[SessionService::class];
    }

    /**
     * @return CookiesService
     */
    public function getCookiesService()
    {
        return $this->app[CookiesService::class];
    }

    /**
     * @return HttpService
     */
    public function getHttpService()
    {
        return $this->app[HttpService::class];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->getHttpService()->getRequest();
    }

}