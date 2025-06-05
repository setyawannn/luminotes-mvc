<div class="mt-4 flex justify-between items-center">
    <a href="<?= BASEURL . '/teams/detail/' . $data['team']['id'] ?>" class="flex gap-x-2">
        <img src="<?= BASEURL; ?>/img/icons/arrow-back.svg" alt="arrow-back">
        <h3 class="text-3xl">Edit Team</h3>
    </a>
</div>
<div class="mt-4 flex flex-col flex-grow">  <form action="<?= BASEURL; ?>/teams/update/<?= $data['team']['id'] ?>" method="POST" class="flex flex-col flex-grow"> <div class="mb-4"> <div class="flex flex-col gap-y-4">
                <input type="text" name="name" value="<?= $data['team']['name'] ?>" placeholder="Team Name" class="p-2 border w-full rounded" required value="<?= $_POST['name'] ?? '' ?>">
                <textarea name="description" id="description" class="p-2 border w-full rounded" rows="4" placeholder="Description" required><?= $data['team']['description'] ?></textarea>
            </div>
        </div>
        <div class="flex gap-x-4 mt-auto pb-4">
            <a href="<?= BASEURL . '/teams/detail/' . $data['team']['id'] ?>" type="button" id="cancelButton" class="w-full text-center py-2 border-2 rounded text-black hover:bg-gray-100 hover:cursor-pointer">Cancel</a>
            <button type="submit" id="confirmButton" class="w-full text-center py-2 bg-black text-white rounded hover:cursor-pointer">Confirm</button>
        </div>
    </form>
</div>