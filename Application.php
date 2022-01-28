<?php
/**
 * File Name: Application.php
 * @author Ondřej Koubek
 * Date: 13.01.2022
 * Time: 20:26
 */

namespace app\core;

use app\core\db\Database;
use app\core\db\DBModel;
use app\core\Router;
use app\core\Request;
use app\core\Response;

/**
 * Class Application
 *
 * @author Ondřej Koubek
 * @namespace app\core
 */
class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public Request $request;
    public Router $router;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public View $view;

    public static Application $app;
    public ?Controller $controller = null;

    /**
     * @param string $rootPath
     * @param array $config
     */
    public function __construct(string $rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = (new $this->userClass())->primaryKey();
            $this->user = (new $this->userClass())->findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user): bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}