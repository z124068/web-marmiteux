<?php

// RecipeController.php

namespace App\Controllers;

require_once __DIR__ . '/../../Core/Database.php';

use Core\Database;
use \Exception;


class RecipeController
{

    public function recipes()
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

            $stmt_recipes = $db->prepare("SELECT id, name, description , recipe FROM recipes WHERE user_id = ?");
            $stmt_recipes->bind_param("i", $userId);
            $stmt_recipes->execute();
            $result_recipes = $stmt_recipes->get_result();

            $recipes = [];
            while ($row = $result_recipes->fetch_assoc()) {
                $recipes[] = $row;
            }

            include_once __DIR__ . '/../../resources/views/recipes/recipes.php';
        } else {
            echo 'User not found.';
        }

        $stmt->close();
        $stmt_recipes->close();
        $db->close();
    }

    public function createRecipe()
    {
        $db = new Database();

        $stmt = $db->prepare("SELECT id, name FROM recipe_types");
        $stmt->execute();
        $stmt->store_result(); 

        $id = null;
        $name = null;

        $stmt->bind_result($id, $name);

        $recipe_types = [];
        while ($stmt->fetch()) {
            $recipe_types[] = [
                'id' => $id,
                'name' => $name
            ];
        }

        include_once __DIR__ . '/../../resources/views/recipes/create-recipe.php';
    }

    public function editRecipe($id)
    {
        $db = new Database();

        $stmt = $db->prepare("SELECT id, name, description, recipe, favorite_nb, grade, grade_nb, status, recipe_type_id, user_id, image_link FROM recipes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $recipe = $result->fetch_assoc();
        } else {
            echo 'Recipe not found.';
            exit;
        }

        $stmt_types = $db->prepare("SELECT id, name FROM recipe_types");
        $stmt_types->execute();
        $stmt_types->store_result();

        $recipe_type_id = null;
        $name = null;

        $stmt_types->bind_result($recipe_type_id, $name);

        $recipe_types = [];
        while ($stmt_types->fetch()) {
            $recipe_types[] = [
                'id' => $recipe_type_id,
                'name' => $name
            ];
        }

        $stmt->close();
        $stmt_types->close();
        $db->close();

        include_once __DIR__ . '/../../resources/views/recipes/edit-recipe.php';
    }

    public function processCreateRecipe()
    {
        session_start();

        $name = $_POST['name'];
        $description = $_POST['description'];
        $recipe = $_POST['recipe'];
        $recipeTypeId = $_POST['recipe_type_id'];
        $imageLink = $_POST['image_link'];

        $userId = $_SESSION['id'];

        $db = new Database();

        $stmt = $db->prepare("INSERT INTO recipes (name, description, recipe, recipe_type_id, user_id, image_link) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $name, $description, $recipe, $recipeTypeId, $userId, $imageLink);

        if ($stmt->execute()) {
            $_SESSION['alert_message'] = "Your recipe has been successfully created!";
            header('Location: /marmiteux/my-account/recipes'); 
            exit;
        } else {
            $_SESSION['alert_message'] = "An error occurred. Please try again.";
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
        $db->close();
    }


    public function processEditRecipe()
    {
        session_start();

        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $recipe = $_POST['recipe'];
        $recipeTypeId = $_POST['recipe_type_id'];

        echo 'Id: ' . $id . ' Name: ' . $name . ' Description: ' . $description . ' Recipe: ' . $recipe . ' Recipe Type Id: ' . $recipeTypeId;

        $userId = $_SESSION['id'];

        $db = new Database();

        $stmt = $db->prepare("SELECT name, description, recipe, recipe_type_id FROM recipes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $currentRecipe = $result->fetch_assoc();
        } else {
            
            echo 'Recipe not found or you do not have permission to edit this recipe.';
            exit;
        }

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

        if (!empty($updateFields)) {
            $setClause = [];
            $params = [];
            $types = '';

            foreach ($updateFields as $field => $value) {
                $setClause[] = "$field = ?";
                $params[] = $value;
                $types .= is_int($value) ? 'i' : 's';
            }

            $params[] = $id; 
            $types .= 'i'; 

            $setClauseStr = implode(', ', $setClause);
            $stmt = $db->prepare("UPDATE recipes SET $setClauseStr WHERE id = ?");

            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $_SESSION['alert_message'] = "Your recipe has been successfully edited!";
                header('Location: /marmiteux/my-account/recipes'); 
                exit;
            } else {
                $_SESSION['alert_message'] = "An error occurred. Please try again.";

                echo 'Error: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            header('Location: /marmiteux/my-account/recipes'); 
            exit;
        }

        $db->close();
    }


    public function processDeleteRecipe($id)
    {
        session_start();
        $userId = $_SESSION['id'];

        $db = new Database();
        $conn = $db->getConnection(); 

        $conn->begin_transaction();

        try {
            
            $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $userId);

            if (!$stmt->execute()) {
                throw new \Exception("An error occurred while deleting the recipe.");
            }

            $stmt->close();

            $stmt = $conn->prepare("SELECT id, favorites FROM users WHERE favorites IS NOT NULL");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($user = $result->fetch_assoc()) {
                $favorites = json_decode($user['favorites'], true);

               
                if (is_array($favorites)) {
                    if (($key = array_search($id, $favorites)) !== false) {
                        unset($favorites[$key]);
                        $favorites = array_values($favorites);

                        $updatedFavorites = json_encode($favorites);
                        $updateStmt = $conn->prepare("UPDATE users SET favorites = ? WHERE id = ?");
                        $updateStmt->bind_param("si", $updatedFavorites, $user['id']);
                        if (!$updateStmt->execute()) {
                            throw new \Exception("An error occurred while updating user favorites.");
                        }
                        $updateStmt->close();
                    }
                }
            }

            $stmt->close();

            $conn->commit();

            $_SESSION['alert_message'] = "Your recipe has been successfully deleted!";
        } catch (\Exception $e) {
            $conn->rollback();
            $_SESSION['alert_message'] = $e->getMessage();
        }

        $conn->close();

        header('Location: /marmiteux/my-account/recipes');
        exit;
    }
}
