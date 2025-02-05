<div>
    <div id="mobile-menu" class="relative z-50 hidden" role="dialog" aria-modal="true">

        <div class="fixed inset-0 bg-gray-900/80" aria-hidden="true"></div>

        <div class="fixed inset-0 flex">

            <div class="relative mr-16 flex w-full max-w-xs flex-1">

                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button id="close-menu" type="button" class="-m-2.5 p-2.5">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-pink-600 px-6 pb-2">
                    <div class="flex h-16 shrink-0 items-center">
                        <a href="/marmiteux/" class="flex items-center">
                            <img src="/marmiteux/public/img/logo-png.png" alt="logo" class="w-10 rounded-full">
                        </a>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    <?php
                                    // Define the page names based on URL
                                    $pageNames = [
                                        '/marmiteux/my-account' => 'Dashboard',
                                        '/marmiteux/my-account/recipes' => 'Recipes',
                                        '/marmiteux/my-account/favorites' => 'Favorites',
                                        '/marmiteux' => 'Home'
                                    ];

                                    // Get the current URL path
                                    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                                    // Get the current page name
                                    $currentPageName = $pageNames[$currentPath] ?? 'Dashboard';
                                    ?>
                                    <li>
                                        <a href="/marmiteux/my-account" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 <?= $currentUrl === 'http://localhost/marmiteux/my-account' ? 'bg-pink-700' : '' ?> text-pink-200 hover:bg-pink-700 hover:text-white">
                                            <svg class="h-6 w-6 shrink-0 text-pink-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/marmiteux/my-account/recipes" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 <?= $currentUrl === 'http://localhost/marmiteux/my-account/recipes' ? 'bg-pink-700' : '' ?> text-pink-200 hover:bg-pink-700 hover:text-white">
                                            <svg class="h-6 w-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                            </svg>
                                            Recipes
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/marmiteux/my-account/favorites" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 <?= $currentUrl === 'http://localhost/marmiteux/my-account/favorites' ? 'bg-pink-700' : '' ?> text-pink-200 hover:bg-pink-700 hover:text-white">
                                            <svg class="h-6 w-6 shrink-0 text-pink-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            Favorites
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/marmiteux" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-pink-200 hover:bg-pink-700 hover:text-white">
                                            <svg class="h-6 w-6 shrink-0 text-pink-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                            Home
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li class="-mx-6 mt-auto">
                                <a href="/marmiteux/logout" class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-pink-700">
                                    <span class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>

                                    <span aria-hidden="true">Sign out</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-pink-600 px-6">
            <div class="flex h-16 shrink-0 items-center">
                <a href="/marmiteux/" class="flex items-center">
                    <img src="/marmiteux/public/img/logo-png.png" alt="logo" class="w-10 rounded-full">
                </a>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <?php
                            // Get the current URL
                            $currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            ?>
                            <li>
                                <a href="/marmiteux/my-account" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 <?= $currentUrl === 'http://localhost/marmiteux/my-account' ? 'bg-pink-700' : '' ?> text-pink-200 hover:bg-pink-700 hover:text-white">
                                    <svg class="h-6 w-6 shrink-0 text-pink-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="/marmiteux/my-account/recipes" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 <?= $currentUrl === 'http://localhost/marmiteux/my-account/recipes' ? 'bg-pink-700' : '' ?> text-pink-200 hover:bg-pink-700 hover:text-white">
                                    <svg class="h-6 w-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                    My Recipes
                                </a>
                            </li>
                            <li>
                                <a href="/marmiteux/my-account/favorites" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 <?= $currentUrl === 'http://localhost/marmiteux/my-account/favorites' ? 'bg-pink-700' : '' ?> text-pink-200 hover:bg-pink-700 hover:text-white">
                                    <svg class="h-6 w-6 shrink-0 text-pink-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    My Favorites
                                </a>
                            </li>
                            <li>
                                <a href="/marmiteux" class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-pink-200 hover:bg-pink-700 hover:text-white">
                                    <svg class="h-6 w-6 shrink-0 text-pink-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    Home
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="-mx-6 mt-auto">
                        <a href="/marmiteux/logout" class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-pink-700">
                            <span class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>

                            <span aria-hidden="true">Disconnect</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-pink-600 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
        <button id="open-menu" type="button" class="-m-2.5 p-2.5 text-pink-200 lg:hidden">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <div class="flex-1 text-sm font-semibold leading-6 text-white"><?= $currentPageName ?></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openButton = document.getElementById('open-menu'); 
            const closeButton = document.getElementById('close-menu'); 
            const mobileMenu = document.getElementById('mobile-menu'); 



            openButton.addEventListener('click', function() {
                mobileMenu.classList.remove('hidden');
            });

            closeButton.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        });
    </script>
</div>