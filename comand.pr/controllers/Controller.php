<?php

namespace App\controllers;

use App\models\Model;
use App\models\User;
use App\services\Check;
use App\services\render\TvigRenderTemplate;
use App\services\DB;
use App\services\Session;

class Controller
{
    protected $defaultImageUser = "";
    protected static $defaultMainTemplate = "main";
    protected static $defaultMainTemplateForAuth = "home";
    protected static $defaultContentTemplate = "default";
    protected $tableName;
    protected $model;
    private $params;
    private $renderParams;
    private $loginParams;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->request();
        $this->run();
    }

    public function run($params = [])
    {
        $this->handleRenderParams();
        echo $this->render();
    }

    public function setDirectParams($mainTemplate, $contentTemplate)
    {
        $this->renderParams['mainTemplate'] = $mainTemplate;
        $this->renderParams['contentTemplate'] = $contentTemplate;
        unset($mainTemplate);
        unset($contentTemplate);
    }

    public function request()
    {

        if (isset($_POST['mainTemplate'])) {
            $this->setDirectParams($_POST['mainTemplate'], $_POST['contentTemplate']);
        }

//        if (Session::getAuth()) {
//            $this->setDirectParams('home', 'default');
//        }

        if (isset($_POST['action'])) {
            $method = $_POST['action'] . 'Action';
            $this->$method();
        }

        if ($_POST['info'] == 'dashboard') {
            switch ($_POST['data']) {
                case 'tenants':
                    $this->setDirectParams('home', 'tenantsList');
                    break;
                case 'add_tenant':
                    $this->setDirectParams('home', 'addTenant');
                    break;
                case 'areas':
                    break;
                case 'price':
                    break;
            }
        }

    }

    public function loginAction()
    {
        $this->loginParams = [
            'login' => $_POST['login'],
            'pass' => $_POST['pass']
        ];
        if (!Session::getAuth()) {
            $this->autorization();
        }
    }

    public function redirect($link)
    {
        header("Location:" . $link);
    }

    public function logoutAction()
    {
        Session::unsetAuth();
        $this->redirect('?');
    }

    public function registrationAction()
    {
        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $user = new User();
        $user->setData($data);
        $user->save();
    }

    public function handleRenderParams()
    {
        if (!Session::getAuth()) {

            if ($this->loginParams) {
                $this->renderParams = [
                    'mainTemplate' => 'main',
                    'contentTemplate' => 'login',
                    'errorLogin' => Session::getParam('errorLogin')
                ];
            }

            if ($this->renderParams['mainTemplate'] == 'main') {
                $contentTmpl = $this->renderParams['contentTemplate'];
                switch ($contentTmpl) {
                    case 'Войти':
                    case 'login':
                        $this->renderParams['contentTemplate'] = 'login';
                        break;
                    case 'Регистрация':
                    case 'registration':
                        $this->renderParams['contentTemplate'] = 'registration';
                        break;
                    default:
                        $this->renderParams['contentTemplate'] = 'default';
                }
            }

        } else {

            $this->renderParams['mainTemplate'] = self::$defaultMainTemplateForAuth;
            /*
            if ($this->renderParams['mainTemplate'] == 'home') {
                switch ($this->renderParams['contentTemplate']) {
                    default:
                        $this->renderParams['contentTemplate'] = 'default';
                }
            }
            */

        }
    }

    public function autorization()
    {
        $checkLogin = (new Check($this->loginParams))->run();
        $checkLogin
            ? Session::setAuth($this->loginParams['login'])
            : Session::unsetAuth();
    }

    public function render($params = [])
    {
        if (empty($this->renderParams)) {
            $this->renderParams['mainTemplate'] = Controller::$defaultMainTemplate;
            $this->renderParams['contentTemplate'] = Controller::$defaultContentTemplate;
        }
        $this->renderParams['mainTemplate'] = $this->renderParams['mainTemplate'] ?: Controller::$defaultMainTemplate;
        $this->renderParams['contentTemplate'] = $this->renderParams['contentTemplate'] ?: Controller::$defaultContentTemplate;

        $params['htmlScripts'] = $this->getHTMLScripts();
        $params = array_merge($params, $this->renderParams);
        return TvigRenderTemplate::Render(
            $params
        );

    }

// to DB

    protected function getDBName(&$DBName)
    {
//        $DBName = Model::getDBName();
        $DBName = DB::getDBName();
    }

    public function getMenuUnits(&$menuUnits)
    {
//        $menuUnits = Model::getTableNames();
        $menuUnits = DB::getTableNames();
    }

    public function getProperties(&$properties)
    {
        $properties = $this->model->properties;
    }

    public function getUnits(&$units)
    {
        if (is_null($this->model)) {
            return;
        }

        $properties = $this->model->getProperties();

        $arr = [];
        $item = [];
        foreach ($units as $param) {
            foreach ($param as $prop => $value) {
                if (in_array($prop, $properties)) {
                    $item[$prop] = $value;
                }
            }
            $arr[] = $item;
        }
        $units = $arr;
    }

//    CRUD

    public function showAllAction()
    {
        $params = [
            'units' => $this->model->getAll()
        ];
        $params = array_merge($params, $this->data);
        echo $this->render($params);
    }

    public function showOneAction($id)
    {
        $params = [
            'unit' => $this->model->getOne($id)
        ];
        $params = array_merge($params, $this->data);
        echo $this->render($params);
    }

    public function deleteAction($id)
    {
        $ClassName = $this->getClassName();
        $unit = new $ClassName;
        $unit->id = $id;
        $unit->delete();
        header("Location:main.php?action=showAll");
    }

    public function addAction()
    {
        $this->model = new Model($this->data);
        $this->model->setTableName($this->tableName);
        $this->model->insert();
    }

    public function updateAction()
    {
        $ClassName = $this->getClassName();
        $unit = new $ClassName;
        foreach ($this->unitData as $prop => $value) {
            $unit->$prop = $value;
        }
        $unit->update();
        header("Location:main.php?action=showAll&table={$this->tableName}");
    }

// htmlScripts

    public function getHTMLScripts()
    {
        $htmlText = '';
        $scriptNames = scandir(PATCH_JS);
        foreach ($scriptNames as $fileName) {
            if ($fileName === '.' || $fileName === '..') {
                continue;
            }
            $htmlText .= "<script src='" . PATCH_JS . "{$fileName}'></script>";
        }
        return $htmlText;
    }

}
