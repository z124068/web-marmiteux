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

        // Vérifier si l'utilisateur est connecté
        $userConnected = isset($_SESSION['id']);

        // Inclure la vue en passant l'état de connexion
        include_once __DIR__ . '/../../resources/views/index/home.php';
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
                echo 'Invalid username or password. <a href="/marmiteux/login">Back to Login</a>';
            }
        } else {
            // Utilisateur non trouvé
            echo 'Invalid username or password. <a href="/marmiteux/login">Back to Login</a>';
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
            echo "You created your account successfully, you can now login.";
            header("refresh:2;url=/marmiteux/login");
            // Rediriger l'utilisateur vers une page de confirmation ou vers le login
            // header('Location: /marmiteux/login'); // Rediriger vers la page de login
        } else {
            echo "Error creating user: ";
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

            // Préparer la requête SQL pour récupérer les recettes de l'utilisateur
            $stmt_recipes = $db->prepare("SELECT id, name, description , recipe FROM recipes WHERE user_id = ?");
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
