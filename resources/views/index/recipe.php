<?php
$title = "Marmiteux - Recipe";
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
    <?php
    // Define if the user is connected
    $isUserConnected = isset($currentUser);

    // Pass this information to JavaScript
    echo "<script>var userConnected = " . ($isUserConnected ? 'true' : 'false') . ";</script>";
    ?>

    <div class="container mt-16">
        <?php
        // Verify if the user is connected and if his favorites are not empty, otherwise set an empty array
        $userFavorites = $isUserConnected && !is_null($currentUser['favorites']) ? json_decode($currentUser['favorites'], true) : [];

        $isFavorite = $isUserConnected ? in_array($recipe['id'], $userFavorites) : false;
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
                    <p class="text-gray-600 mb-4">
                        <?php
                        // Get the recipe text
                        $recipeText = htmlspecialchars($recipe['recipe']);

                        // Convert the newlines to <br>
                        $formattedRecipe = nl2br($recipeText);

                        // Add a <br> before each "STEP" and format "STEP" in bold and underlined
                        $formattedRecipe = preg_replace('/(Step \d+)/', '<br><strong><u>$1</u></strong>', $formattedRecipe);

                        // If the text starts with "STEP", remove the first <br> added
                        // Display the formatted text
                        echo $formattedRecipe;
                        ?>


                    </p>


                </div>
            </div>
        </div>
        <?php ?>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../components/layout.php';
?>