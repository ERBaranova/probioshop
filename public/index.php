<?php
declare(strict_types=1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', '/home/c/cr087350/bioclean');
define('SRC',  ROOT . '/src');
define('DATA', ROOT . '/data');

require ROOT . '/config/config.php';
require SRC   . '/Helpers/helpers.php';
require SRC   . '/Helpers/SeoHelper.php';
require SRC   . '/Helpers/Mailer.php';
require SRC   . '/Helpers/Router.php';
require SRC   . '/Models/JsonModel.php';
require SRC   . '/Models/Product.php';
require SRC   . '/Models/Order.php';
require SRC   . '/Models/User.php';
require SRC   . '/Models/B2bLead.php';
require SRC   . '/Controllers/BaseController.php';
require SRC   . '/Controllers/HomeController.php';
require SRC   . '/Controllers/B2bController.php';
require SRC   . '/Controllers/CatalogController.php';
require SRC   . '/Controllers/CartController.php';
require SRC   . '/Controllers/OrderController.php';
require SRC   . '/Controllers/AuthController.php';
require SRC   . '/Controllers/AccountController.php';
require SRC   . '/Controllers/Admin/AdminBaseController.php';
require SRC   . '/Controllers/Admin/AdminAuthController.php';
require SRC   . '/Controllers/Admin/AdminDashboardController.php';
require SRC   . '/Controllers/Admin/AdminOrdersController.php';
require SRC   . '/Controllers/Admin/AdminProductsController.php';
require SRC   . '/Controllers/Admin/AdminUsersController.php';
require SRC   . '/Controllers/Admin/AdminB2bController.php';

session_start();

$router = new Router();

$router->get('/technology',              'HomeController@technology');
$router->get('/b2b',                     'B2bController@index');
$router->post('/b2b',                    'B2bController@submit');
$router->get('/',                        'HomeController@index');
$router->get('/catalog',                 'CatalogController@index');
$router->get('/catalog/{slug}',          'CatalogController@show');
$router->get('/cart',                    'CartController@index');
$router->post('/cart/add',               'CartController@add');
$router->post('/cart/remove',            'CartController@remove');
$router->post('/cart/update',            'CartController@update');
$router->get('/order',                   'OrderController@index');
$router->post('/order/place',            'OrderController@place');
$router->get('/order/success',           'OrderController@success');
$router->get('/login',                   'AuthController@loginForm');
$router->post('/login',                  'AuthController@login');
$router->get('/register',                'AuthController@registerForm');
$router->post('/register',               'AuthController@register');
$router->get('/logout',                  'AuthController@logout');
$router->get('/account',                 'AccountController@index');
$router->get('/account/orders',          'AccountController@orders');
$router->get('/account/profile',         'AccountController@profile');
$router->post('/account/profile',        'AccountController@updateProfile');
$router->get('/admin/login',             'AdminAuthController@loginForm');
$router->post('/admin/login',            'AdminAuthController@login');
$router->get('/admin/logout',            'AdminAuthController@logout');
$router->get('/admin',                   'AdminDashboardController@index');
$router->get('/admin/orders',            'AdminOrdersController@index');
$router->get('/admin/orders/{id}',       'AdminOrdersController@show');
$router->post('/admin/orders/{id}/status','AdminOrdersController@updateStatus');
$router->get('/admin/products',          'AdminProductsController@index');
$router->get('/admin/products/create',   'AdminProductsController@create');
$router->post('/admin/products',         'AdminProductsController@store');
$router->get('/admin/products/{id}/edit','AdminProductsController@edit');
$router->post('/admin/products/{id}',    'AdminProductsController@update');
$router->post('/admin/products/{id}/toggle','AdminProductsController@toggleStock');
$router->get('/admin/users',             'AdminUsersController@index');
$router->get('/admin/b2b',               'AdminB2bController@index');
$router->post('/admin/b2b/{id}/status',  'AdminB2bController@updateStatus');

$router->dispatch();
