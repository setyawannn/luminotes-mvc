<div class="mt-4 flex justify-between w-full">
        <a href="<?= BASEURL; ?>/teams" class="flex gap-x-2 w-full"><img src="<?= BASEURL; ?>/img/icons/arrow-back.svg" alt="arrow-back">
            <h3 class="text-3xl w-full"><?= htmlspecialchars($data['teamData']['team']['name'] ?? 'Nama Tim Tidak Tersedia') ?></h3>
        </a>
        <a href="<?= BASEURL . '/teams/edit/' . $data['teamData']['team']['id'] ?>" class="p-2 rounded border-2"><img src="<?= BASEURL; ?>/img/icons/edit.svg" alt="Add"></a>
    </div>
    <div class="mt-4">
        <div class="flex flex-col gap-y-4">
            <p>Here's your team code copy and share to your friend</p>
            <div class="flex justify-center items-center gap-x-4">
                <input type="text" id="teamCode" placeholder="Team Code" class="p-2 border-2 w-full rounded" value="<?= $data['teamData']['team']['code'] ?? '' ?>" readonly>
                <button id="copyButton" class="px-4 py-2 rounded border-2">Copy</button>
            </div>
            <p>Invite your friends to join your study group! Add them to your team and start collaborating on notes
                and learning together.</p>
        </div>
        <div class="mt-6">
            <div class="mb-4">
                <h6>Team Leader</h6>
                <?php if (isset($data['teamData']['leader']) && $data['teamData']['leader']): ?>
                    <div class="flex items-center gap-x-4">
                        <img src="<?= $data['teamData']['leader']['image'] ?? BASEURL . '/img/person/person1.png' ?>" alt="<?= $data['teamData']['leader']['name'] ?? 'Leader' ?>"
                            class="w-10 h-10 object-cover rounded-full">
                        <p><?= $data['teamData']['leader']['name'] ?? 'Leader Tidak Ditemukan' ?></p>
                    </div>
                <?php else: ?>
                    <p>Leader tidak ditemukan.</p>
                <?php endif; ?>
            </div>
            <div>
                <h6>Team Member</h6>
                <div class="flex flex-col gap-y-4">
                    <?php if (isset($data['teamData']['members']) && !empty($data['teamData']['members'])): ?>
                        <?php foreach($data['teamData']['members'] as $member) : ?>
                            <div class="flex items-center justify-between gap-x-4">
                                <div class="flex items-center gap-x-4">
                                    <img src="<?= BASEURL; ?>/img/person/person2.png" alt="<?= $member['name'] ?? 'Member' ?>"
                                        class="w-10 h-10 object-cover rounded-full">
                                    <p><?= $member['name'] ?? 'Nama Member Tidak Tersedia' ?></p>
                                </div>
                                <button  type="button" class="remove-member-btn <?= $_SESSION['user_id'] == $member['id'] ? 'hidden' : '' ?>" data-member-id="<?= $member['id'] ?>" data-team-id="<?= $data['teamData']['team']['id'] ?>">
                                    <img src="<?= BASEURL; ?>/img/icons/delete.svg" alt="Delete">
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Belum ada anggota tim.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyButton = document.getElementById('copyButton');
    if (copyButton) {
        copyButton.addEventListener('click', function() {
            const teamCodeInput = document.getElementById('teamCode');
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(teamCodeInput.value).then(function() {
                    alert('Team code copied to clipboard!');
                });
            } 
        });
    }

    const removeMemberButtons = document.querySelectorAll('.remove-member-btn');
    removeMemberButtons.forEach(button => {
        button.addEventListener('click', function() {
            const memberId = this.dataset.memberId;
            const teamId = this.dataset.teamId;
            
            const formData = new FormData();
            formData.append('member_id', memberId);
            formData.append('team_id', teamId);

            fetch('<?= BASEURL; ?>/teams/deleteMember', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload();
                } 
            })
            .catch(error => {
                alert(error.message);
                location.reload();
            });

        });
    });
});
</script>