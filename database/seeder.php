<?php

// Inclusion de votre fichier de configuration de base de données (par exemple db.php)
// Assurez-vous d'avoir défini les paramètres de connexion à votre base de données

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marmiteux";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requêtes d'insertion pour chaque table

// Exemple d'insertion pour la table recipe_types
$sql = "INSERT INTO recipe_types (name, description, status)
        VALUES ('Appetizer', 'Description of appetizer type', 'active'),
               ('Main Course', 'Description of main course type', 'active'),
               ('Dessert', 'Description of dessert type', 'active')";
if ($conn->query($sql) === TRUE) {
    echo "Data successfully inserted into the recipe_types table.<br>";
} else {
    echo "Error during data insertion: " . $conn->error . "<br>";
}

// Exemple d'insertion pour la table users
$sql = "INSERT INTO users (username, email_address, password, description, status)
        VALUES ('mathis', 'mathis.bertrand@gmail.com', 'mathis06', 'an happy user who love to cook!', 'active')";
if ($conn->query($sql) === TRUE) {
    echo "Data successfully inserted into the users table.<br>";
} else {
    echo "Error during data insertion: " . $conn->error . "<br>";
}

// Exemple d'insertion pour la table recipes
$sql = "INSERT INTO recipes (name, description, recipe, favorite_nb, grade, grade_nb, status, recipe_type_id, user_id)
        VALUES ('Pasta Bolognese', 'Pasta bolognese recipe', 'Cook pasta, add tomato sauce, add beef', 0, 0, 0, 'active', 2, 1),
               ('Chocolate Cake', 'Chocolate cake recipe', 'Mix ingredients, bake cake', 0, 0, 0, 'active', 3, 1),
               ('Tomato Salad', 'Tomato salad recipe', 'Cut tomatoes, add basil, add dressing', 0, 0, 0, 'active', 1, 1)";
if ($conn->query($sql) === TRUE) {
    echo "Data successfully inserted into the recipes table.<br>";
} else {
    echo "Error during data insertion: " . $conn->error . "<br>";
}

// Insert other data for the users and recipes tables in a similar manner
// 
// Fermeture de la connexion
$conn->close();
