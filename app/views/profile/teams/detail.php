    <div class="mt-4 flex justify-between w-full">
        <a href="<?= BASEURL; ?>/teams" class="flex gap-x-2 w-full"><img src="<?= BASEURL; ?>/img/icons/arrow-back.svg" alt="arrow-back">
            <h3 class="text-3xl w-full"><?= $data['teamData']['team']['name'] ?></h3>
        </a>
    </div>
    <div class="mt-4">
        <div class="flex flex-col gap-y-4">
            <p>Here's your team code copy and share to your friend</p>
            <div class="flex justify-center items-center gap-x-4">
                <input type="text" id="teamCode" placeholder="Team Code" class="p-2 border-2 w-full rounded" value="<?= $data['teamData']['team']['code'] ?>" readonly>
                <button id="copyButton" class="px-4 py-2 rounded border-2">Copy</button>
            </div>
            <p>Invite your friends to join your study group! Add them to your team and start collaborating on notes
                and learning together.</p>
        </div>
        <div class="mt-6">
            <div class="mb-4">
                <h6>Team Leader</h6>
                <div class="flex items-center gap-x-4">
                    <img src="<?= BASEURL . '/img/person/' . $data['teamData']['leader']['image'] ?>" alt="Person1"
                        class="w-10 h-10 object-cover rounded-full">
                    <p><?= $data['teamData']['leader']['name'] ?></p>
                </div>
            </div>
            <div>
                <h6>Team Member</h6>
                <div class="flex flex-col gap-y-4">
                    <?php foreach($data['teamData']['members'] as $member) : ?>
                        <div class="flex items-center justify-between gap-x-4">
                            <div class="flex items-center gap-x-4">
                                <img src="<?= BASEURL . '/img/person/' . $member['image'] ?>" alt="Person1"
                                    class="w-10 h-10 object-cover rounded-full">
                                <p><?= $member['name'] ?></p>
                            </div>
                            <img src="<?= BASEURL; ?>/img/icons/delete.svg" alt="Delete">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

<script>
    document.getElementById('copyButton').addEventListener('click', function() {
        const teamCode = document.getElementById('teamCode');
        teamCode.select();
        document.execCommand('copy');
        alert('Team code copied to clipboard!');
    });
</script>