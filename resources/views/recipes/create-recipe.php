<?php
$title = "Marmiteux - Create Recipe";
$baseUri = "/marmiteux/my-account/recipes/create-recipe";
$headScripts = '<link rel="stylesheet" href="' . $baseUri . '/resources/css/index.css">';
$footerScripts = '<script src="' . $baseUri . '/resources/js/index.js"></script>';

ob_start();
?>
<div>
    <div class="max-w-8xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4">

            <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">


                <div class="px-4 py-5 sm:px-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            General Informations
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Provide some general informations about your recipe.
                        </p>
                    </div>
                </div>


                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                        <div>

                            <div>
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                                        <div>

                                            <form action="/marmiteux/my-account/recipes/create-recipe/post" method="POST">


                                                <div class=" space-y-6 sm:space-y-5">
                                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start ">
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
                                                                <input type="text" name="description" id="description" required class="pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-pink-300 placeholder:text-gray-400 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6" placeholder="A delicious chocolate cake">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                        <label for="recipe" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                            Recipe
                                                        </label>
                                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                            <textarea name="recipe" id="recipe" required rows="10" class="pl-4 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-pink-300 placeholder:text-gray-400 focus:ring-inset focus:ring-pink-600 sm:text-sm sm:leading-6" placeholder="Step 1: ...&#10;Step 2: ...&#10;Step 3: ..."></textarea>
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

                                                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                        <label for="image_link" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                            Image URL
                                                        </label>
                                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                            <div class="sm:grid sm:grid-cols-1 sm:gap-4 sm:items-start">
                                                                <input type="url" name="image_link" id="image_link" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-pink-300 focus:ring-2 focus:ring-pink-600 sm:text-sm sm:leading-6" placeholder="https://example.com/image.jpg">
                                                                <img src="" id="image-preview" class="mt-1 sm:mt-0 sm:col-span-1 object-cover h-48 w-96 rounded-lg shadow-lg" style="display:none;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        const imageUrlInput = document.querySelector('#image_link');
                                                        const imagePreview = document.querySelector('#image-preview');

                                                        imageUrlInput.addEventListener('input', event => {
                                                            if (event.target.value) {
                                                                imagePreview.style.display = 'block';
                                                                imagePreview.src = event.target.value;
                                                            } else {
                                                                imagePreview.style.display = 'none';
                                                            }
                                                        });
                                                    </script>
                                                    <style>
                                                        #image-preview {
                                                            object-fit: cover;
                                                            height: 300px;
                                                            width: 600px;
                                                        }
                                                    </style>
                                                </div>

                                                <div class="mt-8 border-t border-gray-200 pt-5">
                                                    <div class="pt-5">
                                                        <div class="flex justify-end">
                                                            <a href="/marmiteux/my-account/recipes" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                                                Cancel
                                                            </a>
                                                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                                                Submit
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
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../components/layoutDashboard.php';
?>