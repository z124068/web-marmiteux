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
        <main class="py-10 lg:pl-72">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 md:px-8">
                <div class="py-4">

                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">


                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="card-title">Create your recipe !</h3>
                            <!-- We use less vertical padding on card headers on desktop than on body sections -->
                        </div>


                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                                <div>

                                    <div>
                                        <div class="px-4 py-5 sm:p-6">
                                            <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                                                <div>

                                                    <form action="/marmiteux/my-account/recipes/create-recipe/post" method="POST">
                                                        <div>
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                                General Informations
                                                            </h3>
                                                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                                                Provide some general informations about your recipe.
                                                            </p>
                                                        </div>

                                                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                                                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                                <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                                    Name
                                                                </label>
                                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                        <input type="text" name="name" id="name" required class="pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-pink-300 placeholder:text-gray-400 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6" placeholder="Chocolate Cake">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                                                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                                <label for="description" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                                    Description
                                                                </label>
                                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                        <input type="text" name="description" id="description"  required class="pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-pink-300 placeholder:text-gray-400 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6" placeholder="A delicious chocolate cake">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                                                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                                <label for="description" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                                    Recipe
                                                                </label>
                                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                        <input type="text-area" name="recipe" id="recipe" required class="pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-pink-300 placeholder:text-gray-400 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6" placeholder="Start by adding some ingredients...">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                                                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                                <label for="recipe_type_id" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                                    Recipe Type
                                                                </label>
                                                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                                    <select id="recipe_type_id" name="recipe_type_id" class="mt-2 pt-2 pb-2 block w-1/4 rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-pink-300 focus:ring-2 focus:ring-pink-600 sm:text-sm sm:leading-6">
                                                                    <option value="" class="text-gray-400">Please Choose a Recipe Type</option>
                                                                        <?php foreach ($recipe_types as $recipe_type) { ?>
                                                                            <option value="<?php echo $recipe_type['id']; ?>"><?php echo $recipe_type['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="mt-8 border-t border-gray-200 pt-5">
                                                            <div class="pt-5">
                                                                <div class="flex justify-end">
                                                                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                                                        Abbrechen
                                                                    </button>
                                                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                                                        Speichern
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

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