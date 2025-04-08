<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/PatientController.php';
require_once __DIR__ . '/../controllers/AppointmentController.php';

session_start();

// Parse the request URL
$request = $_SERVER['REQUEST_URI'];
$basePath = '/';
$request = str_replace($basePath, '', $request);
$request = explode('?', $request)[0];
$segments = explode('/', $request);

// Route mapping
$routes = [
    '' => ['AuthController', 'login'],
    'login' => ['AuthController', 'login'],
    'logout' => ['AuthController', 'logout'],
    'dashboard' => ['AuthController', 'dashboard'],
    'patients' => ['PatientController', 'index'],
    'patients/create' => ['PatientController', 'create'],
    'patients/show/(\d+)' => ['PatientController', 'show'],
    'patients/search' => ['PatientController', 'search'],
    'appointments' => ['AppointmentController', 'index'],
    'appointments/create' => ['AppointmentController', 'create'],
    'appointments/show/(\d+)' => ['AppointmentController', 'show'],
    'appointments/update-status/(\d+)/([a-z]+)' => ['AppointmentController', 'updateStatus']
];

// Find matching route
$matched = false;
foreach ($routes as $pattern => $handler) {
    $regex = '#^' . preg_replace('#\([^\)]+\)#', '([^/]+)', $pattern) . '$#';
    if (preg_match($regex, $request, $matches)) {
        $matched = true;
        $controllerName = $handler[0];
        $methodName = $handler[1];
        
        $controller = new $controllerName();
        $params = array_slice($matches, 1);
        call_user_func_array([$controller, $methodName], $params);
        break;
    }
}

// 404 if no route matched
if (!$matched) {
    header("HTTP/1.0 404 Not Found");
    echo '404 Not Found';
}