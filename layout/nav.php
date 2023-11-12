<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 gap-x-7">
        <a href="index.php" class="flex items-center">
            <img src="https://i.pinimg.com/564x/e0/88/e0/e088e0a85d0ae1ed1ee2a1d03a676b41.jpg" class="h-8 mr-3" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Luxury Cars</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col items-center p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <?php if (!isset($_SESSION['userInfos'])) { ?>
                    <li>
                        <a href="login.php" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500">Connexion</a>
                    </li>
                    <li>
                        <a href="register.php" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500">Inscription</a>
                    </li> 
                <?php } else { ?>
                    <li class="flex items-center dark:text-white">
        <img src="<?php echo $_SESSION['userInfos']['picture']; ?>" class="h-8 mr-3" alt="Photo de profil" />
        <span><?php echo $_SESSION['userInfos']['first_name']; ?></span>
    </li>
    <li>
        <a href="avis.php" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded dark:text-white md:dark:text-blue-500">Avis</a>
    </li>
    <li>
        <a href="logout.php" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded dark:text-white md:dark:text-blue-500">Déconnexion</a>
    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
