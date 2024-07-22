<?php

// RecipeController.php

namespace App\Controllers;

require_once __DIR__ . '/../../Core/Database.php';

use Core\Database;


class FavoriteController
{

    public function favorites()
    {
        session_start();

        // Vérifier si l'utilisateur est connecté et récupérer l'ID
        if (!isset($_SESSION['id'])) {
            // Redirection vers la page de login si l'utilisateur n'est pas connecté
            header('Location: /marmiteux/login');
            exit;
        }

        $userConnected = isset($_SESSION['id']);
        if ($userConnected) {
            // Connexion à la base de données
            $db = new Database();

            // Préparer la requête SQL pour récupérer les informations de l'utilisateur
            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            // Récupérer les informations de l'utilisateur
            $currentUser = $result->fetch_assoc();
        }

        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id'];


        $db = new Database();

        // get favorites in user table, it is a json with number inside. take this number, and get all recipes that got for id, these numbers
        // Préparer la requête SQL pour sélectionner les favoris de l'utilisateur
        $stmt_user = $db->prepare("SELECT favorites FROM users WHERE id = ?");
        $stmt_user->bind_param("i", $userId);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        // Récupérer les favoris de l'utilisateur
        $user = $result_user->fetch_assoc();
        $favorites = json_decode($user['favorites'], true); // Convert the JSON in a PHP array


        // Préparer la requête SQL pour récupérer toutes les recettes
        $ids_string = implode(',', $favorites);
        $stmt_recipes = $db->prepare("SELECT id, name, description, image_link, recipe FROM recipes where id IN ($ids_string)");

        $stmt_recipes->execute();
        $result_recipes = $stmt_recipes->get_result();

        // Récupérer les recettes dans un tableau
        $recipes = [];
        while ($row = $result_recipes->fetch_assoc()) {
            $recipes[] = $row;
        }

        // Inclure la vue en passant les informations de l'utilisateur et les recettes
        include_once __DIR__ . '/../../resources/views/favorites/favorites.php';

        // Fermeture de la connexion à la base de données
        $stmt_recipes->close();
        $db->close();
    }

    public function addFavorite()
    {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        $recipeId = $_POST['recipeId'];
        $userId = $_SESSION['id'];

        // Récupérer les favoris actuels de l'utilisateur
        $user = $this->getUserById($userId);
        if ($user === null) {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
            return;
        }

        $favorites = json_decode($user['favorites'], true);

        if (!is_array($favorites)) {
            $favorites = []; // Initialiser à un tableau vide si null ou non un tableau
        }

        if (!in_array($recipeId, $favorites)) {
            $favorites[] = $recipeId;
            $this->updateUserFavorites($userId, json_encode($favorites));
        }

        echo json_encode(['status' => 'success']);
    }

    public function removeFavorite()
    {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        $recipeId = $_POST['recipeId'];
        $userId = $_SESSION['id'];

        // Récupérer les favoris actuels de l'utilisateur
        $user = $this->getUserById($userId);
        if ($user === null) {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
            return;
        }

        $favorites = json_decode($user['favorites'], true);

        if (!is_array($favorites)) {
            $favorites = []; // Initialiser à un tableau vide si null ou non un tableau
        }

        if (($key = array_search($recipeId, $favorites)) !== false) {
            unset($favorites[$key]);
            $favorites = array_values($favorites); // Réindexer le tableau
            $this->updateUserFavorites($userId, json_encode($favorites));
        }

        echo json_encode(['status' => 'success']);
    }

    private function getUserById($userId)
    {
        // Connexion à la base de données
        $db = new Database();

        // Préparer la requête SQL pour récupérer les informations de l'utilisateur
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Récupérer les informations de l'utilisateur
        $user = $result->fetch_assoc();

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $db->close();

        return $user;
    }

    private function updateUserFavorites($userId, $favorites)
    {
        $db = new Database();
        $stmt = $db->prepare("UPDATE users SET favorites = ? WHERE id = ?");
        $stmt->bind_param("si", $favorites, $userId);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
}
