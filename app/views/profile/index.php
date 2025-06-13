<div class="flex-grow">
        <div class="mt-4">
            <a href="<?= BASEURL. '/dashboard' ?>" class="flex gap-x-2"><img src="<?= BASEURL; ?>/img/icons/arrow-back.svg" alt="arrow-back"><h3 class="text-2xl">Profile</h3></a>
        </div>
        <div class="mt-4">
            <div class="flex gap-x-4">
                <img src="<?= BASEURL; ?>/img/person/person1.png" alt="Person1" class="h-16 w-16 object-cover rounded-full">
                <div>
                    <h4 class="text-xl">Aristoteles</h4>
                    <p class="text-sm">Seorang mahasiswa FILKOM</p>
                </div>
            </div>
            <div class="w-full flex gap-x-3 mt-4">
                <a href="#" class="py-1 border-2 rounded w-full text-center">Edit Profile</a>
                <a href="<?= BASEURL; ?>/teams" class="py-1 border-2 rounded w-full text-center">Teams</a>
            </div>
            <div class="mt-4">
                <ul class="flex gap-x-4 text-lg border-b-1">
                    <li class="border-b-2">All</li>
                    <li>Owned</li>
                    <li>Teams</li>
                </ul>
            </div>
            <div class="mt-4">
                <select class="p-2 border w-full rounded">
                    <option value="">Status</option>
                    <option value="check">On Check</option>
                    <option value="rejected">Rejected</option>
                    <option value="approved">Approved</option>
                </select>
            </div>
            <div class="mt-6 flex flex-col gap-y-12">
                <?php foreach($data['notes'] as $note): ?>
                <div>
                    <div class="flex gap-x-3 items-center">
                        <img class="w-8 h-8 rounded-full object-cover" src="<?= BASEURL; ?>/img/person/<?= $note['creator']['img']; ?>" alt="<?= $note['creator']['name']; ?>">
                        <p><?= $note['creator']['name']; ?></p>
                    </div>
                    <div class="flex justify-between gap-x-4">
                        <div class="w-2/3">
                            <h2 class="font-medium text-xl"><?= $note['title']; ?></h2>
                            <p><?= $note['description']; ?></p>
                        </div>
                        <div class="w-1/3">
                            <img src="<?= BASEURL; ?>/img/thubmnail/<?= $note['thumbnail']; ?>" alt="<?= $note['category']; ?>">
                            <p class="rounded-full text-sm border-2 p-1 mt-3 w-fit text-center"><?= $note['category']; ?></p>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-x-6">
                        <div class="flex gap-x-3">
                            <img src="<?= BASEURL; ?>/img/icons/star-filled.svg" alt="star-filled">
                            <p><?= $note['rating']; ?></p>
                        </div>
                        <div class="flex gap-x-3">
                            <img src="<?= BASEURL; ?>/img/icons/calendar-today.svg" alt="calendar-today">
                            <p><?= $note['created_at']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>