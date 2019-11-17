<?php

namespace App\controllers;

use App\models\Finance;
use App\models\Model;
use App\models\Tenant;
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
    private $data;
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

    /**
     * Функция получения данных, которые необходимо отобразить в шаблоне
     * @param $mainTemplate (главная часть шаблона)
     * @param $contentTemplate (контентная часть шаблона)
     * @return array (возвращаемые данные)
     */
    private function getDataForTemplate($mainTemplate, $contentTemplate)
    {
        if ($mainTemplate != 'home') {
            return [];
        }
        switch ($contentTemplate) {
            case 'listOfTenants':
                $filter_params = [
                    [
                        'caption' => 'Имя арендатора',
                        'name' => 'tenant_name',
                        'placeholder' => 'Имя арендатора'
                    ],
                    [
                        'caption' => 'Телефон',
                        'name' => 'tenant_phone',
                        'placeholder' => '+7 999 999 99 99'
                    ],
                    [
                        'caption' => 'Электронный адрес',
                        'name' => 'tenant_email',
                        'placeholder' => 'test@test.com'
                    ],
                    [
                        'caption' => 'Номер договора аренды',
                        'name' => 'contract_name',
                        'placeholder' => 'Наименование договора'
                    ],
                    [
                        'caption' => 'Дата заключения договора',
                        'name' => 'create_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Дата акта приема-передач',
                        'name' => 'getting_act_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Дата окончания договора',
                        'name' => 'expiration_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Арендуемая площадь (кв.м)',
                        'name' => 'area',
                        'placeholder' => '500'
                    ],
                    [
                        'caption' => 'Объект аренды',
                        'name' => 'rent_object',
                        'placeholder' => 'Объект аренды'
                    ],
                    [
                        'caption' => 'Дата начисления аренды',
                        'name' => 'rent_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Сумма аренды в месяц (руб.)',
                        'name' => 'rent',
                        'placeholder' => '500.000'
                    ],
                    [
                        'caption' => 'Обеспечительный платеж',
                        'name' => 'deposit',
                        'placeholder' => '500.000'
                    ],
                    [
                        'caption' => 'Дата платежа',
                        'name' => 'payment_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Дата акта доступа',
                        'name' => 'avialable_act_at',
                        'placeholder' => '01.01.2001'
                    ]
                ];
                $filter_content = TvigRenderTemplate::RenderTemplate('home/filter', ['filter_params' => $filter_params]);
                $column_names = [
                    'Арендатор',
                    'Номер договора',
                    'Дата заключения договора',
                    'Дата акта приема-передач',
                    'Дата окончания договора',
                    'Арендуемая площадь, (кв.м)',
                    'Арендуемый объект',
                    'Дата начисления аренды',
                    'Арендная плата в месяц, (руб)',
                    'Обеспечительный платеж'
                ];

                $user_login = Session::getAuth()['name'];
                $tenants = new Tenant();
                $data = $tenants->getData($user_login);

                return [
                    'column_names' => $column_names,
                    'data' => $data,
                    'filter_content' => $filter_content
                ];
                break;
            case 'addTenant':
                $fields = [
                    [
                        'caption' => 'Наименование арендатора',
                        'name' => 'tenant_name',
                        'placeholder' => 'Введите наименование арендатора'
                    ],
                    [
                        'caption' => 'ФИО контактного лица',
                        'name' => 'contact_fio',
                        'placeholder' => 'Нажмите что бы ввести'
                    ],
                    [
                        'caption' => 'Контактный телефон',
                        'name' => 'tenant_phone',
                        'placeholder' => '+7 000 000 00 00'
                    ],
                    [
                        'caption' => 'Электронный адрес',
                        'name' => 'tenant_email',
                        'placeholder' => 'test@test.com'
                    ],
                    [
                        'caption' => 'Номер договора аренды',
                        'name' => 'contract_name',
                        'placeholder' => 'Введите номер (наименование) договора'
                    ],
                    [
                        'caption' => 'Дата акта доступа',
                        'name' => 'accept_act_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Дата заключения договора аренды',
                        'name' => 'contract_created_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Дата акта приема-передачи',
                        'name' => 'getting_act_at',
                        'placeholder' => '01.01.2001'
                    ],
                    [
                        'caption' => 'Арендуемая площадь (кв.м)',
                        'name' => 'area',
                        'placeholder' => '500'
                    ],
                    [
                        'caption' => 'Сумма аренды в месяц (руб.)',
                        'name' => 'rent',
                        'placeholder' => '500.000'
                    ],
                    [
                        'caption' => 'Сумма обеспечительного платежа (руб.)',
                        'name' => 'deposit',
                        'placeholder' => '500.000'
                    ]
                ];
                return [
                    'fields' => $fields
                ];
                break;
            case 'financialTable':
                $user_login = Session::getAuth()['name'];
                $finance = new Finance();

                $column_names = [
                    ['name' => 'Имя арендатора'],
                    ['name' => 'Номер договора аренды'],
                    [
                        'name' => 'Октябрь',
                        'content' => [
                            'постоянная',
                            'переменная'
                        ]
                    ],
                    ['name' => 'Итого']
                ];

                $data = $finance->getData($user_login);

                return [
                    'column_names' => $column_names,
                    'data' => $data['last']
                ];
                break;
            case 'personalFinTable':
                $column_names = [
                    'tenant_name' => 'Наименование арендатора:',
                    'contact_fio' => 'Контактное лицо',
                    'tenant_phone' => 'Контактный телефон',
                    'tenant_email' => 'Электронный адрес',
                    'deposit' => 'Обеспечительный платеж'
                ];
                $tenants = [
                    'tenant_name' => 'ООО Ромашка',
                    'contact_fio' => 'Маркизова Екатерина Николаевна',
                    'tenant_phone' => '+7 999 000 00 00',
                    'tenant_email' => 'lorem@gmail.com',
                    'deposit' => 'Σ  1 600 000'
                ];
                $fin_info = [
                    [
                        'month' => 'Сентябрь',
                        'content' => [
                            'rent_fixed' => '200 000',
                            'rent_variable' => '1 000',
                            'payment' => '200 000'
                        ]
                    ],
                    [
                        'month' => 'Октябрь',
                        'content' => [
                            'rent_fixed' => '300 000',
                            'rent_variable' => '1 000',
                            'payment' => '80 000'
                        ]
                    ]
                ];
                $fin_info_sum = [
                    'rent_fixed' => '400 000',
                    'rent_variable' => '2 500',
                    'payment' => '400 000'
                ];
                return [
                    'column_names' => $column_names,
                    'tenant' => $tenants,
                    'fin_info' => $fin_info,
                    'fin_info_sum' => $fin_info_sum
                ];
                break;
        }
        return [];
    }

    public
    function setDirectParams($mainTemplate, $contentTemplate)
    {
        $this->params = array_merge($this->params, $this->getDataForTemplate($mainTemplate, $contentTemplate));

        $this->renderParams['mainTemplate'] = $mainTemplate;
        $this->renderParams['contentTemplate'] = $contentTemplate;
        unset($mainTemplate);
        unset($contentTemplate);
    }

    private function setData($data)
    {
        $this->data = $data;
    }

    private function getData()
    {
        return $this->data;
    }

    public function request()
    {
        if (isset($_POST['method'])) {
            if ($_POST['method'] == 'add') {
                unset($_POST['method']);
                $this->setData($_POST);
                $this->addAction('tenant');
            }
        }
        if (isset($_POST['mainTemplate'])) {
            $this->setDirectParams($_POST['mainTemplate'], $_POST['contentTemplate']);
        }

        if (isset($_POST['action'])) {
            $method = $_POST['action'] . 'Action';
            $this->$method();
        }

        if ($_POST['info'] == 'dashboard') {
            switch ($_POST['data']) {
                case 'tenants':
                    $this->setDirectParams('home', 'listOfTenants');
                    break;
                case 'add_tenant':
                    $this->setDirectParams('home', 'addTenant');
                    break;
                case 'areas':
//                    $this->setDirectParams('home', 'personalFinTable');
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
        $params = array_merge($params, $this->params);
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

    public
    function addAction($param = [])
    {
        if ($param == 'tenant') {
            $tenant = new Tenant();
            $tenant->addTenantInfo($this->getData());
            $this->setDirectParams('home','listOfTenants');
            $this->redirect('?');
        }
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
        $mainTmpl = $this->renderParams['mainTemplate'];
        $contentTmpl = $this->renderParams['contentTemplate'];

        $htmlText = "<script src='/public/js/topMenu.js'></script>";

        if (!Session::getAuth()) {
            $htmlText .= "<script src='/public/js/validateForm.js'></script>";
            return $htmlText;
        }

        // home.js
//        $htmlText .= "<script src='/public/js/" . $mainTmpl . ".js'></script>";

        switch ($contentTmpl) {
            case 'default':
            case '':
                $htmlText .= "<script src='/public/js/dashBoard.js'></script>";
                break;
            default:
                $htmlText .= '<script src="/public/js/' . $contentTmpl . '.js"></script>';
        }

        return $htmlText;
    }

}
