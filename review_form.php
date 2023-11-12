<?php 

?>
<form action="submit_review.php" method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="mb-4">
            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div class="mb-4">
            <label for="vehicle">Véhicule :</label>
            <select id="vehicle" name="vehicle" required>
                <?php foreach ($vehicles as $vehicle) : ?>
                    <option value="<?php echo $vehicle['id']; ?>"><?php echo $vehicle['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="note">Note (de 1 à 5) :</label>
            <input type="number" id="note" name="note" min="1" max="5" required>
        </div>

        <div class="mb-4">
            <label for="comment">Commentaire :</label>
            <textarea id="comment" name="comment" rows="3" required></textarea>
        </div>

        <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                    800x400px)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" name="profile-pic" />
                        </label>
                    </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Soumettre</button>
    </form>