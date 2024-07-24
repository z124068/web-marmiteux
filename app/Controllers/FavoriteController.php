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

        // Verify if the user is connected and get his ID
        if (!isset($_SESSION['id'])) {
            // Redirect to the login page if the user is not connected
            header('Location: /marmiteux/login');
            exit;
        }

        $userConnected = isset($_SESSION['id']);
        if ($userConnected) {
            // Connect to the database
            $db = new Database();

            // Prepare the SQL query to get the user information
            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            // Get the user informations
            $currentUser = $result->fetch_assoc();
        }

        // Get the user ID from the session
        $userId = $_SESSION['id'];


        $db = new Database();

        // Prepare the SQL query to select the favorites of the user
        $stmt_user = $db->prepare("SELECT favorites FROM users WHERE id = ?");
        $stmt_user->bind_param("i", $userId);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        // Get favorites of the user
        $user = $result_user->fetch_assoc();
        $favorites = json_decode($user['favorites'], true); // Convert the JSON in a PHP array


        // Prepare the SQL query to select all the recipes
        $ids_string = implode(',', $favorites);
        $stmt_recipes = $db->prepare("SELECT id, name, description, image_link, recipe FROM recipes where id IN ($ids_string)");

        $stmt_recipes->execute();
        $result_recipes = $stmt_recipes->get_result();

        // Get the recipes in an array
        $recipes = [];
        while ($row = $result_recipes->fetch_assoc()) {
            $recipes[] = $row;
        }

        // Include the view passing the user information and recipes
        include_once __DIR__ . '/../../resources/views/favorites/favorites.php';

        // Close the database connection
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

        // Get the favorites of the user
        $user = $this->getUserById($userId);
        if ($user === null) {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
            return;
        }

        $favorites = json_decode($user['favorites'], true);

        if (!is_array($favorites)) {
            $favorites = []; // Initialise the array to an empty array if null or not an array
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

        // Get the favorites of the user
        $user = $this->getUserById($userId);
        if ($user === null) {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
            return;
        }

        $favorites = json_decode($user['favorites'], true);

        if (!is_array($favorites)) {
            $favorites = [];// Initialise the array to an empty array if null or not an array
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
        // Connect to the database
        $db = new Database();

        // Prepare the SQL query to select the user information
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Get the user informations
        $user = $result->fetch_assoc();

        // Close the database connection
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
