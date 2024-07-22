<?php

namespace App\Controllers;

// Inclusion de la classe Database
require_once __DIR__ . '/../../Core/Database.php';

use Core\Database;

class PageController
{
    public function index()
    {
        session_start();

        // Vérifier si l'utilisateur est connecté et récupérer l'ID
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
        // Connexion à la base de données
        $db = new Database();

        // Récupérer toutes les catégories de recettes
        $stmt_categories = $db->prepare("SELECT id, name FROM recipe_types");
        $stmt_categories->execute();
        $result_categories = $stmt_categories->get_result();

        // Convertir les catégories en un tableau
        $categories = [];
        while ($row = $result_categories->fetch_assoc()) {
            $categories[] = $row;
        }


        // Préparer la requête SQL pour récupérer toutes les recettes
        $stmt_recipes = $db->prepare("SELECT id, name, description, image_link, recipe, recipe_type_id FROM recipes");
        $stmt_recipes->execute();
        $result_recipes = $stmt_recipes->get_result();

        // Récupérer les recettes dans un tableau
        $recipes = [];
        while ($row = $result_recipes->fetch_assoc()) {
            $recipes[] = $row;
        }

        // Inclure la vue en passant les informations de l'utilisateur et les recettes
        include_once __DIR__ . '/../../resources/views/index/home.php';

        // Fermeture de la connexion à la base de données
        $stmt_recipes->close();
        $db->close();
    }

    public function recipe($id)
    {
        // Vérifier si l'utilisateur est connecté et récupérer l'ID
        session_start();

        // Vérifier si l'utilisateur est connecté et récupérer l'ID
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
        // Connexion à la base de données
        $db = new Database();

        // Préparer la requête SQL pour récupérer toutes les recettes
        $stmt_recipe = $db->prepare("SELECT id, name, description, image_link, recipe FROM recipes where id = ?");
        $stmt_recipe->bind_param("i", $id);
        $stmt_recipe->execute();
        $result_recipe = $stmt_recipe->get_result();
        $recipe = $result_recipe->fetch_assoc();

        // Inclure la vue en passant les informations de l'utilisateur et la recette
        include_once __DIR__ . '/../../resources/views/index/recipe.php';

        // Fermeture de la connexion à la base de données
        $stmt_recipe->close();
        $db->close();
    }

    public function login()
    {
        // Affiche le formulaire de login
        include_once __DIR__ . '/../../resources/views/account/login.php';
    }

    public function processLogin()
    {
        session_start();

        // Récupération des données du formulaire
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connexion à la base de données
        $db = new Database();

        // Prépare la requête SQL sécurisée pour éviter les injections SQL
        $stmt = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérification de l'utilisateur
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Authentification réussie
                $_SESSION['id'] = $user['id']; // Enregistrement de l'ID de l'utilisateur
                $_SESSION['username'] = $user['username'];
                header('Location: /marmiteux'); // Redirection vers la page d'accueil après login
                exit;
            } else {
                // Mot de passe incorrect
                $_SESSION['alert_message'] = 'Invalid username or password';
                header('Location: /marmiteux/login');
                exit;
            }
        } else {
            // Utilisateur non trouvé
            $_SESSION['alert_message'] = 'Invalid username or password';
            header('Location: /marmiteux/login');
            exit;
        }

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $db->close();
    }


    public function register()
    {
        // Affiche le formulaire d'inscription
        include_once __DIR__ . '/../../resources/views/account/register.php';
    }

    public function processRegister()
    {
        // Connexion à la base de données
        $db = new Database();

        // Récupération des données du formulaire
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email_address = $_POST['email_address'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $description = $_POST['description'];

        // Vérifier si l'utilisateur existe déjà
        $checkQuery = "SELECT * FROM users WHERE email_address = '$email_address' OR username = '$username'";
        $checkResult = $db->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "User with that email or username already exists!";
            return;
        }

        // Hasher le mot de passe (optionnel mais recommandé)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête SQL pour insérer l'utilisateur
        $sql = "INSERT INTO users (name, surname, username, password, email_address,  description) 
                VALUES ('$name', '$surname', '$username', '$hashedPassword', '$email_address', '$description')";

        // Exécuter la requête SQL
        if ($db->query($sql)) {
            $_SESSION['alert_message'] = 'You successfully registered! You can now login !';
            header('Location: /marmiteux/login');
            exit;
        } else {
            $_SESSION['alert_message'] = 'An error occured, please retry !';
            header('Location: /marmiteux/register');
            exit;
        }

        // Fermeture de la connexion à la base de données
        $db->close();
    }

    public function logout()
    {
        session_start();
        // Supprimer toutes les variables de session
        $_SESSION = [];
        // Détruire la session
        session_destroy();
        // Rediriger l'utilisateur vers la page d'accueil ou la page de login
        header('Location: /marmiteux');
        exit;
    }

    public function favorite()
    {
        // Exemple d'action pour la page de favoris
        echo 'Displaying favorites...';
    }

    public function myAccount()
    {
        session_start();

        // Vérifier si l'utilisateur est connecté et récupérer l'ID
        if (!isset($_SESSION['id'])) {
            // Redirection vers la page de login si l'utilisateur n'est pas connecté
            header('Location: /marmiteux/login');
            exit;
        }

        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id'];

        // Connexion à la base de données
        $db = new Database();

        // Préparer la requête SQL pour récupérer les informations de l'utilisateur
        $stmt = $db->prepare("SELECT name, surname, username, email_address, description FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérifier si l'utilisateur existe (devrait toujours être le cas ici)
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // get favorites in user table, it is a json with number inside. take this number, and get all recipes that got for id, these numbers
            $stmt_user = $db->prepare("SELECT favorites FROM users WHERE id = ?");
            $stmt_user->bind_param("i", $userId);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();

            // Récupérer les favoris de l'utilisateur
            $user = $result_user->fetch_assoc();
            $favorites = json_decode($user['favorites'], true); // Convert the JSON in a PHP array

            // Vérifiez si $favorites est un tableau et non vide
            if (is_array($favorites) && !empty($favorites)) {
                // Préparer la requête SQL pour récupérer les recettes favorites
                $ids_string = implode(',', $favorites);
                $stmt_favorites = $db->prepare("SELECT id, name, description, image_link, recipe FROM recipes WHERE id IN ($ids_string)");

                $stmt_favorites->execute();
                $result_favorites = $stmt_favorites->get_result();

                // Récupérer les recettes dans un tableau
                $favorites = [];
                while ($row = $result_favorites->fetch_assoc()) {
                    $favorites[] = $row;
                }

                $stmt_favorites->close();
            } else {
                // Si $favorites n'est pas un tableau ou est vide, initialiser comme un tableau vide
                $favorites = [];
            }

            // Préparer la requête SQL pour récupérer les recettes de l'utilisateur
            $stmt_recipes = $db->prepare("SELECT id, name, description, recipe FROM recipes WHERE user_id = ?");
            $stmt_recipes->bind_param("i", $userId);
            $stmt_recipes->execute();
            $result_recipes = $stmt_recipes->get_result();

            // Récupérer les recettes dans un tableau
            $recipes = [];
            while ($row = $result_recipes->fetch_assoc()) {
                $recipes[] = $row;
            }

            // Inclure la vue en passant les informations de l'utilisateur et les recettes
            include_once __DIR__ . '/../../resources/views/account/my-account.php';
        } else {
            // Gérer le cas où l'utilisateur n'existe pas (normalement ne devrait pas arriver ici)
            echo 'User not found.';
        }

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $stmt_recipes->close();
        $db->close();
    }
}
