<div class="flex-grow">
    <div class="mt-4">
        <a href="<?= BASEURL ?>/dashboard" class="flex gap-x-2"><img src="<?= BASEURL?>/img/icons/arrow-back.svg" alt="arrow-back"><h3 class="text-2xl">Create</h3></a>
    </div>
    <div class="mt-4">
        <form action="<?= BASEURL ?>/notes/preview" method="POST" enctype="multipart/form-data">
            <div class="flex flex-col gap-y-4">
                
                <div class="w-full h-48 border flex flex-col justify-center items-center rounded relative">
                    <h5 class="text-xl">Select File</h5>
                    <p>File supported only .pdf max 10 MB</p>
                    <label for="pdf_file" class="mt-4 px-2 py-1 bg-black text-white rounded cursor-pointer">Choose File</label>
                    <input type="file" id="pdf_file" name="pdf_file" class="hidden" accept=".pdf" required>
                </div>

                <input name="title" type="text" placeholder="Title" class="p-2 border w-full rounded" required>
                <textarea name="description" placeholder="Description" class="p-2 border w-full rounded" required></textarea>
                
                <select name="topics" class="p-2 border w-full rounded" required>
                    <option value="" disabled selected>Topics</option>
                    <option value="pemrograman">Pemrograman</option>
                    <option value="science">Science</option>
                    <option value="desain">Desain</option>
                </select>
                
                <select name="is_public" class="p-2 border w-full rounded" required>
                    <option value="" disabled selected>Publication</option>
                    <option value="1">Public</option> <option value="0">Private</option> </select>
                
                <select name="team_id" class="p-2 border w-full rounded">
                    <option value="">Team (Optional)</option>
                    <?php foreach ($data['teams'] as $team): ?>
                        <option value="<?= htmlspecialchars($team['id']) ?>">
                            <?= htmlspecialchars($team['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>
            
            <div class="w-full flex flex-col my-4 justify-center items-center">
                <button type="submit" class="flex p-3 border w-full rounded justify-center hover:cursor-pointer">Preview</button>
            </div>
        </form>
    </div>
</div>