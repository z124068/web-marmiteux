<?php

use App\Controllers\PageController;
use App\Controllers\RecipeController; // Ajoutez cette ligne pour importer RecipeController

require_once __DIR__ . '/../app/Controllers/PageController.php';
require_once __DIR__ . '/../app/Controllers/RecipeController.php'; // Ajoutez cette ligne pour inclure RecipeController

$routes = [
    '/' => 'index',
    '/login' => 'login',
    '/login/post' => 'processLogin',
    '/register' => 'register',
    '/register/post' => 'processRegister',
    '/logout' => 'logout',
    '/favorite' => 'favorite',
    '/my-account' => 'myAccount',
    '/create-recipe' => 'createRecipe',
    '/edit-recipe' => 'editRecipe',
    '/create-recipe/post' => 'processCreateRecipe',
    '/edit-recipe/post' => 'processEditRecipe',
    // Ajoutez d'autres routes ici
];

$requestUri = $_SERVER['REQUEST_URI'];
$baseUri = '/marmiteux';

if (strpos($requestUri, $baseUri) === 0) {
    $requestUri = substr($requestUri, strlen($baseUri));
}

$controller = new PageController(); // Utilisation de PageController par défaut

if (array_key_exists($requestUri, $routes)) {
    $method = $routes[$requestUri];
    
    // Utilisation du RecipeController pour les routes spécifiques
    if ($method === 'createRecipe' || $method === 'editRecipe' || $method === 'processCreateRecipe' || $method === 'processEditRecipe') {
        $recipeController = new RecipeController();
        $recipeController->{$method}();
    } else {
        $controller->{$method}();
    }
} else {
    http_response_code(404);
    echo 'Page not found';
}