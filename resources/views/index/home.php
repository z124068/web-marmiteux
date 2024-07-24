<?php
$title = "Marmiteux - Home";
$baseUri = "/marmiteux";

$headScripts = '<link rel="stylesheet" href="' . $baseUri . '/resources/css/index.css">';
$footerScripts = '<script src="' . $baseUri . '/resources/js/index.js"></script>';

ob_start();
?>
<div class="flex flex-col items-center">
    <div class="flex items-center justify-center bg-gray-50 pb-32 w-full">
        <div class="relative isolate -z-10 mt-32 sm:mt-40">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mx-auto flex max-w-2xl flex-col bg-white/5 px-6 sm:rounded-3xl sm:p-8 lg:mx-0 lg:max-w-none lg:flex-row-reverse lg:items-center xl:gap-x-20 xl:px-20">
                    <img class="h-36 w-36 flex-none object-cover  lg:h-auto lg:max-w-sm" src="/marmiteux/public/img/logo-png.png" alt="">
                    <div class="w-full flex-auto">
                        <h2 class="text-3xl font-bold tracking-tight text-red-300 sm:text-5xl">Marmiteux</h2>
                        <p class="mt-6 text-lg leading-8 text-gray-500">Where Every Recipe Tells a Story.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-16">
        <div class="flex items-center justify-end mb-8">
            <div class="relative">
                <select id="categorySelect" name="category" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <?php
        // Define if the user is connected
        $isUserConnected = isset($currentUser);

        // Pass this variable to the javascript
        echo "<script>var userConnected = " . ($isUserConnected ? 'true' : 'false') . ";</script>";
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php
            // Verify if the user is connected and if his favorites are not empty, otherwise set an empty array
            $userFavorites = $isUserConnected && !is_null($currentUser['favorites']) ? json_decode($currentUser['favorites'], true) : [];

            foreach ($recipes as $recipe) :
                $isFavorite = $isUserConnected ? in_array($recipe['id'], $userFavorites) : false;
            ?>
                <div class="relative bg-white rounded-lg shadow-md p-8 recipe" data-recipe-id="<?php echo $recipe['id']; ?>" data-category-id="<?php echo $recipe['recipe_type_id']; ?>">
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
                            <p class="mt-4 text-gray-600 mb-4"><?php echo htmlspecialchars($recipe['description']); ?></p>
                            <a href="/marmiteux/recipe/<?php echo $recipe['id']; ?>" class="mt-8 text-white bg-pink-600 hover:bg-pink-500 py-2 px-4 rounded">See the recipe ...</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../components/layout.php';
?>