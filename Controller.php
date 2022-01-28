<?php
/**
 * File Name: Controller.php
 * @author Ondřej Koubek
 * Date: 19.01.2022
 * Time: 19:57
 */

namespace app\core;

use app\core\middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 * @author Ondřej Koubek
 * @namespace app\core
 */
class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var \app\core\middlewares\BaseMiddleware[]
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
     * @return \app\core\middlewares\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }


}