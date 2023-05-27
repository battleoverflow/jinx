<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx;

use Jinx\Database\DatabaseManager;

class Application
{
    public static string $ROOT_DIR;
    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public DatabaseManager $db;
    public ?UserModel $user = null;
    public static Application $jinx;
    public ?Controller $controller = null;
    public View $view;
    public Logger $log;

    public function __construct($rootDir, array $db_config)
    {
        $this->userClass = $db_config['userClass']; // Access the userClass key from the config in index.php

        self::$ROOT_DIR = $rootDir;
        self::$jinx = $this;

        $this->request  = new Request();
        $this->response = new Response();
        $this->session  = new Session();
        $this->router   = new Router($this->request, $this->response);
        $this->view     = new View();
        $this->log      = new Logger();

        try {
            // Pass the info to the database server from the 'db' key
            $this->db = new DatabaseManager($db_config['db']);
        } catch (\Exception $err) {
            $this->log->consoleLog('No database connection found');
        }

        $primary_value = $this->session->get('user');

        if ($primary_value) {
            $primary_key = $this->userClass::primaryKey();
            $this->user = $this->userClass::findUser([$primary_key => $primary_value]);
        } else {
            $this->user = null;
        }
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primary_key = $user->primaryKey();
        $primary_value = $user->{$primary_key};
        $this->session->set('user', $primary_value);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        // Returns false is no one is logged in
        return !self::$jinx->user;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $err) {
            $this->response->setStatusCode($err->getCode());

            // Render error page
            echo $this->view->renderView('_error', [
                'exception' => $err
            ]);
        }
    }
}