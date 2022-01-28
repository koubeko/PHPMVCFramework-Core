<?php
/**
 * File Name: View.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 10:53
 */

namespace app\core;

/**
 * Class View
 *
 * @author Ondřej Koubek
 * @namespace app\core
 */
class View
{
    public string $title = '';

    public function renderView(string $view, array $params = []): string|array
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent(string $viewContent): string|array
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(): false|string
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view, array $params): false|string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}