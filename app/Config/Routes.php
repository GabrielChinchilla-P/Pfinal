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
    // R - Listar Empleados (Empleado::index)
    $routes->get('empleado', 'Empleado::index');
    
    // C - Crear Nuevo Empleado (Formulario) (Empleado::create)
    $routes->get('empleado/create', 'Empleado::create');
    
    // C - Guardar Nuevo Empleado (Proceso POST) (Empleado::store)
    $routes->post('empleado/store', 'Empleado::store');
    
    // U - Editar Empleado (Formulario pre-llenado) (Empleado::edit)
    $routes->get('empleado/edit/(:num)', 'Empleado::edit/$1');
    
    // U - Actualizar Empleado (Proceso POST) (CORREGIDO: 'Empleado' en mayúscula)
    $routes->post('empleado/update/(:num)', 'Empleado::update/$1');
    
    // D - Eliminar Empleado (Empleado::delete)
    $routes->get('empleado/delete/(:num)', 'Empleado::delete/$1');
});

// ---------------------------------
    // Rutas Informe de Gastos
    // ---------------------------------
$routes->get('informe_gastos', 'InformeGastos::index');
   
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

    // --- Rutas para el Módulo de Bonificaciones ---
    $routes->get('bonificacion', 'Bonificacion::index', ['filter' => 'auth']);
    
    $routes->group('/', ['filter' => 'auth'], static function ($routes){
    // Listado y Búsqueda (GET /bonificacion)
    $routes->get('/', 'Bonificacion::index'); 

    // Formulario de Creación (GET /bonificacion/create)
    $routes->get('create', 'Bonificacion::create');
    
    // Procesa el guardado (POST /bonificacion/store)
    $routes->post('store', 'Bonificacion::store');
    
    // Formulario de Edición (GET /bonificacion/edit/ID)
    $routes->get('edit/(:num)', 'Bonificacion::edit/$1');
    
    // Procesa la actualización (POST /bonificacion/update/ID)
    $routes->post('update/(:num)', 'Bonificacion::update/$1');
    
    // Eliminar registro (GET /bonificacion/delete/ID)
    $routes->get('delete/(:num)', 'Bonificacion::delete/$1');
});