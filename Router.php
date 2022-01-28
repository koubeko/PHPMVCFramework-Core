<?php
/**
 * File Name: Router.php
 * @author Ondřej Koubek
 * Date: 13.01.2022
 * Time: 20:45
 */

namespace koubeko\phpmvc;

use koubeko\phpmvc\exception\ForbiddenException;
use koubeko\phpmvc\exception\NotFoundException;
use koubeko\phpmvc\Request;
use koubeko\phpmvc\Response;

/**
 * Class Router
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc
 */
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @throws \koubeko\phpmvc\exception\NotFoundException
     */
    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)) {
            /** @var \koubeko\phpmvc\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }
}