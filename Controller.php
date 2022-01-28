<?php
/**
 * File Name: Controller.php
 * @author Ondřej Koubek
 * Date: 19.01.2022
 * Time: 19:57
 */

namespace koubeko\phpmvc;

use koubeko\phpmvc\middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc
 */
class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var \koubeko\phpmvc\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function render(string $view, array $params = []): array|string
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return \koubeko\phpmvc\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


}