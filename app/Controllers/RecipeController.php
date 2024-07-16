<?php

// RecipeController.php

namespace App\Controllers;

require_once __DIR__ . '/../../Core/Database.php';

use Core\Database;


class RecipeController
{
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

    public function editRecipe()
    {
        // Logique pour afficher le formulaire d'édition de recette
        // Par exemple : include 'views/edit_recipe.php';
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

        // Récupération de l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id'];

        // Connexion à la base de données
        $db = new Database();

        // Préparation de la requête SQL sécurisée pour éviter les injections SQL
        $stmt = $db->prepare("INSERT INTO recipes (name, description, recipe, recipe_type_id, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $description, $recipe, $recipeTypeId, $userId); // Notez le "i" pour le paramètre $userId (entier)

        if ($stmt->execute()) {
            // Insertion réussie
            header('Location: /marmiteux/my-account'); // Redirection vers la page de mon compte après création de recette
            exit;
        } else {
            // Erreur lors de l'insertion
            echo 'Error: ' . $stmt->error;
        }

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $db->close();
    }
}
