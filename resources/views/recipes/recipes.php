<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marmiteux</title>
    <link href="<?php echo '/marmiteux/public/styles.css'; ?>" rel="stylesheet">

</head>

<body>

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
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Recipes</h1>
                            <p class="mt-2 text-sm text-gray-700">A list of all the recipes you created, you can manage everything here !</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a href="/marmiteux/my-account/recipes/create-recipe" class="block rounded-md bg-pink-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600">Create a recipe</a>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Recipe</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Grade</th>
                                                <th scope="col" class="relative  sm:pr-6">
                                                    <span class="sr-only">Edit</span>
                                                </th>
                                                <th scope="col" class="relative sm:pr-6">
                                                    <span class="sr-only">Delete</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">
                                            <?php if (!empty($recipes)) : ?>
                                                <?php foreach ($recipes as $recipe) : ?>
                                                    <tr>
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?php echo htmlspecialchars($recipe['name']); ?></td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($recipe['description']); ?></td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($recipe['recipe']); ?></td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Grade</td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <a href="/marmiteux/my-account/recipes/<?php echo $recipe['id']; ?>/edit-recipe/" class="text-indigo-600 hover:text-indigo-900">
                                                                Edit<span class="sr-only"><?php echo htmlspecialchars($recipe['name']); ?></span>
                                                            </a>
                                                        </td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <a href="/marmiteux/my-account/recipes/<?php echo $recipe['id']; ?>/delete-recipe/post" class="text-pink-600 hover:text-pink-900">
                                                                Delete<span class="sr-only"><?php echo htmlspecialchars($recipe['name']); ?></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <a href="/marmiteux/my-account/recipes/create-recipe" type="button" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                                    </svg>
                                                    <span class="mt-2 block text-sm font-semibold text-gray-900">You don't have any recipes yet, create your first one now !</span>
                                                </a>
                                            <?php endif; ?>
                                            <!-- More people... -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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