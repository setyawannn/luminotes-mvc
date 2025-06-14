<div class="flex-grow">
    <div class="mt-4">
        <a href="<?= BASEURL ?>/notes/add" class="flex gap-x-2"><img src="<?= BASEURL?>/img/icons/arrow-back.svg" alt="arrow-back"><h3 class="text-2xl">Notes Preview</h3></a>
        <p class="mt-4">Review your notes one last time before publishing to make sure everything's perfect!</p>
    </div>

    <div class="mt-8">
        <div class="flex gap-x-3 items-center">
            <img class="w-8 h-8 rounded-full object-cover" src="<?= BASEURL?>/img/person/person1.png" alt="User Profile">
            <p><?= $_SESSION['user_name'] ?? 'User' ?></p>
        </div>
        <div class="flex justify-between gap-x-4 mt-4">
            <div class="w-2/3">
                <h2 class="font-medium text-xl"><?=$data['preview_data']['title'] ?></h2>
                <p><?= nl2br($data['preview_data']['description']) ?></p>
            </div>
            <div class="w-1/3">
                <img src="<?= BASEURL?>/img/thubmnail/placeholder.png" alt="Placeholder">
                <p class="rounded-full text-sm border-2 p-1 mt-3 text-center w-fit"><?= $data['preview_data']['topics'] ?></p>
            </div>
        </div>
        <div class="mt-4 flex gap-x-6">
            </div>
    </div>

    <form action="<?= BASEURL ?>/notes/store" method="POST" enctype="multipart/form-data">
        <div class="flex flex-col gap-y-6 mt-10">
            <div class="flex flex-col gap-y-2">
                <label for="thumbnail">Thumbnail (Optional)</label>
                <div class="flex gap-x-4">
                    <input type="file" name="thumbnail" class="p-2 border w-full rounded" accept="image/*">
                </div>
            </div>
            <div class="flex flex-col gap-y-2">
                <div class="flex justify-between items-center">
                    <label for="thubmnail">File Preview</label>
                    <a href="<?= BASEURL ?>/uploads/notes/<?= $data['preview_data']['pdf_file'] ?>" download class="p-2 rounded border-2">
                        <img src="<?= BASEURL?>/img/icons/download.svg" alt="Download">
                    </a>
                </div>
                <iframe src="<?= $data['preview_data']['pdf_file'] ?>" frameborder="0" class="w-full h-96 rounded mt-4"></iframe>
            </div>
        </div>

        <div class="w-full flex flex-col my-4 justify-center items-center">
            <button type="submit" class="flex p-3 border w-full rounded justify-center bg-black text-white">Publish</button>
        </div>
    </form>
</div>