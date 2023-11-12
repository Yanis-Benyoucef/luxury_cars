<?php 
require_once 'layout/header.php'; 
require_once __DIR__ . '/functions/getErrorMessage.php';
?>


<section>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            Connexion
        </a>
        <?php if (isset($_GET['error'])) { ?>
            <div class="p-4 bg-red-200 text-red-700">
            <?php echo getErrorMessage($_GET['error']) ?>
            </div>
        <?php
        } ?> 
        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="space-y-4 md:space-y-6" action="auth.php" method="POST">
                    <div>
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot
                            de passe</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="#"
                            class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Mot de
                            passe oublié ?</a>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Connexion</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Pas encore inscrit ? <a href="register.php"
                            class="font-medium text-blue-600 hover:underline dark:text-blue-500">Inscription</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'layout/footer.php';

