document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded and parsed');
    const favoriteElements = document.querySelectorAll('.favorite');
    favoriteElements.forEach(function (element) {
        element.addEventListener('click', function () {
            if (!userConnected) {
                // Afficher le message d'alerte si l'utilisateur n'est pas connecté
                alert('Veuillez vous connecter pour ajouter cette recette en favoris.');
                return;
            }

            const recipeId = element.parentElement.getAttribute('data-recipe-id');
            let isFavorite = element.querySelector('svg').getAttribute('data-is-favorite') === 'true'; // Lire l'état à partir de l'attribut du SVG

            // Mise à jour visuelle du SVG
            const svgElement = element.querySelector('svg'); // Trouve le SVG à l'intérieur de l'élément
            if (isFavorite) {
                svgElement.setAttribute('fill', 'none');
                svgElement.setAttribute('data-is-favorite', 'false');
                isFavorite = false;
            } else {
                svgElement.setAttribute('fill', '#db2777');
                svgElement.setAttribute('data-is-favorite', 'true');
                isFavorite = true;
            }

            // Envoi de la requête AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/marmiteux/favorites/' + (isFavorite ? 'add' : 'remove'), true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('Recipe ' + (isFavorite ? 'added to' : 'removed from') + ' favorites: ' + recipeId);
                } else {
                    console.error('Error updating recipe favorite status');
                }
            };
            xhr.send('recipeId=' + recipeId);
        });
    });
});

document.getElementById('categorySelect').addEventListener('change', function () {
    var selectedCategory = this.value;
    var recipes = document.querySelectorAll('.recipe');

    recipes.forEach(function (recipe) {
        if (selectedCategory === "" || recipe.getAttribute('data-category-id') === selectedCategory) {
            recipe.style.display = 'block';
        } else {
            recipe.style.display = 'none';
        }
    });
});