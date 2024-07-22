<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marmiteux - Favorites</title>
    <link href="<?php echo '/marmiteux/public/styles.css'; ?>" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/marmiteux/public/img/logo.ico">

</head>

<body class="bg-gray-100">

    <div>
        <?php include 'resources/views/components/sidebar.php'; ?>
        <?php if (isset($_SESSION['alert_message'])) : ?>
            <?php
            $alertMessage = $_SESSION['alert_message'];
            include 'resources/views/components/alertMessage.php';
            unset($_SESSION['alert_message']);
            ?>
        <?php endif; ?>


        <main class="py-10 lg:pl-72">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="px-4 sm:px-6 lg:px-8">

                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Favorites</h1>
                            <p class="mt-2 text-sm text-gray-700">A list of all your favorite recipes, you can manage everything here !</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a href="/marmiteux/my-account/recipes/create-recipe" class="block rounded-md bg-pink-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600">Create a recipe</a>
                        </div>
                    </div>
                    <div class="container mt-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <?php
                            $userFavorites = json_decode($currentUser['favorites'], true); // Convert the JSON in a PHP array
                            foreach ($recipes as $recipe) :
                                $isFavorite = in_array($recipe['id'], $userFavorites);
                            ?>
                                <div class="relative bg-white rounded-lg shadow-md p-8" data-recipe-id="<?php echo $recipe['id']; ?>">
                                    <div class="absolute top-0 favorite" style="right: -2rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-is-favorite="<?php echo $isFavorite ? 'true' : 'false'; ?>" fill="<?php echo $isFavorite ? '#db2777' : 'none'; ?>" class="w-8 h-8 absolute top-1/2 right-1/2 transform -translate-y-1/2 -translate-x-1/2" style="color: #db2777;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                        </svg>
                                    </div>
                                    <div class="w-full h-96">
                                        <img src="<?php echo ($recipe['image_link']); ?>" alt="Article Image" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex items-start mt-8">
                                        <div class="w-3/4">
                                            <h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($recipe['name']); ?></h2>
                                            <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($recipe['description']); ?></p>
                                            <a href="/marmiteux/recipe/<?php echo $recipe['id']; ?>" class="text-white bg-pink-600 hover:bg-pink-700 font-bold py-2 px-4 rounded">See the recipe ...</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>