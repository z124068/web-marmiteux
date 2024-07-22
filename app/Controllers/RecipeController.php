<?php

// RecipeController.php

namespace App\Controllers;

require_once __DIR__ . '/../../Core/Database.php';

use Core\Database;


class RecipeController
{

    public function recipes()
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
            include_once __DIR__ . '/../../resources/views/recipes/recipes.php';
        } else {
            // Gérer le cas où l'utilisateur n'existe pas (normalement ne devrait pas arriver ici)
            echo 'User not found.';
        }

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $stmt_recipes->close();
        $db->close();
    }

    public function createRecipe()
    {
        // Connexion à la base de données
        $db = new Database();

        // Préparer la requête SQL pour récupérer les types de recettes
        $stmt = $db->prepare("SELECT id, name FROM recipe_types");
        $stmt->execute();
        $stmt->store_result(); // Stocker le résultat pour pouvoir itérer plusieurs fois

        // Variables pour récupérer les résultats
        $id = null;
        $name = null;

        // Lier les résultats aux variables
        $stmt->bind_result($id, $name);

        // Récupérer les types de recettes dans un tableau
        $recipe_types = [];
        while ($stmt->fetch()) {
            $recipe_types[] = [
                'id' => $id,
                'name' => $name
            ];
        }

        // Inclure la vue en passant les informations des types de recettes
        include_once __DIR__ . '/../../resources/views/recipes/create-recipe.php';
    }

    public function editRecipe($id)
    {
        // Connexion à la base de données
        $db = new Database();

        // Préparer la requête SQL pour récupérer les informations de la recette
        $stmt = $db->prepare("SELECT id, name, description, recipe, favorite_nb, grade, grade_nb, status, recipe_type_id, user_id FROM recipes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérifier si la recette existe
        if ($result->num_rows === 1) {
            $recipe = $result->fetch_assoc();
        } else {
            // Gérer le cas où la recette n'existe pas
            echo 'Recipe not found.';
            exit;
        }

        // Préparer la requête SQL pour récupérer les types de recettes
        $stmt_types = $db->prepare("SELECT id, name FROM recipe_types");
        $stmt_types->execute();
        $stmt_types->store_result(); // Stocker le résultat pour pouvoir itérer plusieurs fois

        // Variables pour récupérer les résultats
        $recipe_type_id = null;
        $name = null;

        // Lier les résultats aux variables
        $stmt_types->bind_result($recipe_type_id, $name);

        // Récupérer les types de recettes dans un tableau
        $recipe_types = [];
        while ($stmt_types->fetch()) {
            $recipe_types[] = [
                'id' => $recipe_type_id,
                'name' => $name
            ];
        }

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $stmt_types->close();
        $db->close();

        // Inclure la vue en passant les informations de la recette et des types de recettes
        include_once __DIR__ . '/../../resources/views/recipes/edit-recipe.php';
    }

    public function processCreateRecipe()
    {
        session_start();

        // Récupération des données du formulaire
        $name = $_POST['name'];
        $description = $_POST['description'];
        $recipe = $_POST['recipe'];
        $recipeTypeId = $_POST['recipe_type_id'];
        $imageLink = $_POST['image_link'];

        // Récupération de l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id'];

        // Connexion à la base de données
        $db = new Database();

        // Préparation de la requête SQL sécurisée pour éviter les injections SQL
        $stmt = $db->prepare("INSERT INTO recipes (name, description, recipe, recipe_type_id, user_id, image_link) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $name, $description, $recipe, $recipeTypeId, $userId, $imageLink); // Correction du "i" pour le paramètre $userId (entier)

        if ($stmt->execute()) {
            // Insertion réussie
            $_SESSION['alert_message'] = "Your recipe has been successfully created!";
            header('Location: /marmiteux/my-account/recipes'); // Redirection vers la page de mon compte après création de recette
            exit;
        } else {
            $_SESSION['alert_message'] = "An error occurred. Please try again.";
            // Erreur lors de l'insertion
            echo 'Error: ' . $stmt->error;
        }

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $db->close();
    }


    public function processEditRecipe()
    {
        session_start();

        // Récupération des données du formulaire
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $recipe = $_POST['recipe'];
        $recipeTypeId = $_POST['recipe_type_id'];

        echo 'Id: ' . $id . ' Name: ' . $name . ' Description: ' . $description . ' Recipe: ' . $recipe . ' Recipe Type Id: ' . $recipeTypeId;

        // Récupération de l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id'];

        // Connexion à la base de données
        $db = new Database();

        // Récupérer les valeurs actuelles de la recette depuis la base de données
        $stmt = $db->prepare("SELECT name, description, recipe, recipe_type_id FROM recipes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $currentRecipe = $result->fetch_assoc();
        } else {
            // Gérer le cas où la recette n'existe pas ou n'appartient pas à l'utilisateur
            echo 'Recipe not found or you do not have permission to edit this recipe.';
            exit;
        }

        // Vérifier quelles valeurs ont changé
        $updateFields = [];
        if ($name !== $currentRecipe['name']) {
            $updateFields['name'] = $name;
        }
        if ($description !== $currentRecipe['description']) {
            $updateFields['description'] = $description;
        }
        if ($recipe !== $currentRecipe['recipe']) {
            $updateFields['recipe'] = $recipe;
        }
        if ($recipeTypeId !== $currentRecipe['recipe_type_id']) {
            $updateFields['recipe_type_id'] = $recipeTypeId;
        }

        // Construire la requête SQL de mise à jour dynamique
        if (!empty($updateFields)) {
            $setClause = [];
            $params = [];
            $types = '';

            foreach ($updateFields as $field => $value) {
                $setClause[] = "$field = ?";
                $params[] = $value;
                $types .= is_int($value) ? 'i' : 's';
            }

            $params[] = $id; // Ajoute l'ID à la fin
            $types .= 'i'; // Type pour l'ID

            $setClauseStr = implode(', ', $setClause);
            $stmt = $db->prepare("UPDATE recipes SET $setClauseStr WHERE id = ?");

            // Appeler bind_param avec les types et les valeurs
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                // Mise à jour réussie
                $_SESSION['alert_message'] = "Your recipe has been successfully edited!";
                header('Location: /marmiteux/my-account/recipes'); // Redirection vers la page des recettes après modification
                exit;
            } else {
                // Erreur lors de la mise à jour
                $_SESSION['alert_message'] = "An error occurred. Please try again.";

                echo 'Error: ' . $stmt->error;
            }

            // Fermeture de la connexion à la base de données
            $stmt->close();
        } else {
            // Aucun champ n'a été modifié
            header('Location: /marmiteux/my-account/recipes'); // Redirection vers la page des recettes
            exit;
        }

        $db->close();
    }

    public function processDeleteRecipe($id)
    {
        session_start();
        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id'];
        // Connexion à la base de données
        $db = new Database();
        // Préparer la requête SQL pour supprimer la recette
        $stmt = $db->prepare("DELETE FROM recipes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $userId);
        // Executer la requête
        if ($stmt->execute()) {
            // Stocker le message d'alerte dans la session
            $_SESSION['alert_message'] = "Your recipe has been successfully deleted!";
        } else {
            // En cas d'erreur, vous pouvez également stocker un message d'erreur
            $_SESSION['alert_message'] = "An error occurred. Please try again.";
        }
        // Fermer la requête
        $stmt->close();
        // Fermer la connexion à la base de données
        $db->close();
        // Rediriger l'utilisateur vers la page des recettes
        header('Location: /marmiteux/my-account/recipes');
        exit;
    }
}
