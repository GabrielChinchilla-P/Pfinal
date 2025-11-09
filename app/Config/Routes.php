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
    // MÓDULO DE INFORMES DE GASTO (NUEVO)
    // ---------------------------------

    $routes->get('informegasto', 'InformeGasto::index', ['filter' => 'auth']);

    $routes->group('/', ['filter' => 'auth'], static function ($routes) {
    
    // R - Listar Informes de Gasto (InformeGasto::index)
    $routes->get('informegasto', 'InformeGasto::index');
    
    // C - Crear Nuevo Informe (Formulario)
    $routes->get('informegasto/create', 'InformeGasto::create');
    
    // C - Guardar Nuevo Informe (Proceso POST)
    $routes->post('informegasto/store', 'InformeGasto::store');
    
    // U - Editar Informe (Formulario pre-llenado)
    $routes->get('informegasto/edit/(:num)', 'InformeGasto::edit/$1');
    
    // U - Actualizar Informe (Proceso POST)
    $routes->post('informegasto/update/(:num)', 'InformeGasto::update/$1');
    
    // D - Eliminar Informe
    $routes->get('informegasto/delete/(:num)', 'InformeGasto::delete/$1');

});

// ---------------------------------
    // MÓDULO DE DEPARTAMENTO (NUEVO)
    // ---------------------------------

    $routes->get('departamento', 'Departamento::index', ['filter' => 'auth']);

    $routes->group('/', ['filter' => 'auth'], static function ($routes) {

    // R - Listar Departamentos
    $routes->get('departamento', 'Departamento::index');
    
    // C - Crear Nuevo Departamento (Formulario)
    $routes->get('departamento/create', 'Departamento::create');
    
    // C - Guardar Nuevo Departamento (Proceso POST)
    $routes->post('departamento/store', 'Departamento::store');
    
    // U - Editar Departamento (Formulario pre-llenado)
    $routes->get('departamento/edit/(:num)', 'Departamento::edit/$1');
    
    // U - Actualizar Departamento (Proceso POST)
    $routes->post('departamento/update/(:num)', 'Departamento::update/$1');
    
    // D - Eliminar Departamento
    $routes->get('departamento/delete/(:num)', 'Departamento::delete/$1');

    });

    // ---------------------------------
    // MÓDULO DE BONIFICACIÓN (NUEVO)
    // ---------------------------------
    $routes->get('/bonificacion', 'Bonificacion::index');
    $routes->get('/bonificacion/buscar', 'Bonificacion::buscar');
    $routes->post('/bonificacion/store', 'Bonificacion::store');
    $routes->post('/bonificacion/update/(:any)', 'Bonificacion::update/$1');
    $routes->get('/bonificacion/delete/(:any)', 'Bonificacion::delete/$1');
});