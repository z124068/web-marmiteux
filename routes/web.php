<?php

use App\Controllers\PageController;
use App\Controllers\RecipeController;

require_once __DIR__ . '/../app/Controllers/PageController.php';
require_once __DIR__ . '/../app/Controllers/RecipeController.php';

$routes = [
    '/' => 'index',

    // Authentication routes
    '/login' => 'login',
    '/login/post' => 'processLogin',
    '/register' => 'register',
    '/register/post' => 'processRegister',
    '/logout' => 'logout',

    // Dashboard routes
    '/favorite' => 'favorite',
    '/my-account' => 'myAccount',
    '/my-account/recipes' => 'recipes',
    '/my-account/recipes/create-recipe' => 'createRecipe',
    '/my-account/recipes/{id}/edit-recipe/' => 'editRecipe',
    '/my-account/recipes/create-recipe/post' => 'processCreateRecipe',
    '/my-account/recipes/edit-recipe/post' => 'processEditRecipe',
    '/my-account/recipes/{id}/delete-recipe/post' => 'processDeleteRecipe',

    // Ajoutez d'autres routes ici
];

$requestUri = $_SERVER['REQUEST_URI'];
$baseUri = '/marmiteux';

if (strpos($requestUri, $baseUri) === 0) {
    $requestUri = substr($requestUri, strlen($baseUri));
}

$controller = new PageController(); // Utilisation de PageController par défaut

$routeFound = false;

foreach ($routes as $route => $method) {
    $routePattern = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_]+)', $route);
    if (preg_match("#^$routePattern$#", $requestUri, $matches)) {
        array_shift($matches); // Remove the full match
        $routeFound = true;
        if ($method === 'createRecipe' || $method === 'editRecipe' || $method === 'processCreateRecipe' || $method === 'processEditRecipe' || $method === 'recipes' || $method === 'processDeleteRecipe') {
            $recipeController = new RecipeController();
            $recipeController->{$method}(...$matches);
        } else {
            $controller->{$method}(...$matches);
        }
        break;
    }
}

if (!$routeFound) {
    http_response_code(404);
    echo 'Page not found';
}
