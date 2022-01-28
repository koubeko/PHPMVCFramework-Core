<?php
/**
 * File Name: AuthMiddleware.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 9:55
 */

namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @author Ondřej Koubek
 * @namespace app\core\middlewares
 */
class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }


    /**
     * @throws \app\core\exception\ForbiddenException
     */
    public function execute()
    {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException();
            }
        }
    }

}