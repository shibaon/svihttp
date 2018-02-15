<?php

namespace Svi\HttpBundle\Service;

use Svi\AppContainer;
use Svi\Application;
use Svi\HttpBundle\BundleTrait;
use Svi\HttpBundle\Exception\AccessDeniedHttpException;
use Svi\HttpBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpService extends AppContainer
{
    use BundleTrait;

    private $request;
    private $response;
    private $route;
    private $before = [];
    private $after = [];
    private $finish = [];

    public function __construct(Application $app)
    {
        parent::__construct($app);

        if (!$app->isConsole() && !$app['debug']) {
            $app->error(function (NotFoundHttpException $e, Request $request) {
                ob_start();
                include __DIR__ . '/./HttpService/404.php';
                $content = ob_get_contents();
                ob_end_clean();

                return new Response($content, 404);
            });
            $app->error(function (AccessDeniedHttpException $e, Request $request) {
                ob_start();
                include __DIR__ . '/./HttpService/403.php';
                $content = ob_get_contents();
                ob_end_clean();

                return new Response($content, 403);
            });
            $app->error(function (\Throwable $e) {
                ob_start();
                include __DIR__ . '/./HttpService/500.php';
                $content = ob_get_contents();
                ob_end_clean();

                return new Response($content, 500);
            });
        }
    }

    public function run()
    {
        $request = $this->getRequest();
        $this->route = $this->getRoutingService()->dispatchUrl(explode('?', $request->getRequestUri())[0]);

        foreach ($this->before as $before) {
            if ($this->response = $before($request, $this->route)) {
                break;
            }
        }

        if (!$this->response && $this->route) {
            $controller = new $this->route['controller']($this->app);
            $this->response = call_user_func_array([$controller, $this->route['method']], array_merge($this->route['args'], [$request]));

            if (!$this->response) {
                throw new \Exception('Controller must return a response');
            }
        }

        if (!$this->response) {
            throw new NotFoundHttpException();
        }

        if (!($this->response instanceof Response)) {
            $this->response = new Response($this->response);
        }

        $this->response->prepare($request);

        foreach ($this->after as $after) {
            if ($result = $after($request, $this->response)) {
                if (!($result instanceof Response)) {
                    $this->response = new Response($result);
                }
                $this->response = $result;
                $this->response->prepare($request);
            }
        }

        $this->response->sendHeaders();
        $this->response->sendContent();

        foreach ($this->finish as $finish) {
            $finish($request, $this->response);
        }
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request ?? $this->request = Request::createFromGlobals();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getRoute()
    {
        return $this->route;
    }

    public function before($callback, $prepend = false)
    {
        if ($prepend) {
            array_unshift($this->before, $callback);
        } else {
            $this->before[] = $callback;
        }
    }

    public function after($callback, $prepend = false)
    {
        if ($prepend) {
            array_unshift($this->after, $callback);
        } else {
            $this->after[] = $callback;
        }
    }

    public function finish($callback, $prepend = false)
    {
        if ($prepend) {
            array_unshift($this->finish, $callback);
        } else {
            $this->finish[] = $callback;
        }
    }

}
