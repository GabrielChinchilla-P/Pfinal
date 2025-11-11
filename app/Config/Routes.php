<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultController('AuthController'); // Asegúrate que AuthController es el controlador por defecto


// Rutas de autenticación
$routes->get('/', 'AuthController::index'); // La raíz del sitio muestra el login


$routes->post('auth/login', 'AuthController::login'); // Procesa el login
$routes->post('auth/register', 'AuthController::register'); // Procesa el registro
$routes->get('logout', 'AuthController::logout'); // Para cerrar sesión

// RUTA DEL MENÚ (Agregada/Modificada)
// Si la URL es /menu, usa el método index() del MenuController
$routes->get('menu', 'MenuController::index');

$routes->get('menu', 'MenuController::index', ['filter' => 'auth']);

$routes->get('nomina', 'Nomina::index', ['filter' => 'auth']);

$routes->group('/', ['filter' => 'auth'], static function ($routes) {

    // R - Listar Nómina
    $routes->get('nomina', 'Nomina::index');
    
    // C - Crear Nueva Nómina (Formulario)
    $routes->get('nomina/create', 'Nomina::create');
    
    // C - Guardar Nueva Nómina (Proceso POST)
    $routes->post('nomina/store', 'Nomina::store');
    
    // U - Editar Nómina (Formulario pre-llenado)
    $routes->get('nomina/edit/(:num)', 'Nomina::edit/$1');
    
    // U - Actualizar Nómina (Proceso POST)
    $routes->post('nomina/update/(:num)', 'Nomina::update/$1');
    
    // D - Eliminar Nómina
    $routes->get('nomina/delete/(:num)', 'Nomina::delete/$1');
});

// GRUPO DE RUTAS PRINCIPAL CON FILTRO DE AUTENTICACIÓN

$routes->get('empleado', 'Empleado::index', ['filter' => 'auth']);

$routes->group('/', ['filter' => 'auth'], static function ($routes) {
    
    // MÓDULO DE EMPLEADOS
    $routes->get('/empleados', 'Empleados::index');
    $routes->get('/empleados/buscar', 'Empleados::buscar');
    $routes->post('/empleados/store', 'Empleados::store');
    $routes->post('/empleados/update/(:any)', 'Empleados::update/$1');
    $routes->get('/empleados/delete/(:any)', 'Empleados::delete/$1');
});

// ---------------------------------
    // Rutas Informe de Gastos
    // ---------------------------------

// Informe de gastos
$routes->get('informegasto', 'InformeGasto::index');
$routes->get('informegasto/buscar', 'InformeGasto::buscar');
$routes->get('informegasto/create', 'InformeGasto::create');
$routes->post('informegasto/store', 'InformeGasto::store');
$routes->get('informegasto/edit/(:any)', 'InformeGasto::edit/$1');
$routes->post('informegasto/update/(:any)', 'InformeGasto::update/$1');
$routes->get('informegasto/delete/(:any)', 'InformeGasto::delete/$1');
 // ---------------------------------

    // MÓDULO DE DEPARTAMENTO (NUEVO)
    // ---------------------------------

    $routes->get('departamentos', 'Departamentos::index');
    $routes->get('/departamentos/buscar', 'Departamentos::buscar');
    $routes->post('departamentos/store', 'Departamentos::store');
    $routes->post('departamentos/update/(:any)', 'Departamentos::update/$1');
    $routes->get('departamentos/delete/(:any)', 'Departamentos::delete/$1'); 

    
    $routes->get('bonificacion', 'Bonificacion::index');
    $routes->get('bonificacion/create', 'Bonificacion::create');
    $routes->post('bonificacion/store', 'Bonificacion::store');
    $routes->get('bonificacion/edit/(:segment)', 'Bonificacion::edit/$1');
    $routes->post('bonificacion/update/(:segment)', 'Bonificacion::update/$1');
    $routes->get('bonificacion/delete/(:segment)', 'Bonificacion::delete/$1');

    $routes->setAutoRoute(true);