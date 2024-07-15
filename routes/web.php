<?php

use App\Controllers\PageController;

require_once __DIR__ . '/../app/Controllers/PageController.php';

$routes = [
    '/' => 'index',             // Route pour la page d'accueil
    '/login' => 'login',        // Route pour afficher le formulaire de login
    '/login/post' => 'processLogin', // Route pour traiter le formulaire de login
    '/register' => 'register',  // Route pour afficher le formulaire d'inscription
    '/register/post' => 'processRegister', // Route pour traiter le formulaire d'inscription
    '/logout' => 'logout',      // Route pour déconnexion
    '/favorite' => 'favorite',
    '/my-account' => 'myAccount',  
    // Ajoutez d'autres routes ici
];

$requestUri = $_SERVER['REQUEST_URI'];
$baseUri = '/marmiteux';

if (strpos($requestUri, $baseUri) === 0) {
    $requestUri = substr($requestUri, strlen($baseUri));
}

$controller = new PageController();

if (array_key_exists($requestUri, $routes)) {
    $method = $routes[$requestUri];
    $controller->{$method}();
} else {
    http_response_code(404);
    echo 'Page not found';
}