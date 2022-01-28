<?php
/**
 * File Name: AuthMiddleware.php
 * @author Ondřej Koubek
 * Date: 28.01.2022
 * Time: 9:55
 */

namespace koubeko\phpmvc\middlewares;

use koubeko\phpmvc\Application;
use koubeko\phpmvc\exception\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @author Ondřej Koubek
 * @namespace koubeko\phpmvc\middlewares
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
     * @throws \koubeko\phpmvc\exception\ForbiddenException
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