<?php
$title = "Marmiteux - Recipe"; // Définir le titre de la page
$baseUri = "/marmiteux";
$headScripts = '<link rel="stylesheet" href="' . $baseUri . '/resources/css/index.css">';
$footerScripts = '<script src="' . $baseUri . '/resources/js/index.js"></script>';

ob_start();
?>
<!-- Contenu spécifique de la page -->
<div class="flex flex-col items-center">
    <div class="bg-gray-50 py-32 w-full flex flex-col items-center">
        <div class="container w-full">
            <h1 class="text-4xl font-bold text-center text-gray-900 mb-8">Marmiteux</h1>
            <p class="text-center text-gray-600">Where Every Recipe Tells a Story.</p>
        </div>
    </div>
    <?php
    // Définir si l'utilisateur est connecté
    $isUserConnected = isset($currentUser);

    // Passer cette information à JavaScript
    echo "<script>var userConnected = " . ($isUserConnected ? 'true' : 'false') . ";</script>";
    ?>

    <div class="container mt-16">
        <?php
        // Vérifiez si l'utilisateur est connecté et si ses favoris ne sont pas nuls, sinon définissez un tableau vide
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
                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($recipe['recipe']); ?></p>
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