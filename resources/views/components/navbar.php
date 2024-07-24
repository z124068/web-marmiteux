<nav class="bg-pink-600">
    <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
        <div class="relative w-full flex h-16 items-center justify-between">
            <div class="flex items-center px-2 lg:px-0">
                <div class="flex-shrink-0">
                    <a href="/marmiteux/"><img src="/marmiteux/public/img/logo-png.png" alt="logo" class="w-14 rounded-full"></a>
                </div>

            </div>
            <div class="hidden lg:ml-6 lg:block">
                <div class="flex space-x-4">
                    <?php if ($userConnected) : ?>

                        <a href="/marmiteux/my-account/favorites" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-pink-700 hover:text-white">My Favorites</a>
                        <a href="/marmiteux/my-account" class="rounded-md bg-pink-700 px-3 py-2 text-sm font-medium text-white">My Account</a>

                    <?php else : ?>
                        <a href="/marmiteux/login" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-pink-700 hover:text-white">Login</a>
                        <a href="/marmiteux/register" class="rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-pink-700 hover:text-white">Register</a>

                    <?php endif; ?>

                </div>
            </div>

            <div class="flex lg:hidden">
                
                <button type="button" id="open-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-pink-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>

                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                    <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <div class="lg:hidden hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2">

        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
            <div class="flex items-center px-5">

                <button type="button" id="close-menu" class="relative ml-auto flex-shrink-0 rounded-full bg-pink-600 p-1 text-white hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="absolute -inset-1.5"></span>
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
            <div class="mt-3 space-y-1 px-2">


                <?php if ($userConnected) : ?>

                    <a href="/marmiteux/my-account/favorites" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-pink-700 hover:text-white">my Favorites</a>
                    <a href="/marmiteux/my-account" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-pink-700 hover:text-white">My Account</a>
                    <a href="/marmiteux/logout" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-pink-700 hover:text-white">Sign out</a>



                <?php else : ?>

                    <a href="/marmiteux/login" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-pink-700 hover:text-white">Sign in</a>
                    <a href="/marmiteux/register" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-pink-700 hover:text-white">Register</a>

                <?php endif; ?>
            </div>
        </div>
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
</nav>