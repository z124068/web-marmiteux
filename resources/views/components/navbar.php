<nav class="bg-pink-600 fixed top-0 left-0 right-0 z-50 flex items-center justify-between py-3 px-8">
    <a href="/marmiteux/" class="flex items-center">
        <img src="/marmiteux/public/img/logo.png" alt="logo" class="w-10 rounded-full">
    </a>
    <div class="flex-grow flex justify-end">
        <ul class="flex space-x-8">
            <?php if ($userConnected) : ?>
                <li><a class="text-white hover:text-gray-700" href="/marmiteux/my-account/favorites">Favorite</a></li>
                <li><a class="text-white hover:text-gray-700" href="/marmiteux/my-account">My Account</a></li>
            <?php else : ?>
                <li><a class="text-white hover:text-gray-700" href="/marmiteux/login">Login</a></li>
                <li><a class="text-white bg-pink-600 hover:bg-pink-700 font-bold py-2 px-4 rounded" href="/marmiteux/register">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>