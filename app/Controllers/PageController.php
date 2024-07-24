<?php

namespace App\Controllers;

require_once __DIR__ . '/../../Core/Database.php';

use Core\Database;

class PageController
{
    public function index()
    {
        session_start();

        $userConnected = isset($_SESSION['id']);
        if ($userConnected) {
            $db = new Database();

            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            $currentUser = $result->fetch_assoc();
        }
        $db = new Database();

        $stmt_categories = $db->prepare("SELECT id, name FROM recipe_types");
        $stmt_categories->execute();
        $result_categories = $stmt_categories->get_result();

        $categories = [];
        while ($row = $result_categories->fetch_assoc()) {
            $categories[] = $row;
        }


        $stmt_recipes = $db->prepare("SELECT id, name, description, image_link, recipe, recipe_type_id FROM recipes");
        $stmt_recipes->execute();
        $result_recipes = $stmt_recipes->get_result();

        $recipes = [];
        while ($row = $result_recipes->fetch_assoc()) {
            $recipes[] = $row;
        }

        include_once __DIR__ . '/../../resources/views/index/home.php';

        $stmt_recipes->close();
        $db->close();
    }

    public function recipe($id)
    {
        session_start();

        $userConnected = isset($_SESSION['id']);
        if ($userConnected) {
            $db = new Database();

            $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            $currentUser = $result->fetch_assoc();
        }
        $db = new Database();

        $stmt_recipe = $db->prepare("SELECT id, name, description, image_link, recipe FROM recipes where id = ?");
        $stmt_recipe->bind_param("i", $id);
        $stmt_recipe->execute();
        $result_recipe = $stmt_recipe->get_result();
        $recipe = $result_recipe->fetch_assoc();

        include_once __DIR__ . '/../../resources/views/index/recipe.php';

        $stmt_recipe->close();
        $db->close();
    }

    public function login()
    {
        include_once __DIR__ . '/../../resources/views/account/login.php';
    }

    public function processLogin()
    {
        session_start();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new Database();

        $stmt = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /marmiteux');
                exit;
            } else {
                $_SESSION['alert_message'] = 'Invalid username or password';
                header('Location: /marmiteux/login');
                exit;
            }
        } else {
            $_SESSION['alert_message'] = 'Invalid username or password';
            header('Location: /marmiteux/login');
            exit;
        }

        $stmt->close();
        $db->close();
    }


    public function register()
    {
        include_once __DIR__ . '/../../resources/views/account/register.php';
    }

    public function processRegister()
    {
        session_start(); // Assurez-vous que la session est démarrée

        $db = new Database();

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email_address = $_POST['email_address'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $description = $_POST['description'];
        $favorites = json_encode(['0']);

        // Vérifier si l'email ou le nom d'utilisateur existe déjà
        $checkQuery = "SELECT * FROM users WHERE email_address = ? OR username = ?";
        $stmt = $db->prepare($checkQuery);
        $stmt->bind_param("ss", $email_address, $username);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        if ($checkResult->num_rows > 0) {
            $_SESSION['alert_message'] = 'User with that email or username already exists!';
            header('Location: /marmiteux/register');
            exit;
        }

        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insérer l'utilisateur dans la base de données
        $sql = "INSERT INTO users (name, surname, username, password, email_address, description, favorites) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("sssssss", $name, $surname, $username, $hashedPassword, $email_address, $description, $favorites);

        if ($stmt->execute()) {
            $_SESSION['alert_message'] = 'You successfully registered! You can now login!';
            header('Location: /marmiteux/login');
            exit;
        } else {
            $_SESSION['alert_message'] = 'An error occurred, please retry!';
            header('Location: /marmiteux/register');
            exit;
        }

        $stmt->close();
        $db->close();
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        header('Location: /marmiteux');
        exit;
    }

    public function favorite()
    {
        echo 'Displaying favorites...';
    }

    public function myAccount()
    {
        session_start();

        if (!isset($_SESSION['id'])) {
            header('Location: /marmiteux/login');
            exit;
        }

        $userId = $_SESSION['id'];

        $db = new Database();

        $stmt = $db->prepare("SELECT name, surname, username, email_address, description FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            $stmt_user = $db->prepare("SELECT favorites FROM users WHERE id = ?");
            $stmt_user->bind_param("i", $userId);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();

            $user = $result_user->fetch_assoc();
            $favorites = json_decode($user['favorites'], true);

            if (is_array($favorites) && !empty($favorites)) {
                $ids_string = implode(',', $favorites);
                $stmt_favorites = $db->prepare("SELECT id, name, description, image_link, recipe FROM recipes WHERE id IN ($ids_string)");

                $stmt_favorites->execute();
                $result_favorites = $stmt_favorites->get_result();

                $favorites = [];
                while ($row = $result_favorites->fetch_assoc()) {
                    $favorites[] = $row;
                }

                $stmt_favorites->close();
            } else {
                $favorites = [];
            }

            $stmt_recipes = $db->prepare("SELECT id, name, description, recipe FROM recipes WHERE user_id = ?");
            $stmt_recipes->bind_param("i", $userId);
            $stmt_recipes->execute();
            $result_recipes = $stmt_recipes->get_result();

            $recipes = [];
            while ($row = $result_recipes->fetch_assoc()) {
                $recipes[] = $row;
            }

            include_once __DIR__ . '/../../resources/views/account/my-account.php';
        } else {
            echo 'User not found.';
        }

        $stmt->close();
        $stmt_recipes->close();
        $db->close();
    }
}
